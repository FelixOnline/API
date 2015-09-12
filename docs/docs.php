<?php
    use \FelixOnline\API\API;

    require_once(API_DIRECTORY.'/docs/header.php');
?>
    <?php
        // section files
        //$sections = array('article', 'image', 'user', 'comments', 'frontpage', 'most_commented', 'most_read', 'search');
        $sections = array('article', 'comments', 'image', 'user', 'section', 'frontpage', 'publication', 'issue');
        $queries = array('articles', 'articles-category', 'articles-article', 'frontpage', 'frontpage-section', 'archive-publication', 'archive-publication-issues', 'archive-publication-issue', 'archive-year-issues', 'archive-publication-year-issues', 'archive-latest', 'archive-issue', 'user', 'user-articles');
    ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo API_URL; ?>docs/">
                <?php echo API_NAME; ?> Docs 
            </a>
            <div class="nav-collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <ul class="nav">
                    <li class="active"><a href="#overview">Overview</a></li>
                    <!-- <li><a href="#api_key">Api Keys</a></li> -->
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle"
                            data-toggle="dropdown">
                            Objects
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach($sections as $section) { ?>
                                <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle"
                            data-toggle="dropdown">
                            Queries
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach($queries as $query) { ?>
                                <li><a href="#<?php echo 'query-'.$query; ?>"><?php echo ucwords(str_replace('_', ' ', $query)); ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
                <?php if(false) { ?>
                <?php if($currentuser->isLoggedIn()) { ?>
                    <ul class="nav secondary-nav">
                        <li class="menu">
                            <a href="#" class="menu"><?php echo $currentuser->getName();?></a>
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
                <?php } ?>
<div id="header_cont">
    <header>
        <h1>Welcome to the <?php echo API_NAME; ?> Documentation</h1>
        <p>Make yourself at home. If you have any questions then please do <a href="#contact">contact us</a>.</p>
    </header>
</div>
<div class="container">
    <section id="overview" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Overview</h1>
            </div>
            <?php echo API::render('overview'); ?>
        </div>
    </section>
    <section id="contents" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Objects</h1>
            </div>
            <ul>
                <?php foreach($sections as $section) { ?>
                    <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <?php foreach($sections as $section) { ?>
    <section id="<?php echo $section; ?>" class="row">
        <div class="span12">
            <?php echo API::render($section); ?>
        </div>
    </section>
    <?php } ?>
    <section id="call-queries" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Queries</h1>
            </div>
            <ul>
                <?php foreach($queries as $query) { ?>
                    <li><a href="#<?php echo 'query-'.$query; ?>"><?php echo ucwords(str_replace('-', ': ', str_replace('_', ' ', $query))); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <?php foreach($queries as $query) { ?>
        <section id="<?php echo 'query-'.$query; ?>" class="row">
            <div class="span12">
                <?php echo API::render('query-'.$query); ?>
            </div>
        </section>
    <?php } ?>
    <section id="contact" class="row">
        <div class="span12">
            <div class="page-header">
                <h1>Contact</h1>
            </div>
            <?php echo API::render('contact'); ?>
        </div>
    </section>
    <footer>
        <p><?php echo API_COPYRIGHT; ?>. API Version <?php echo API_VERSION; ?>. <a href="#">Top of page</a></p>
    </footer>
</div> <!--! end of #container -->
<?php require_once(API_DIRECTORY.'/docs/footer.php'); ?>
