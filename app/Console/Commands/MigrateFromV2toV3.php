<?php

namespace LaravelFrance\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsTopic;
use LaravelFrance\Group;
use LaravelFrance\User;
use League\HTMLToMarkdown\HtmlConverter;

class MigrateFromV2toV3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-france:migration:to-v3  {--pretend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate from Laravel France v2 to Laravel France v3.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $host = $this->forceAsk('old DB host');
        $database = $this->forceAsk('old DB database');
        $username = $this->forceAsk('old DB username');
        $password = $this->forceAsk('old DB password', true);

        \Config::set('database.connections.old_mysql', [
            'driver' => 'mysql',
            'host' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ]);

        $oldConnection = \DB::connection('old_mysql');
        $newConnection = \DB::connection(\Config::get('database.default'));


        if ($this->option('pretend')) {
            $newConnection->beginTransaction();
        }

        $this->call('migrate');
        $this->call('migrate:refresh');


        $this->migrateUsers($oldConnection, $newConnection);
        $this->migrateoAuth($oldConnection, $newConnection);
        $this->giveEveryoneNoGroup($oldConnection, $newConnection);
        $this->defineSuperAdmin();


        $this->migrateForumsCategories($oldConnection, $newConnection);
        $this->migrateForumsTopics($oldConnection, $newConnection);
        $this->migrateForumsMessages($oldConnection, $newConnection);


        $this->removeEmptyTopics($newConnection);
        $this->removeSpammyTopics($newConnection);

        $this->computeNbMessagesForTopics($newConnection);
        $this->computeLastMessageForTopics($newConnection);
        $this->computeSolvedBy($newConnection);
        $this->computeUsersMessages($newConnection);

        $this->buildElasticsearchIndex();

