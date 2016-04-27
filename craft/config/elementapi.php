<?php
namespace Craft;

return [
    'endpoints' => [
        'artikler.json' => [
            'elementType' => 'Entry',
            'criteria' => ['section' => 'articles'],
            'transformer' => function(EntryModel $entry) {
               $arrTags = getTags($entry->tags);
                return [
                    'title' => $entry->title,
                    'summary' => (string)$entry->article_intro,
                    'description' =>  (string)$entry->article_description,
                    'tags' => $arrTags,
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
                        'summary' => (string)$entry->article_intro,
                        'body' => (string)$entry->article_description,
                    ];
                },
            ];
        },
    ]
];
function getTags($tags) {
    $arrTags = array();
       foreach($tags as $tag) {
            $arrTags[] = $tag->title;
       }

    return $arrTags;
}