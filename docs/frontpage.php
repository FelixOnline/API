<?php require_once(API_DIRECTORY.'/docs/header.php'); ?>
<div container>
    <div>
        <h1><?php echo API_NAME; ?></h1>
        <p>Welcome to the <?php echo API_NAME; ?>.</p>
        <a href="<?php echo API_URL; ?>docs/" class="button button--bordered button--lg button--pill border--error" id="docbutton">Documentation &raquo;</a>
    </div>
    <hr>
    <p><?php echo API_COPYRIGHT; ?>. API Version <?php echo API_VERSION; ?>.</p>
</div> <!--! end of #container -->

<?php require_once(API_DIRECTORY.'/docs/footer.php'); ?>
