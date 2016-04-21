<?php
namespace Craft;

return [
    'endpoints' => [
        'artikler.json' => [
            'elementType' => 'Entry',
            'criteria' => ['section' => 'articles'],
            'transformer' => function(EntryModel $entry) {
               
                return [
                    'title' => $entry->title,
                    'summary' => (string)$entry->article_intro,
                    'description' =>  (string)$entry->article_description,
                    'url' => $entry->url,
                    'jsonUrl' => UrlHelper::getUrl("artikler/{$entry->id}.json"),
                    
                ];
            },
        ],
        'artikler/<entryId:\d+>.json' => function($entryId) {
            return [
                'elementType' => 'Entry',
                'criteria' => ['id' => $entryId],
                'first' => true,
                'transformer' => function(EntryModel $entry) {
                    return [
                        'title' => $entry->title,
                        'url' => $entry->url,
                        'summary' => $entry->(string)$entry->article_intro,
                        'body' => $entry->(string)$entry->article_description,
                    ];
                },
            ];
        },
    ]
];