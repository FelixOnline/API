<?php
/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        if(array_key_exists('id', $matches)) { // if specific article
            $article = new Article($matches['id']);
            $output = array(
                'article_title' => $article->getTitle(),
                'article_teaser' => $article->getTeaserFull(),
                'article_authors' => $article->getAuthors(),
                'article_category' => $article->getCategoryCat(),
                'article_category_display' => $article->getCategoryLabel(),
                'article_publish_date' => $article->getPublishdate(),
                'article_image_id' => ' ',
                'article_content' => ' ',
                'article_url' => $article->getURL(),
                'article_comment_num' => '',
            );

            RestUtils::sendResponse(
                200, 
                json_encode($output), 
                'application/json'
            );
        } else {
            echo 'All articles';
        }
    }
}
?>
