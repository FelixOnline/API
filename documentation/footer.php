    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo API_DOCS_URL; ?>js/libs/jquery-1.7.2.min.js"><\/script>')</script>

    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="<?php echo API_DOCS_URL; ?>js/plugins.js"></script>
    <script defer src="<?php echo API_DOCS_URL; ?>js/mylibs/jquery.scrollTo-1.4.2-min.js"></script>
    <script defer src="<?php echo API_DOCS_URL; ?>js/mylibs/jquery.localscroll-1.2.7-min.js"></script>
    <script defer src="<?php echo API_DOCS_URL; ?>js/bootstrap-dropdown.js"></script>
    <script defer src="<?php echo API_DOCS_URL; ?>js/bootstrap-collapse.js"></script>
    <script defer src="<?php echo API_DOCS_URL; ?>js/script.js"></script>
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

