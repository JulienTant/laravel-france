<?php

namespace LaravelFrance\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use LaravelFrance\ForumsTopic;

class RebuildElasticSearchIndexes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-france:index:rebuild';

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
        /** @var Client $client */
        $client = app('elastic');


        $this->info('Recreationg the index');
        $this->rebuildIndex($client);

        $this->info('Indexing Forums Topics');
        $this->handleForumsTopic();
    }

    private function handleForumsTopic()
    {
        ForumsTopic::rebuildMapping();
        ForumsTopic::all()->index();
    }

    /**
     * @param $client
     */
    private function rebuildIndex($client)
    {
        if ($client->indices()->exists(['index' => 'laravel-france'])) {
            $client->indices()->delete(['index' => 'laravel-france']);
        }
        /** @var \Elasticsearch\Namespaces\IndicesNamespace $indices */
        $indices = $client->indices();
        $indices->create([
            'index' => 'laravel-france',
            'body' => [
                'settings' => [
                    'number_of_shards' => 5,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'analyzer' => [
                            'default' => [
                                'type' => 'french',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

}
