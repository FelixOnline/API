<?php
    require_once(API_DIRECTORY.'/documentation/header.php');
?>
    <?php
        // section files
        $sections = array('article', 'image', 'user', 'comments', 'frontpage', 'most_commented', 'most_read', 'search');
    ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo API_URL; ?>docs/">
                Felix Online API Docs 
            </a>
            <!-- Everything you want hidden at 940px or less, place within here -->
            <div class="nav-collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->
                <ul class="nav">
                    <li class="active"><a href="#overview">Overview</a></li>
                    <li><a href="#api_key">Api Keys</a></li>
                    <li class="dropdown">
                        <a href="#"
                            class="dropdown-toggle"
                            data-toggle="dropdown">
                            Contents
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach($sections as $section) { ?>
                                <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
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
    <section id="overview">
        <?php require_once('sections/overview.php'); ?>
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
    <section id="contents">
        <h1>Contents <strong>support</strong></h1>
        <ul>
        <?php foreach($sections as $section) { ?>
            <li><a href="#<?php echo $section; ?>"><?php echo ucwords(str_replace('_', ' ', $section)); ?></a></li>
        <?php } ?>
        </ul>
    </section>
    <?php if(false) { ?>
    <?php foreach($sections as $section) { ?>
    <section id="<?php echo $section; ?>">
        <?php require_once('sections/'.$section.'.php'); ?>
    </section>
    <?php } ?>
    <?php } ?>
    <section id="contact">
        <?php require_once('sections/contact.php'); ?>
    </section>
    <footer>
        <p>Copyright &copy; Felix  2011 <a href="#">Top of page</a></p>
    </footer>
</div> <!--! end of #container -->
<?php require_once(API_DIRECTORY.'/documentation/footer.php'); ?>
