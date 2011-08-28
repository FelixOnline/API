<?php

    /* AUTHENTICATION */

    /* If authentication is enabled */
    if (AUTHENTICATION == true) {
        if (strstr($_SERVER['HTTP_HOST'],"union.ic.ac.uk") !== false)
            header("Location: ".STANDARD_URL.substr($_SERVER['REQUEST_URI'],(1+strrpos($_SERVER['REQUEST_URI'],"/"))));
        session_name("felix");
        session_start();
        $session = session_id();
        if ($_SERVER['SERVER_NAME'] == AUTHENTICATION_SERVER) {
            if ($_POST['login']) {
                if (pam_auth($_POST['username'], $_POST['password'])) {
                    set_session($session,$_POST['username']);
                    $loc = strpos($_GET['goto'],'?') ? ('Location: '.$_GET['goto'].'&session='.$session) : ('Location: '.$_GET['goto'].'?session='.$session);
                    if($_POST['remember'])
                        $loc .= '&remember=true';
                    if($_POST['comment']) {
                        if ($_POST['commenttype'] == 'like') $type = 1;
                        else $type = 0;
                        like_comment($_POST['comment'],$_POST['username'],$type);
                        $loc .= '#'.$_POST['comment'];
                    }
                    header($loc);
                    return;
                }
                else {
                    logout();
                    $loc = strpos($_GET['goto'],'?') ? 'Location: '.$_GET['goto'].'&session='.$session.'&login=FAIL' : 'Location: '.$_GET['goto'].'?session='.$session.'&login=FAIL';
                    header($loc);
                    return;
                }
            }
            else
                header('Location: '.STANDARD_URL);
        }
        /* Check if user has been remembered */
        if(isset($_COOKIE['felixonline']))
            re_login($_COOKIE['felixonline']);
        if (($session = $_GET['session']) && is_session_recent($session) && ($_GET['login'] != 'FAIL'))
            login(get_user_from_session($session));
            if (isset($_GET['remember']))
                setcookie('felixonline', $_SESSION['felix']['uname'], time()+60*60*24*30, "/");
        if ($_POST['logout'])
            logout();
    } else {
        // set fake cookie if depending on username
        session_name("felix");
        session_start();
        $session = session_id();
        if ($_POST['login']) {
            $_SESSION['felix']['vname'] = $_POST['username'];
            $_SESSION['felix']['name'] = $_POST['username'];
            $_SESSION['felix']['uname'] = $_POST['username'];
            $_SESSION['felix']['loggedin'] = true;
            $loc = strpos($_GET['goto'],'?') ? ('Location: '.$_GET['goto'].'&session='.$session) : ('Location: '.$_GET['goto'].'?session='.$session);
            if($_POST['remember'])
                setcookie('felixonline', $_SESSION['felix']['uname'], time()+60*60*24*30, "/");
            if($_POST['comment']) {
                if ($_POST['commenttype'] == 'like') $type = 1;
                else $type = 0;
                like_comment($_POST['comment'],$_POST['username'],$type);
                $loc .= '#'.$_POST['comment'];
            }
            header($loc);
            return;
        }

        /* Check if user has been remembered */
        if(isset($_COOKIE['felixonline'])) {
            $_SESSION['felix']['vname'] = $_COOKIE['felixonline'];
            $_SESSION['felix']['name'] = $_COOKIE['felixonline'];
            $_SESSION['felix']['uname'] = $_COOKIE['felixonline'];
            $_SESSION['felix']['loggedin'] = true;
        }
        if ($_POST['logout']) {
            $_SESSION['felix']['loggedin'] = false;
            if(isset($_COOKIE['felixonline']))
                setcookie("felixonline", "", time(), "/");
        }
    }

	//$session_param1 = "?session=".session_id();
	//$session_param2 = "&session=".session_id();

?>
