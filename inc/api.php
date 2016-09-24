<?php
namespace FelixOnline\API;

define('API_VERSION', 0.5);
if(!defined('API_NAME')): define('API_NAME', 'Felix Online API'); endif;
if(!defined('API_COPYRIGHT')): define('API_COPYRIGHT', '(c) Felix Online'); endif;

/*
 * Pagination helper - wraps around managers
 * Author: Philip Kent
 * Date: 24/09/2016
 */
class PaginatorWrapper {
    private $manager = false;
    private $id;

    private $since = false; // First
    private $max = false; // Last

    public function __construct($id = 'id') { // set primary key
        $this->id = $id;
    }

    public function setManager(\FelixOnline\Core\BaseManager $manager) {
        $this->manager = $manager;

        return($this);
    }

    /*
     * Public: Apply pagination and return values
     *
     * Returns array
     */
    public function values() {
        if(!$this->manager) {
            throw new \FelixOnline\Exceptions\InternalException('Must set manager before using the PaginatorWrapper');
        }

        if(isset($_GET['after'])) { // Get records after this ID
            $this->manager->filter($this->id.' > "%s"', array($_GET['after']));
        } elseif(isset($_GET['before'])) { // Get records before this ID
            $this->manager->filter($this->id.' < "%s"', array($_GET['before']));
        }

        if(isset($_GET['limit'])) {
            $this->manager->limit(0, $_GET['limit']);
        } else {
            $this->manager->limit(0, 10);
        }

        $values = $this->manager->values();

        if($values) {
            $one = end($values);
            $one = $one->fields[$this->id]->getRawValue();

            $two = reset($values);
            $two = $two->fields[$this->id]->getRawValue();

            // The largest item goes as max
            if($one > $two) {
                $this->since = $two;
                $this->max = $one;
            } else {
                $this->since = $one;
                $this->max = $two;
            }
        } else {
            throw new \FelixOnline\Exceptions\InternalException('No items');
        }

        return $values;
    }

    public function max() {
        if(!$this->max) {
            throw new \FelixOnline\Exceptions\InternalException('Must run values() before max()');
        }

        return $this->max;
    }

    public function since() {
        if(!$this->since) {
            throw new \FelixOnline\Exceptions\InternalException('Must run values() before since()');
        }

        return $this->since;
    }
}

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
        $app = \FelixOnline\Core\App::getInstance();
        $db = $app['db'];

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
     * Output the response with correct code and format
     * Just json for now
     */
    public static function output(array $data, $since = null, $max = null) {
        $data = array('error' => 0, 'output' => $data);

        // Pagination
        if(!is_null($since) && !is_null($max)) {
            $data['since'] = $since;
            $data['max'] = $max;
        }

        RestUtils::sendResponse(
            200, 
            json_encode($data), 
            'application/json'
        );
    }

    /*
     * Outputs version number
     */
    public static function version() {
        $data = array('version' => API_VERSION, 'name' => API_NAME, 'copyright' => API_COPYRIGHT);

        RestUtils::sendResponse(
            200, 
            json_encode($data), 
            'application/json'
        );
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
