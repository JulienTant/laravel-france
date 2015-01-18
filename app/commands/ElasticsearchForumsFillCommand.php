<?php

use Illuminate\Console\Command;
use Lvlfr\Forums\Models\Topic;

class ElasticsearchForumsFillCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'elasticsearch:forums:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill the elastic search index with forums data';

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
     * @return void
     */
    public function fire()
    {
        if (Elasticsearch::indices()->exists(['index' => 'forums'])) {
            Elasticsearch::indices()->delete(['index' => 'forums']);
        }

        /** @var \Elasticsearch\Namespaces\IndicesNamespace $indices */
        $indices = Elasticsearch::indices();
        $indices->create([
                'index' => 'forums',
                'body' => [
                    'mappings' => [
                        'messages' => [
                            'properties' => [
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'french'
                                ],
                                'message' => [
                                    'type' => 'string',
                                    'analyzer' => 'french'
                                ],
                                'updated_at' => ["type" => "date", "format" => "yyyy-MM-dd HH:mm:ss"]
                            ]
                        ]
                    ]
                ]
            ]
        );


        /** @var Topic $topic */
        foreach (Topic::with('messages')->get() as $topic) {
            $topic->indexInSearchEngine();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
