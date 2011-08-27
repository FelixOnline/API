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

  <title>Felix Online API</title>
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
  <link rel="stylesheet/less" type="text/css/" href="docs/css/style.less">
  <script src="docs/js/libs/less-1.1.4.min.js" type="text/javascript"></script>

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for this custom Modernizr build containing Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="docs/js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="hero-unit">
            <h1>Felix Online API</h1>
            <p>Welcome to the Felix Online API. Please login to see the documentation or request an API key.</p>
            <?php echo '<form action="docs/" id="loginForm" method="post">';?>
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
        </div>
        <footer>
            <p>Copyright &copy; Felix  2011</p>
        </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="docs/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="docs/js/plugins.js"></script>
  <script defer src="docs/js/script.js"></script>
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

