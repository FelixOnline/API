<?php
    use \FelixOnline\API\API;

    require_once(API_DIRECTORY.'/docs/header.php');
?>
    <?php
        // section files
        //$sections = array('article', 'image', 'user', 'comments', 'frontpage', 'most_commented', 'most_read', 'search');
        $sections = array('article', 'image', 'user', 'section');
        $queries = array('articles', 'articles-category', 'articles-article');
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
                Felix Online API Docs 
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
        <h1>Welcome to the Felix Online API Documentation</h1>
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
    <?php if(false) { ?>
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
    <?php } ?>
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
        <p>Copyright &copy; Felix  2011 <a href="#">Top of page</a></p>
    </footer>
</div> <!--! end of #container -->
<?php require_once(API_DIRECTORY.'/docs/footer.php'); ?>
