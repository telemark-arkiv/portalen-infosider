<?php
namespace Craft;

return [
    'endpoints' => [
        'artikler.json' => [
            'elementType' => 'Entry',
            'paginate' => true,
            'criteria' => [
                            'section' => 'articles',
                            'search' => buildSeachQuery(),
                           
                          ],
            'transformer' => function(EntryModel $entry) {
              $arrTags = getTags($entry->tags);

              $arrBlocks = getMatrix($entry->article_blocks);

              return [
                    'title' => $entry->title,
                    'summary' => (string)$entry->article_intro,
                    'description' =>  (string)$entry->article_description,
                    'tags' => $arrTags,
                    'url' => $entry->url,
                    'matrixData' => $arrBlocks,
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

function buildSeachQuery(){
  $strQuery = "";
  if(isset($_GET['channel'])) {
    $strGetTags = $_GET['channel'];
    $arrTags = explode(',', $strGetTags);  
    $strQuery .= "article_type:'".strtolower($arrTags[0])."'";
  } 
  if(isset($_GET['tags'])) {
    if(isset($_GET['channel']))
      $strQuery .=" ( ";

    $strGetTags = $_GET['tags'];
    $arrTags = explode(',', $strGetTags);
    
    foreach ($arrTags as $key=>$tag) {
      
      $strQuery .= "tags:'".strtolower($tag)."'";
      if($key != count($arrTags)-1)
          $strQuery .=" OR ";
      
    }
    if(isset($_GET['channel']))
      $strQuery .=" )";

  }
  return $strQuery;
}

/**
 * [getTags description]
 * @param  [type] $tags [description]
 * @return [type]       [description]
 */
function getTags($tags) {
    $arrTags = array();
       foreach($tags as $tag) {
            $arrTags[] = strtolower($tag->title);
       }

    return $arrTags;
}

/**
 * [getMatrix description]
 * @param  [type] $arrMatrix [description]
 * @return [type]            [description]
 */
function getMatrix($arrMatrix) {
    $arrMatrixData = array();
    $nCounter = 0;
    foreach ( $arrMatrix as $block) {
       
        if($block->type == 'textBlock') {
            
         //   $arrMatrixData[]['type'] = ;
            $arrMatrixData[$nCounter]['textContent'] = strip_tags((string)$block->text);
             $nCounter++;
        }
        else if($block->type == 'htmlBlock') {
            
         //   $arrMatrixData[]['type'] = ;
            $arrMatrixData[$nCounter]['htmlContent'] = (string)$block->html;
             $nCounter++;
        }
        else if($block->type == 'imageBlock') {
                foreach($block->image as $image) {
                    $strImageUrl = $image->url;
                }
            $arrMatrixData[$nCounter]['image'] = $strImageUrl;
            $arrMatrixData[$nCounter]['image_text'] = (string)$block->imageText;
             $nCounter++;
        }
      
       
    }

    return $arrMatrixData;
}
