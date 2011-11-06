<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Felix Online API Documentation</title>
    <meta name="description" content="The Felix Online API documentation">
    <meta name="author" content="Jonathan Kim">

    <!-- Facebook Meta -->
    <meta property="og:title" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:description" content=""/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="img/logo.jpg"/>
    <meta property="fb:admins" content="" />

    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

    <!-- LESS: implied media="all" -->
    <link rel="stylesheet/less" type="text/css/" href="css/style.less">
    <script src="js/libs/less-1.1.4.min.js" type="text/javascript"></script>

    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except for this custom Modernizr build containing Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

    <?php
        require_once("../inc/config.inc.php");
	    require_once("../inc/functions.php");
	    require_once("../inc/const.php");
        require_once("../authentication.php");

        if(isset($_POST['keygen'])) {
            $keygen = gen_api_key(is_logged_in());
            if(!store_api_key($keygen, is_logged_in(), $_POST['desc'])){
                echo 'ERROR';
            } else {
                send_api_gen_email(is_logged_in(), $_POST['desc']); // Send email confirmation
            }
        }
    ?>

    <?php
        // section files
        $sections = array('article', 'image', 'user', 'comments', 'frontpage', 'most_commented', 'most_read', 'search');
        global $key;
    ?>
    <div class="topbar">
        <div class="fill">
            <div class="container">
                <h3><a href="#">Felix Online API Docs</a></h3>
                <ul>
                    <li class="active"><a href="#overview">Overview</a></li>
                    <li><a href="#api_key">Api Keys</a></li>
                    <ul class="nav">
                        <li class="menu">
                            <a href="#contents" class="menu">Contents</a>
                            <ul class="menu-dropdown">
                                <?php foreach($sections as $section) { ?>
                                    <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <?php if(is_logged_in()) { ?>
                <ul class="nav secondary-nav">
                    <li class="menu">
                        <a href="#" class="menu"><?php echo get_vname();?></a>
                        <ul class="menu-dropdown">
                            <li class="clearfix">
                                <form method="post" style="display: inline;">
                                    <input type="submit" value="Logout" id="logoutbutton" name="logout">
                                </form>
                            </li>
                            </ul>
                        </ul>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <div id="header_cont">
        <header>
            <h1>Welcome to the Felix Online API Documentation</h1>
            <p>Make yourself at home. If you have any questions then please do <a href="#contact">contact us</a>.</p>
        </header>
    </div>
    <div class="container">
        <section id="overview">
            <?php require_once('sections/overview.php'); ?>
        </section>
        <section id="api_key">
            <h1>Get an API key</h1>
            <?php if(!($uname = is_logged_in())) { // user is not logged in ?>
                <h4>You need to be logged in to request an API key</h4>
                    <?php echo '<form action="'.AUTHENTICATION_PATH."?session=".$_SESSION["felix"]["name"]."&goto=".str_replace(array("&login=FAIL",$session_param1,$session_param2),array('','',''),curPageURLNonSecure()).'" id="loginForm" method="post">';?>
                    <fieldset>
                        <div class="clearfix">
                            <label for="username">IC Username</label>
                            <div class="input">
                                <input type="text" class="xlarge" name="username" id="username" size="30" />
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="password">IC Password</label>
                            <div class="input">
                                <input type="password" class="xlarge" name="password" id="password" size="30" />
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="rememberButton">Remember Me</label>
                            <div class="input">
                                <input type="checkbox" name="remember" id="rememberButton" value="rememberme" />
                            </div>
                        </div>
                        <div class="actions">
                            <input type="submit" value="Login &raquo;" name="login" id="submit" class="btn primary large"/>
                        </div>
                    </fieldset>
                </form>
            <?php } else if(!user_has_key($uname)) { // user is logged in but doesn't have a key ?>
                <div class="row">
                    <div class="span16">
                        <form id="api_key_form" action="<?php echo API_URL; ?>docs/" method="post">
                            <fieldset>
                                <div class="clearfix">
                                    <label for="name">Name:</label>
                                    <div class="input">
                                        <p><?php echo get_vname();?></p>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <label for="desc">What do you want the key for?</label>
                                    <div class="input">
                                        <textarea class="xxlarge" id="desc" name="desc"></textarea>
                                    </div>
                                    <div class="input">
                                        <span class="error">You need to put a description in the box above</span>
                                    </div>
                                </div>
                                <div class="actions">
                                    <input type="submit" class="btn primary" value="Get a key" name="keygen" id="keygen"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            <?php } else if($key = user_has_key($uname)) { // user is logged in and has key ?>
                <p>Your key:</p>
                <pre><code><?php echo $key; ?></code></pre>
            <?php } ?>
        </section>
        <section id="contents">
            <h1>Contents <strong>support</strong></h1>
            <ul>
            <?php foreach($sections as $section) { ?>
                <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
            <?php } ?>
            </ul>
        </section>
        <?php foreach($sections as $section) { ?>
        <section id="<?php echo $section; ?>">
            <?php require_once('sections/'.$section.'.php'); ?>
        </section>
        <?php } ?>
        <section id="contact">
            <?php require_once('sections/contact.php'); ?>
        </section>
        <footer>
            <p>Copyright &copy; Felix  2011 <a href="#">Top of page</a></p>
        </footer>
    </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script>
  <script defer src="js/mylibs/jquery.scrollTo-1.4.2-min.js"></script>
  <script defer src="js/mylibs/jquery.localscroll-1.2.7-min.js"></script>
  <script defer src="js/script.js"></script>
  <!-- end scripts-->

  <!-- Change UA-XXXXX-X to be your site's ID -->
  <script>
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>
