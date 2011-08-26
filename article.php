<?php
    /*
     *  API article controller
     *  http://api.felixonline.co.uk/?what=article&id=201
     *
     *  Get article information from id
     *
     *  Returns:
     *      article_title
     *      article_teaser
     *      article_author
     *      article_author_full
     *      article_category
     *      article_category_display
     *      article_date
     *      article_image
     *          api url for article api
     *      article_content
     *      article_url
     *      article_comments
     */

    switch($data->getMethod())
    {
        // this is a request for all users, not one in particular
        case 'get':
            //$user_list = getUserList(); // assume this returns an array

            // check for article ID
            if(!isset($_GET['id'])){
                RestUtils::sendResponse(404);
            } else {

                $id = $_GET['id'];

                $article = array(
                    'article_title' => get_article_title($id),
                    'article_teaser' => get_article_teaser($id),
                    'article_author' => get_article_author_uname($id),
				    'article_author_full' => get_article_author_vname($id),
				    'article_category' => get_article_category_cat($id),
				    'article_category_display' => get_article_category($id),
				    'article_date' => get_article_publishdate($id),
                    'article_image' => '',
				    'article_content' => "<![CDATA[".clean_content2(get_article_text(($id)))."]]>",
			        'article_url' => STANDARD_URL.article_url($id),
				    'article_comments' => '',
                );

                if($data->getHttpAccept() == 'json')
                {
                    RestUtils::sendResponse(200, json_encode($article), 'application/json');
                }
                else if ($data->getHttpAccept() == 'xml')
                {
                    $xml = new MakeXml();
                    $xml->push('article');
                    foreach ($article as $key => $value) {
                        $xml->element($key, $value);
                    }
                    $xml->pop();

                    RestUtils::sendResponse(200, $xml->getXml(), 'application/xml');
                }
            }
            break;
        // new user create
        case 'post':
            $user = new User();
            $user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
            // and so on...
            $user->save();

            // just send the new ID as the body
            RestUtils::sendResponse(201, $user->getId());
            break;
    }
