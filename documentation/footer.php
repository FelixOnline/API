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

    <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
    <script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
</body>
</html>

