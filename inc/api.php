<?php
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
     * Public: Generate api_key
     * md5 hash based on current time and userid
     *
     * $userid - username of user
     *
     * Returns the generated key
     */
    public static function gen_api_key($userid) {
        $time = time();
        $key = md5($time.$userid); // using md5 because it is shorter
        return $key;
    }

    /*
     * Public: Stores generated api key into database along with the description of use given
     *
     * $key     - api key
     * $userid  - username of user
     * $desc    - api use description
     *
     * Returns:
     *      true if successful
     *      false is not
     */
    public static function store_api_key($key, $userid, $desc) {
        global $db;
        $sql = "INSERT INTO `api_keys` (api_key,user,description,timestamp) VALUES ('".$db->escape($key)."','".$db->escape($userid)."','".$db->escape($desc)."',NOW())";
        return $db->query($sql);
    }

    /*
     * Public: Sends email to admin in successful api key generation
     * TODO
     *
     * $userid - username of user
     * $desc - api key description
     *
     *  Returns: 
     *      true if successful
     *      false is not
     */
    public static function send_api_gen_email($userid, $desc) {
        if($userid) {
            if(!LOCAL) {
                $vname = ldap_get_name($userid);
            } else {
                $vname = $userid;
            }

            $to  = ADMIN_EMAIL;

            // subject
            $subject = '[Felix api] '.$vname.' has requested an api key';

            // message
            ob_start();
            ?>

                <p><b><?php echo $vname; ?> (<?php echo $userid;?>)</b> has requested an api key for the following reason:</p>
                <p><?php echo $desc; ?></p>
                <p>xxx<p>

            <?php
            $message = ob_get_contents();
            ob_end_clean();

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Additional headers
            $headers .= "From: ".EMAIL_FROM_ADDR."\r\n" .
            'Reply-To: '.EMAIL_REPLYTO_ADDR."\r\n" .
            'X-Mailer: PHP/' . phpversion();

            // Mail it
            mail($to, $subject, $message, $headers);
            return true;
        } else {
            return false;
        }
    }

    /* Check api key */
    public static function check_key($key) {
        global $db;
        $sql = "SELECT count(*) FROM `api_keys` WHERE api_key='".$key."'";
        return $db->get_var($sql);
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
        //$key = $db->escape($get['key']);
        //$sql = "SELECT * FROM `api_keys` WHERE api_key='".$key."'";
        //$user = $db->get_row($sql);

        //$what = $get['what']; 
        //$request = json_encode($get);
        $sql = "INSERT INTO `api_log` 
                (
                    api_key,
                    what,
                    request,
                    timestamp,
                    ip
                ) VALUES (
                    '".$_REQUEST['key']."',
                    '".$class."',
                    '".json_encode($_SERVER)."',
                    NOW(),
                    '".$_SERVER['REMOTE_ADDR']."'
                )";
        return $db->query($sql);
    }
}

?>
