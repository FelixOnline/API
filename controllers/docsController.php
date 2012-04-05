<?php
/*
 * Documentation Controller
 */
class docsController {
    function GET() {
        global $currentuser;
        require_once(API_DIRECTORY.'/docs/markdown.php');
        require_once(API_DIRECTORY.'/docs/docs.php');
    }
    
    function POST() {
        if(isset($_POST['keygen'])) {
            $keygen = gen_api_key(is_logged_in());
            if(!store_api_key($keygen, is_logged_in(), $_POST['desc'])){
                echo 'ERROR';
            } else {
                send_api_gen_email(is_logged_in(), $_POST['desc']); // Send email confirmation
            }
        }
    }
}
