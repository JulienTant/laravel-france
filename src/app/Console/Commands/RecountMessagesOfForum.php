<?php

namespace LaravelFrance\Console\Commands;

use Illuminate\Console\Command;
use LaravelFrance\ForumsTopic;
use LaravelFrance\User;

class RecountMessagesOfForum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-france:forum:recount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recount the number of messages for each topics & users';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $errors = ["topics" => [], "users" => []];
        $this->output->write("<info>Recounting nb messages foreach topic...</info>");
        foreach (ForumsTopic::withCount('forumsMessages')->get() as $topic) {
            $old = $topic->nb_messages;
            $topic->nb_messages = $topic->forums_messages_count;
            $topic->save();

            if ($topic->nb_messages != $old) {
                $errors["topics"][] = " #" . $topic->id . " - " . $topic->title . " : $old => " . $topic->nb_messages;
            }
        }
        $warnOrInfo = count($errors["topics"]) > 0 ? "warning" : "info";
        $this->output->writeln("<$warnOrInfo>OK</$warnOrInfo>");


        $this->output->write("<info>Recounting nb messages foreach user...</info>");
        foreach (User::withCount('forumsMessages')->get() as $user) {
            $old = $user->nb_messages;
            $user->nb_messages = $user->forums_messages_count;
            $user->save();

            if ($user->nb_messages != $old) {
                $errors["users"][] = "#" . $user->id . " - " . $user->username . " : $old => " . $user->nb_messages;
            }

        }
        $warnOrInfo = count($errors["users"]) > 0 ? "warning" : "info";
        $this->output->writeln("<$warnOrInfo>OK</$warnOrInfo>");

        foreach ($errors as $errorsByType) {
            if (count($errorsByType) > 0) {
                $this->line('');
                break;
            }
        }

        foreach ($errors as $type => $errorsOftype) {
            if (count($errorsOftype) > 0) {
                $this->warn(ucfirst($type));
                foreach ($errorsOftype as $error) {
                    $this->warn("└─" . $error);
                }
            }
        }
    }
}
