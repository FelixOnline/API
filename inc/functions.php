<?php
/*
	API functions
	Author: Jonathan Kim
	Date: 04/06/2011
*/

/* ---------------------------------------------------------- */
/* General api functions { */
/* ---------------------------------------------------------- */

/* Generate api key */
function gen_random_string() {
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

/*
 * Generate api_key
 * md5 hash based on current time and userid
 *
 * Returns the generated key
 */
function gen_api_key($userid) {
    $time = time();
    $key = md5($time.$userid); // using md5 because it is shorter
    return $key;
}

/*
 * Stores generated api key into database along with the description of use given
 *
 * Requires: 
 *      $key
 *      $userid
 *      $desc
 *
 * Returns:
 *      true if successful
 *      false is not
 *
 */
function store_api_key($key, $userid, $desc) {
	global $dbok,$cid;
    $sql = "INSERT INTO `api_keys` (api_key,user,description,timestamp) VALUES ('$key','$userid','$desc',NOW())";
    if(mysql_query($sql,$cid)) {
        return true;
    } else {
        return false;
    }
}

/*
 * Sends email to admin in successful api key generation
 *
 * Requires:
 *      $userid
 *      $desc
 *
 *  Returns: 
 *      true if successful
 *      false is not
 *
 */
function send_api_gen_email($userid, $desc) {
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
function check_key($key) {
	global $dbok,$cid;
    $sql = "SELECT * FROM `api_keys` WHERE api_key='".$key."'";
    return mysql_num_rows(mysql_query($sql, $cid));
}

/*
 * Log api request
 * 
 * Requires: 
 *      $get - $_GET array from request
 *
 */
function log_api_request($get) {
	global $dbok,$cid;
    $key = $get['key'];
    $sql = "SELECT * FROM `api_keys` WHERE api_key='".$key."'";
	$user = mysql_fetch_array(mysql_query($sql,$cid));

    $userid = $user['id'];
    $what = $get['what']; 
    $request = json_encode($get);
    $sql = "INSERT INTO `api_log` (user_id,what,request,timestamp) VALUES ('$userid','$what','$request',NOW())";

    if(mysql_query($sql,$cid)) {
        return true;
    } else {
        return false;
    }
}

function is_logged_in() { // returns active user or false
    if ($_SESSION['felix']['loggedin'])
        return $_SESSION['felix']['uname'];
    else
        return false;
}

function get_vname() {
    return $_SESSION['felix']['vname'];
}

function user_has_key($uname) {
    global $dbok,$cid;
    $sql = "SELECT api_key FROM `api_keys` WHERE user='".$uname."'";
    if (mysql_num_rows(mysql_query($sql, $cid))) {
		return mysql_result(mysql_query($sql,$cid),0);
    } else {
       return false;
    };
}

function set_session($session,$user) {
    global $cid;
    $user = strtolower($user);
    if ($session != "" && $user != "")
        if (mysql_query("INSERT INTO `login` (session_id,user) VALUES ('$session','$user')",$cid))
            return true;
    return false;
}

function get_user_from_session($session) {
    global $cid;
    $sql = "SELECT user FROM `login` WHERE session_id='$session' ORDER BY id DESC LIMIT 1";
    return mysql_result(mysql_query($sql,$cid),0);
}

function is_session_recent($session) {
    global $cid;
    $sql = "SELECT TIMESTAMPDIFF(SECOND,timestamp,NOW()) AS timediff FROM `login` WHERE session_id='$session' AND valid=1 ORDER BY timediff ASC LIMIT 1";
    $result = mysql_query($sql,$cid);
    if (mysql_num_rows($result)) {
        $session_age = mysql_result($result,0);
        return ($session_age <= SESSION_LENGTH);
    }
    else
        return false;
}

function destroy_sessions($user) {
    global $cid;
    return mysql_query("UPDATE login SET valid=0 WHERE user='$user'",$cid);
}

function destroy_old_sessions($user) {
    global $cid;
    return mysql_query("UPDATE login SET valid=0 WHERE user='$user' AND timestamp < TIMESTAMPADD(SECOND,-30,NOW())",$cid);
}

function login($username) {
    if (!($_SESSION['felix']['vname'] = get_vname_by_uname_ldap($username)))
        return false;
    $_SESSION['felix']['name'] = get_forename($username);
    $_SESSION['felix']['uname'] = $username;
    $_SESSION['felix']['loggedin'] = true;
    destroy_old_sessions($username);
    update_login_name($username,$_SESSION['felix']['vname']);
    return true;
}

function update_login_name($user,$name) {
    global $cid;
    $ip = $_SERVER['REMOTE_ADDR'];
    $name = trim($name);
    $sql = "INSERT INTO `user` (user,name,visits,ip) VALUES ('$user','$name',1,'$ip') ON DUPLICATE KEY UPDATE name='$name',visits=visits+1,ip='$ip',timestamp=NOW()";
    return($user && $name && mysql_query($sql,$cid));
}

function get_vname_by_uname_ldap($uname) {
    $ds=ldap_connect("addressbook.ic.ac.uk");
    $r=ldap_bind($ds);
    $justthese = array("gecos");
    $sr=ldap_search($ds, "ou=People, ou=everyone, dc=ic, dc=ac, dc=uk", "uid=$uname", $justthese);
    $info = ldap_get_entries($ds, $sr);
    if ($info["count"] > 0)
        return $info[0]['gecos'][0];
    else
        return false;
}

function get_forename($uname) {
    $ds=ldap_connect("addressbook.ic.ac.uk");
    $r=ldap_bind($ds);
    $justthese = array("givenname");
    $sr=ldap_search($ds, "o=Imperial College, c=GB", "uid=$uname", $justthese);
    $info = ldap_get_entries($ds, $sr);
    if ($info["count"] > 0)
        return $info[0][givenname][0];
    else
        return $uname;
}

function logout() {
    if ($user = $_SESSION['felix']['uname'])
        destroy_sessions($user);
    $_SESSION['felix']['loggedin'] = false;
    if(isset($_COOKIE['felixonline']))
        setcookie("felixonline", "", time(), "/");
}

function re_login($username) {
    if (!($_SESSION['felix']['vname'] = get_vname_by_uname_ldap($username)))
        return false;
    $_SESSION['felix']['name'] = get_forename($username);
    $_SESSION['felix']['uname'] = $username;
    $_SESSION['felix']['loggedin'] = true;
    return true;
}

/* For use in example calls.
 * If user is logged in and has a key then return that key. Else return 'API_KEY'.
 */
function get_api_key() {
    global $dbok,$cid;
    $uname = is_logged_in();
    $sql = "SELECT api_key FROM `api_keys` WHERE user='".$uname."'";
    if (mysql_num_rows(mysql_query($sql, $cid))) {
		return mysql_result(mysql_query($sql,$cid),0);
    } else {
       return 'API_KEY';
    };
}

function curPageURLNonSecure() {
    return 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

/* ---------------------------------------------------------- */
/* } END of general functions */
/* ---------------------------------------------------------- */

/* ---------------------------------------------------------- */
/* Article functions { */
/* ---------------------------------------------------------- */

/* Get article title from id */
function get_article_title($id) {
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT title FROM `article` WHERE id=$id";
		return mysql_result(mysql_query($sql,$cid),0);
	}
}

/* Get short article title from id. If no short article title then return full title */
function get_short_article_title($id) {
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT short_title FROM `article` WHERE id=$id";
		if ($title = mysql_result(mysql_query($sql,$cid),0))
			return $title;
		else
			return get_article_title($id);
	}
}

/* Get article teaser from id */
function get_article_teaser($id) {
	global $cid;
	$sql = "SELECT teaser,content AS text1 FROM `article` INNER JOIN `text_story` ON (article.text1=text_story.id) WHERE article.id=$id";
	list($teaser,$content) = mysql_fetch_array(mysql_query($sql,$cid));
	if ($teaser)
		return str_replace('<br/>','',strip_tags($teaser));
	else {
		return trim(substr(strip_tags($content),0,strrpos(substr(strip_tags($content),0,TEASER_LENGTH),' '))).'...';
	}
}

/* Get article author's username from article id */
function get_article_author_uname($id) {
	global $cid;
	$sql = "SELECT author FROM `article` WHERE id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article author's full name from article id */
function get_article_author_vname($id) {
	global $cid;
	$sql = "SELECT ln.name FROM `article` AS a INNER JOIN `user` AS ln ON (a.author=ln.user) WHERE id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's full category name from article id */
function get_article_category($id) {
	global $cid;
	$sql = "SELECT label FROM `article` INNER JOIN `category` ON (article.category=category.id) WHERE article.id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's short category name from article id */
function get_article_category_cat($id) {
	global $cid;
	$sql = "SELECT cat FROM `article` INNER JOIN `category` ON (article.category=category.id) WHERE article.id=$id";
	return mysql_result(mysql_query($sql,$cid),0);
}

/* Get article's publish date from id (returns Unix timestamp) */
function get_article_publishdate($id) {
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT UNIX_TIMESTAMP(published) FROM `article` WHERE id=$id";
		return mysql_result(mysql_query($sql,$cid),0);
	}
}

/* Get article content from id (unfiltered) */
function get_article_text($id,$text=1) { // Article DONE
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT content FROM `article` INNER JOIN `text_story` ON (article.text$text=text_story.id) WHERE article.id=$id";
		$content = mysql_result(mysql_query($sql,$cid),0);
		return $content;
	}
}

/* Clean html content to remove extra styling */
function clean_content2($text) {
	$result = strip_tags($text, '<p><a><div><b><i><br><blockquote><object><param><embed><li><ul><ol><strong><img><h1><h2><h3><h4><h5><h6><em><iframe><strike>'); // Gets rid of html tags except certain exceptions
	$result = preg_replace('#<div[^>]*(?:/>|>(?:\s|&nbsp;)*</div>)#im', '', $result); // Removes empty html div tags
	$result = preg_replace('#<span*(?:/>|>(?:\s|&nbsp;)[^>]*</span>)#im', '', $result); // Removes empty html div tags
	$result = preg_replace('#<p[^>]*(?:/>|>(?:\s|&nbsp;)*</p>)#im', '', $result); // Removes empty html p tags
	//$result = preg_replace("/<(\/)*div[^>]*>/", "<\\1p>", $result); // Changes div tags into <p> tags
	return $result;
}

/* Get formatted article url from id */
function article_url($article) {
	$cat = get_article_category_cat($article);
	$title = get_article_title($article);

	$title = strtolower($title); // Make title lowercase
	$title= preg_replace('/[^\w\d_ -]/si', '', $title); // Remove special characters
	$dashed = str_replace( " ", "-", $title); // Replace spaces with hypens

	$output = $cat.'/'.$article.'/'.$dashed.'/';
	return $output;
}

function get_article_image_id($id) {
	global $dbok,$cid;
	if ($dbok) {
		$sql = "SELECT img1 FROM `article` WHERE id=$id";
		if ($imgid = mysql_result(mysql_query($sql,$cid),0))
			return $imgid;
		else
			return '';
	}
}

/* ---------------------------------------------------------- */
/* } END of article api functions */
/* ---------------------------------------------------------- */

/* ---------------------------------------------------------- */
/* Image Functions { */
/* ---------------------------------------------------------- */

/* ---------------------------------------------------------- */
/* } END of image functions */
/* ---------------------------------------------------------- */
?>
