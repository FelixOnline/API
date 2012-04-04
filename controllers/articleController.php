<?php
/*
 * Article Controller
 */
class articleController extends BaseController {
    function GET($matches) {
        global $db;
        if(array_key_exists('id', $matches)) { // if specific article
            $article = new Article($matches['id']);
            $output = $article->getOutput();
            /*
            $output = array(
                'article_title' => $article->getTitle(),
                'article_teaser' => $article->getTeaserFull(),
                'article_authors' => $article->getAuthors(),
                'article_category' => $article->getCategoryCat(),
                'article_category_display' => $article->getCategoryLabel(),
                'article_publish_date' => $article->getPublished(),
                'article_image_id' => ' ',
                'article_content' => ' ',
                'article_url' => $article->getURL(),
                'article_comment_num' => '',
            );
             */

            RestUtils::sendResponse(
                200, 
                json_encode($output), 
                'application/json'
            );
        } else if(array_key_exists('cat', $matches)) { // category articles
            $category = new Category($matches['cat']);
            $output = array();
            $sql = "
                    SELECT 
                        id 
                    FROM 
                        `article`
                    WHERE
                        category = ".$category->getId()."
                    ORDER BY 
                        date DESC,
                        id DESC
                    LIMIT 0, 10
                ";
            foreach($db->get_results($sql) as $key => $object) {
                $article = new Article($object->id);
                $output[] = $article->getOutput();
            }

            $output['top_stories'] = array();
            foreach($category->getTopStories() as $key => $article) {
                $index = str_replace('top_story_', '', $key);
                $output['top_stories'][$index] = $article->getOutput();
            }
            RestUtils::sendResponse(
                200, 
                json_encode($output), 
                'application/json'
            );
        } else {
            $output = array();
            $sql = "
                    SELECT 
                        id 
                    FROM 
                        `article`
                    ORDER BY 
                        date DESC,
                        id DESC
                    LIMIT 0, 10
                ";
            foreach($db->get_results($sql) as $key => $object) {
                $article = new Article($object->id);
                $output[] = $article->getOutput();
            }
            RestUtils::sendResponse(
                200, 
                json_encode($output), 
                'application/json'
            );
        }
    }
}
?>
