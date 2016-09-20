<?php
    use \FelixOnline\API\API;

    require_once(API_DIRECTORY.'/docs/header.php');
?>
    <?php
        // section files
        //$sections = array('article', 'image', 'user', 'comments', 'frontpage', 'most_commented', 'most_read', 'search');
        $sections = array('article', 'comments', 'image', 'user', 'section', 'frontpage', 'publication', 'issue');
        $queries = array('articles' => "Articles",
            'articles-category' => "Articles by Category",
            'articles-article' => "Specific Article",
            'sections' => "Sections",
            'sections-section' => "Specific Section",
            'frontpage' => "Frontpage Articles",
            'frontpage-section' => "Specific Frontpage Section Articles",
            'archive-publication' => "Issue Archive Publication",
            'archive-publication-issues' => "Issue Archive Issues in Publication",
            'archive-publication-issue' => "Issue Archive Issue by Issue Number in Publication",
            'archive-years' => "Issue Archive Years",
            'archive-publication-years' => "Issue Archive Years for Publication",
            'archive-year-issues' => "Issue Archive Issues in Year",
            'archive-publication-year-issues' => "Issue Archive Issues in Year for Publication",
            'archive-latest' => "Issue Archive Latest Issues",
            'archive-issue' => "Issue Archive Issue by ID",
            'user' => "Users",
            'user-articles' => "User's Articles",
            'versioning' => "Record Update Timestamps");
    ?>
<div class="top-buttons" style="border-bottom: 1px solid #ca4829; position: fixed; width: 100%; background: white; top: 0; padding-top: 1rem; padding-bottom: 1rem; text-align: left;">
    <div container>
    <a href="#overview" class="button button--bordered button--xsm button--pill border--error">Overview</a></li>
    <div tabindex="0" class="dropdown button button--bordered button--xsm button--pill border--error">Objects &raquo;
        <div class="dropdown-content">
            <ul class="group">
                <?php foreach($sections as $section) { ?>
                    <li class="group-item"><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div tabindex="1" class="dropdown dropdown--large button button--bordered button--xsm button--pill border--error">Queries &raquo;
        <div class="dropdown-content">
            <ul class="group">
                <?php foreach($queries as $query => $label) { ?>
                    <li class="group-item"><a href="#<?php echo 'query-'.$query; ?>"><?php echo $label; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <a href="#contact" class="button button--bordered button--xsm button--pill border--error">Contact</a>
    </div>
</div>

<div container style="padding-top: 4rem;">
    <h1>Welcome to the <?php echo API_NAME; ?> Documentation</h1>
    <p>Make yourself at home. If you have any questions then please do <a href="#contact">contact us</a>.</p>

    <section id="overview" class="row">
        <div class="span12">
            <div class="page-header">
                <h2>Overview</h2>
            </div>
            <?php echo API::render('overview'); ?>
        </div>
    </section>
    <hr>
    <section id="contents" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Objects</h1>
            </div>
            <ul class="group">
                <?php foreach($sections as $section) { ?>
                    <li class="group-item border--error"><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <?php foreach($sections as $section) { ?>
    <section id="<?php echo $section; ?>" class="row">
        <div class="span12">
            <?php echo API::render($section); ?>
            <hr>
        </div>
    </section>
    <?php } ?>
    <section id="call-queries" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Queries</h1>
            </div>
            <ul class="group">
                <?php foreach($queries as $query => $label) { ?>
                    <li class="group-item"><a href="#<?php echo 'query-'.$query; ?>"><?php echo $label; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <?php foreach($queries as $query => $label) { ?>
        <section id="<?php echo 'query-'.$query; ?>" class="row">
            <div class="span12">
                <h2><?php echo $label; ?></h2>
                <?php echo API::render('query-'.$query); ?>
                <hr>
            </div>
        </section>
    <?php } ?>
    <section id="contact" class="row">
        <div class="span12">
            <div class="page-header">
                <h2>Contact</h2>
            </div>
            <?php echo API::render('contact'); ?>
        </div>
    </section>
    <footer>
        <hr>
        <p><?php echo API_COPYRIGHT; ?>. API Version <?php echo API_VERSION; ?>. <a href="#">Top of page</a></p>
    </footer>
</div> <!--! end of #container -->
<?php require_once(API_DIRECTORY.'/docs/footer.php'); ?>
