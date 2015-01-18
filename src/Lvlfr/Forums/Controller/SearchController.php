<?php

namespace Lvlfr\Forums\Controller;

use Input;
use Lvlfr\Forums\Models\Topic;
use View;

class SearchController extends \BaseController
{
    public function search()
    {
        $q = Input::get('q');

        if (!strlen($q)) {
            \App::abort(404);
        }

        $results = \Elasticsearch::search([
            'index' => 'forums',
            'type' => 'messages',
            'body' => [
                'size' => 100, // nb per page
                //'from' => 5, // (page-1) * nb per page
                'query' => [
                    'multi_match' => [
                        'query' => $q,
                        'fields' => ["title", "message"]
                    ]
                ],
                'sort' => [
                    '_score' => [
                        'order' => 'desc'
                    ],
                    'updated_at' => [
                        'order' => 'desc'
                    ]
                ]
            ]
        ]);

        $list = [];
        foreach ($results['hits']['hits'] as $result) {
            $list[] = Topic::find($result['_id']);
        }

        return View::make('LvlfrForums::results', [
            'topics' => $list,
            'q' => $q
        ]);
    }

}