        if ($this->option('pretend')) {
            $newConnection->rollBack();
        }
    }

    public function forceAsk($question, $secure = false)
    {
        do {
            $answer = trim(
                !$secure ? $this->ask($question) : $this->secret($question, true)
            );
        } while (strlen($answer) == 0);

        return $answer;
    }

    /**
     * @param $oldConnection
     * @param $newConnection
     */
    private function migrateUsers($oldConnection, $newConnection)
    {
        $this->info('> Transfering Users');
        $nbUsers = $oldConnection->table('users')->count(['id']);
        $bar = $this->output->createProgressBar($nbUsers);

        $changedUsername = [];
        $changedUsernameDuplicate = [];
        $oldConnection->table('users')->chunk(1, function ($oldUsers) use ($newConnection, $bar, &$changedUsername, &$changedUsernameDuplicate) {

            foreach ($oldUsers as &$user) {
                $user = (array)$user;
                $originalUserName = $user['username'];
                $user['username'] = preg_replace('/\s+/', '', $user['username']);
                if ($originalUserName != $user['username']) {
                    $changedUsername[] = ['id' => $user['id'], 'old' => $originalUserName, 'new' => $user['username']];
                }
                unset($user['canUpdateWiki']);
            }

            try {
                $newConnection->table('users')->insert($oldUsers);
            } catch (\Illuminate\Database\QueryException $q) {
                if ($q->getCode() == 23000 && str_contains($q->getMessage(), 'Duplicate entry')) {
                    $old = $oldUsers[0]['username'];
                    $oldUsers[0]['username'] .= '_dup_'.str_random(2);
                    $changedUsernameDuplicate[] = ['id' => $oldUsers[0]['id'], 'old' => $old, 'new' => $oldUsers[0]['username']];
                    $newConnection->table('users')->insert($oldUsers[0]);
                }
            }
            $bar->advance(count($oldUsers));

            unset($oldUsers);
        });

        foreach($changedUsername as $usernames) {
            $this->line('Changement de username par suppression d\'espace pour #' . $usernames['id'] . ' : ' . $usernames['old'] . ' => ' . $usernames['new']);
        }

        foreach($changedUsernameDuplicate as $usernames) {
            $this->line('Changement de username cause duplicata pour #' . $usernames['id'] . ' : ' . $usernames['old'] . ' => ' . $usernames['new']);
        }

        $this->line('');
        $this->line('');
        unset($bar);
    }

    private function migrateoAuth($oldConnection, $newConnection)
    {
        $this->info('> Transfering OAuth');
        $nbOAuth = $oldConnection->table('oauth')->count(['id']);
        $bar = $this->output->createProgressBar($nbOAuth);
        $oldConnection->table('oauth')->chunk(100, function ($oldOAuth) use ($newConnection, $bar) {

            foreach ($oldOAuth as &$oauth) {
                $oauth = (array)$oauth;
                unset($oauth['access_token']);
                unset($oauth['secret']);
            }

            $newConnection->table('oauth')->insert($oldOAuth);
            $bar->advance(count($oldOAuth));

            unset($oldOAuth);
        });
        $this->line('');
        $this->line('');
        unset($bar);
    }

    private function migrateForumsCategories($oldConnection, $newConnection)
    {
        $this->info('> Transfering Forums Categories');

        $nbForumsCategories = $oldConnection->table('forum_categories')->count(['id']);
        $bar = $this->output->createProgressBar($nbForumsCategories);
        $oldConnection->table('forum_categories')->chunk(100, function ($oldForumCategories) use ($newConnection, $bar) {

            foreach ($oldForumCategories as &$forumCategory) {
                $forumCategory = (array)$forumCategory;
                $forumCategory['name'] = $forumCategory['title'];
                $forumCategory['description'] = $forumCategory['desc'];
                unset($forumCategory['title']);
                unset($forumCategory['desc']);
                unset($forumCategory['nb_topics']);
                unset($forumCategory['nb_posts']);
                unset($forumCategory['lm_user_name']);
                unset($forumCategory['lm_user_id']);
                unset($forumCategory['lm_topic_name']);
                unset($forumCategory['lm_topic_slug']);
                unset($forumCategory['lm_topic_id']);
                unset($forumCategory['lm_post_id']);
                unset($forumCategory['lm_date']);
            }

            $newConnection->table('forums_categories')->insert($oldForumCategories);
            $bar->advance(count($oldForumCategories));

            unset($oldForumCategories);
        });
        $this->line('');

        $this->info('> Assigning colors');

        $colors = [
            '#D24D57' => '#FFF',
            '#19B5FE' => '#FFF',
            '#26C281' => '#FFF',
            '#FFB61E' => '#FFF',
            '#6C7A89' => '#FFF',
            '#4B77BE' => '#FFF',
            '#87D37C' => '#FFF',
            '#9B59B6' => '#FFF',
            '#C93756' => '#FFF',
        ];
        /** @var ForumsCategory $category */
        foreach(ForumsCategory::orderBy('order', 'ASC')->get() as $category) {
            reset($colors);
            $background = key($colors);
            $front = array_shift($colors);

            $category->background_color = $background;
            $category->font_color = $front;

            $category->save();
        }




        $this->line('');
        $this->line('');
        unset($bar);
    }

    private function migrateForumsTopics($oldConnection, $newConnection)
    {

        $this->info('> Transfering Forums Topics');

        $nbForumsTopics = $oldConnection->table('forum_topics')->count(['id']);
        $bar = $this->output->createProgressBar($nbForumsTopics);
        $oldConnection->table('forum_topics')->chunk(100, function ($oldForumTopics) use ($newConnection, $bar) {

            foreach ($oldForumTopics as &$forumTopic) {
                $forumTopic = (array)$forumTopic;

                $forumTopic['forums_category_id'] = $forumTopic['forum_category_id'];
                unset($forumTopic['forum_category_id']);

                $forumTopic['slug'] = $forumTopic['id'];

                unset($forumTopic['nb_messages']);
                unset($forumTopic['nb_views']);
                unset($forumTopic['lm_user_name']);
                unset($forumTopic['lm_user_id']);
                unset($forumTopic['lm_post_id']);
                unset($forumTopic['lm_date']);
                unset($forumTopic['solvedBy']);
            }

            $newConnection->table('forums_topics')->insert($oldForumTopics);
            $bar->advance(count($oldForumTopics));

            unset($oldForumTopics);
        });
        $this->line('');
        $this->info('> Rebuilding slugs');

        $topics = ForumsTopic::orderBy('created_at', 'DESC')->get();
        $bar = $this->output->createProgressBar($topics->count());
        /** @var ForumsTopic $topic */
        foreach($topics as $topic) {
            $topic->resluggify(true)->save();;
            $bar->advance();
        }

        $this->line('');
        $this->line('');
        unset($bar);
    }

    private function migrateForumsMessages($oldConnection, $newConnection)
    {
        $this->info('> Transfering Forums Messages');

        $nbForumsMessages = $oldConnection->table('forum_messages')->count(['id']);
        $bar = $this->output->createProgressBar($nbForumsMessages);
        $oldConnection->table('forum_messages')->chunk(100, function ($oldForumMessages) use ($newConnection, $bar) {

            foreach ($oldForumMessages as &$forumMessage) {
                $forumMessage = (array)$forumMessage;

                $forumMessage['forums_topic_id'] = $forumMessage['forum_topic_id'];
                unset($forumMessage['forum_topic_id']);
                unset($forumMessage['forum_category_id']);


                $forumMessage['solve_topic'] = $forumMessage['solveTopic'];
                unset($forumMessage['solveTopic']);


                $converter = new HtmlConverter();
                $forumMessage['markdown'] = $converter->convert($forumMessage['html']);
                unset($forumMessage['bbcode']);
                unset($forumMessage['html']);
            }

            $newConnection->table('forums_messages')->insert($oldForumMessages);
            $bar->advance(count($oldForumMessages));

            unset($oldForumMessages);
        });
        $this->line('');
        $this->line('');
        unset($bar);

    }

    private function removeEmptyTopics(Connection $newConnection)
    {
        $this->info('> Removing Empty Topics');

        $nb = $newConnection->table('forums_topics')->whereRaw(
            '(SELECT COUNT(id) FROM forums_messages where forums_topic_id = forums_topics.id) = 0'
        )->delete();

        $this->comment('> '. $nb .' topics removed');
        $this->line('');
        $this->line('');
    }

    private function computeLastMessageForTopics(Connection $newConnection)
    {
        $this->info('> Compute Last message for each topics');

        $nbTopics = $newConnection->table('forums_topics')->count(['id']);
        $bar = $this->output->createProgressBar($nbTopics);
        $topics = $newConnection->table('forums_topics')->select(['id'])->get();
        foreach($topics as $topic) {
            $message = $newConnection->table('forums_messages')->where('forums_topic_id', $topic->id)->orderBy('created_at', 'DESC')->first(['id']);
            $newConnection->table('forums_topics')->where('id', $topic->id)->update(['last_message_id' => $message->id]);
            $bar->advance();
        }
        $this->line('');
        $this->line('');
        unset($bar, $topics);
    }

    private function computeSolvedBy(Connection $newConnection)
    {
        $this->info('> Compute Solved By');


        $messages = $newConnection->table('forums_messages')->where('solve_topic', true)->orderBy('updated_at', 'DESC')->get();
        $bar = $this->output->createProgressBar(count($messages));

        foreach($messages as $message) {
            $newConnection->table('forums_topics')->where('id', $message->forums_topic_id)->update(['solved' => true, 'solved_by' => $message->id]);
            $bar->advance();
        }
        $this->line('');
        $this->line('');
        unset($bar, $messages);
    }

    private function computeUsersMessages(Connection $newConnection)
    {
        $this->info('> Reset nb messages count of users');
        $newConnection->table('users')->update(['nb_messages' => 0]);

        $this->info('> Calculate new sum');
        $usersWithNbMessages = $newConnection->query()->selectRaw('user_id, COUNT(id) as nb_messages')->from('forums_messages')->groupBy('user_id')->orderBy('nb_messages', 'DESC')->get();

        $bar = $this->output->createProgressBar(count($usersWithNbMessages));
        foreach($usersWithNbMessages as $userWithNbMessage) {
            $newConnection->table('users')->where('id', $userWithNbMessage->user_id)->update(['nb_messages' => $userWithNbMessage->nb_messages]);
            $bar->advance();
        }
        $this->line('');
        $this->line('');
        unset($bar, $usersWithNbMessages);
    }

    private function buildElasticsearchIndex()
    {
        $this->info('> Rebuild Elasticsearch indices...');

        $this->call('laravel-france:index:rebuild');

        $this->info('> ... Done !');
        $this->line('');
        $this->line('');
    }

    private function removeSpammyTopics($newConnection)
    {
        $this->info('> Removing Empty Topics');

        $nb = $newConnection->table('forums_topics')
            ->where('title', 'LIKE', '%permis%')
            ->Orwhere('title', 'LIKE', '%PASSER SON EXAMEN DE CONDUITE%')
            ->Orwhere('title', 'LIKE', '%Message supprimé%')
            ->Orwhere('title', 'LIKE', '%Provide Expert Laravel%')
            ->delete();

        $this->comment('> '. $nb .' spams removed');
        $this->line('');
        $this->line('');
    }

    private function computeNbMessagesForTopics(Connection $newConnection)
    {
        $this->info('> Compute Nb message per Topics ...');
        $nb = $newConnection->statement(
            'UPDATE forums_topics SET nb_messages = (SELECT COUNT(id) FROM forums_messages WHERE forums_topic_id = forums_topics.id);'
        );
        $this->info('> ... Done');

    }

    private function defineSuperAdmin()
    {
        $this->line('> Define user 1 as SuperAdmin...');
        /** @var User $user */
        $user = User::find(1);
        $user->groups = [Group::SUPERADMIN];
        $user->save();
        $this->line(' ');
        $this->line(' ');
    }

    private function giveEveryoneNoGroup($oldConnection, $newConnection)
    {
        User::all()->each(function($user) {
            $user->groups = [];
            $user->save();
        });
    }
}
