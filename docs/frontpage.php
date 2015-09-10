<?php require_once(API_DIRECTORY.'/docs/header.php'); ?>
<div class="container frontpage">
    <div class="hero-unit">
        <h1><?php echo API_NAME; ?></h1>
        <p>Welcome to the <?php echo API_NAME; ?>.</p>
        <a href="<?php echo API_URL; ?>docs/" class="btn btn-primary btn-large" id="docbutton">Documentation &raquo;</a>
    </div>
    <footer>
        <p><?php echo API_COPYRIGHT; ?>. API Version <?php echo API_VERSION; ?>.</p>
    </footer>
</div> <!--! end of #container -->

<?php require_once(API_DIRECTORY.'/docs/footer.php'); ?>
