<?php
namespace FelixOnline\API;

/*
 * API Utility class
 * Author: Jonathan Kim
 * Date: 29/12/2011
 */
class API {
    /*
     * Public: Generate random string
     *
     * $length - length of random string. Defaults to 20
     *
     * Returns string
     */
    public static function gen_random_string($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }

    /*
     * Log api request
     * 
     * Requires: 
     *      $get - $_GET array from request
     *
     */
    public static function log_api_request($class) {
        global $db;

        $sql = "INSERT INTO `api_log` 
                (
                    what,
                    request,
                    timestamp
                ) VALUES (
                    '".$class."',
                    '".json_encode($_SERVER)."',
                    NOW()
                )";
        return $db->query($sql);
    }

    /*
     * Render documentation template
     *
     * Returns html content
     */
    public static function render($template) {
        $markdown = file_get_contents(API_DIRECTORY.'/docs/templates/'.$template.'.mkd');
        $content = Markdown($markdown);
        return $content;
    }
    /*
     * Generate an exception error
     */
    public static function error($code, $message, $e, $log_error = false) {
        $output = array();
        $output['error'] = 1;
        $output['error_code'] = $code;
        $output['message'] = $message;

        RestUtils::sendResponse(
            $code, 
            json_encode($output), 
            'application/json'
        );

        if($log_error) {
            $sentry = new \Raven_Client(API_SENTRY_DSN);

            $sentry->captureException($exception);
        }
    }
}

?>
