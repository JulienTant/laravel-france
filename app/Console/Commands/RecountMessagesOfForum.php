<?php

namespace LaravelFrance\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use LaravelFrance\ForumsTopic;

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
    protected $description = 'Command description.';

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
        $this->output->write("<info>Recounting nb messages foreach topic...</info>");
        foreach(\LaravelFrance\ForumsTopic::withCount('forumsMessages')->get() as $topic) {
            $topic->nb_messages = $topic->forums_messages_count;
            $topic->save();
        }
        $this->output->writeln("<info>OK</info>");

        $this->output->write("<info>Recounting nb messages foreach user...</info>");
        foreach(\LaravelFrance\User::withCount('forumsMessages')->get() as $user) {
            $user->nb_messages = $user->forums_messages_count;
            $user->save();
        }
        $this->output->writeln("<info>OK</info>");

    }
}
