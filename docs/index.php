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

    <div class="topbar">
        <div class="fill">
            <div class="container">
                <h3><a href="#">Felix Online API Docs</a></h3>
                <ul>
                    <li class="active"><a href="#overiew">Overview</a></li>
                    <li><a href="#api_key">Api Keys</a></li>
                    <li><a href="#contents">Contents</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <header>
            <h1>Welcome to the Felix Online API Documentation</h1>
            <p>Make yourself at home. If you have any questions then please do <a href="#contact">contact us</a>.</p>
        </header>
        <section id="overview">
            <div class="page-header">
                <h1>Overview</h1>
            </div>
            <p>This is the documentation for Felix Online API. It is a work in progress at the moment so please bear with us. Any features that are working will be clearly marked as such, as well as any that aren't!</p>
            <p>N.B. We only support JSON output format at the moment.</p>
            <div class="row">
            </div>
        </section>
        <section id="api_key">
            <div class="page-header">
                <h1>Get an API key</h1>
            </div>
            <div class="row">
                <div class="span16">
                    <form id="api_key_form">
                        <fieldset>
                            <div class="clearfix">
                                <label for="name">Name:</label>
                                <div class="input">
                                    <p>Jonathan Kim</p>
                                </div>
                            </div>
                            <div class="clearfix">
                                <label for="desc">What do you want the key for?</label>
                                <div class="input">
                                    <textarea class="xxlarge" id="desc" name="desc"></textarea>
                                </div>
                            </div>
                            <div class="actions">
                                <input type="submit" class="btn primary" value="Get a key"/>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
        <section id="contents">
            <div class="page-header">
                <h1>Contents</h1>
            </div>
            <div class="row">
                <div class="span6 offset3">
                    <dl>
                        <dt><a href="#article">Article</a></dt>
                        <dd>The article api</dd>
                        <dt><a href="#images">Images</a></dt>
                        <dd>Image api</dd>
                    </dl>
                </div>
            </div>
        </section>
        <section id="article">
            <div class="page-header">
                <h1>Article <small>Access to all the articles on Felix Online</small></h1>
            </div>

        </section>
        <section id="contact">
            <div class="page-header">
                <h1>Contact</h1>
            </div>
        </section>
        <div id="main" role="main">

        </div>
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
