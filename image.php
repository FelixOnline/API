<?php
    /*
     *  API image controller
     *  http://api.felixonline.co.uk/?what=image&id=1279
     *
     *  See docs
     */

    switch($data->getMethod()) {
        // this is a request for certain article based on ID
        case 'get':
            // check for article ID
            if(!isset($_GET['id'])){
                RestUtils::sendResponse(404);
            } else {
                $id = $_GET['id'];

                if ($_GET['width']) {
                    $url = get_img_url($id, $_GET['width']);
                } else {
                    $url = get_img_url($id);
                }

                $image = array(
                    'image_url' => $url,
                    'image_caption' => get_img_caption($id),
                    'image_credit' => get_img_attr($id),
                    'image_credit_link' => get_img_attr_link($id),
                    'original_image' => get_img_url($id)
                );

                RestUtils::sendResponse(200, json_encode($image), 'application/json');
            }
            break;
    }
