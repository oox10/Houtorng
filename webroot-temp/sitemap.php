<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- begin meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
	<meta name="description" content="Finesse is a responsive business and portfolio theme carefully handcrafted using the latest technologies. It features a clean design, as well as extended functionality that will come in very handy.">
	<meta name="keywords" content="Finesse, responsive business portfolio theme, HTML5, CSS3, clean design">
	<meta name="author" content="Ixtendo">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- end meta -->
	
	<!-- begin CSS -->
	<link href="style.css" type="text/css" rel="stylesheet">
	<!--[if IE]> <link href="css/ie.css" type="text/css" rel="stylesheet"> <![endif]-->
	<link href="css/colors/orange.css" type="text/css" rel="stylesheet">
    <!-- end CSS -->
	
	<link href="images/favicon.ico" type="image/x-icon" rel="shortcut icon">
	
	<!-- begin JS -->
    <script src="js/jquery-1.11.1.min.js" type="text/javascript"></script> <!-- jQuery -->
    <script src="js/ie.js" type="text/javascript"></script> <!-- IE detection -->
    <script src="js/jquery.easing.1.3.js" type="text/javascript"></script> <!-- jQuery easing -->
	<script src="js/modernizr.custom.js" type="text/javascript"></script> <!-- Modernizr -->
    <!--[if IE 8]><script src="js/respond.min.js" type="text/javascript"></script><![endif]--> <!-- Respond -->
	<!-- begin language switcher -->
	<script src="js/jquery.polyglot.language.switcher.js" type="text/javascript"></script> 
    <!-- end language switcher -->
    <script src="js/ddlevelsmenu.js" type="text/javascript"></script> <!-- drop-down menu -->
    <script type="text/javascript"> <!-- drop-down menu -->
        ddlevelsmenu.setup("nav", "topbar");
    </script>
    <script src="js/tinynav.min.js" type="text/javascript"></script> <!-- tiny nav -->
    <script src="js/jquery.ui.totop.min.js" type="text/javascript"></script> <!-- scroll to top -->
	<script src="js/jquery.tweet.js" type="text/javascript"></script> <!-- Twitter widget -->
	<script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
    
	<title>Finesse - Sitemap</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
	<!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">Sitemap</h1>
        </header>
        <!-- end page header -->

        <!-- begin main content -->

        <!-- begin one third -->
        <section class="one-third">
            <h2>Pages</h2>
            <?php print_sitemap(); ?>
        </section>
        <!-- end one third -->

        <!-- begin one third -->
        <section class="one-third">
            <h2>Blog Archives</h2>
            <section>
                <h3>Archives by Month</h3>
                <ul class="arrow">
                    <li><a title="March 2012" href="#">March 2012</a></li>
                    <li><a title="February 2012" href="#">February 2012</a></li>
                    <li><a title="January 2012" href="#">January 2012</a></li>
                    <li><a title="December 2011" href="#">December 2011</a></li>
                </ul>
            </section>

            <section>
                <h3>Archives by Category</h3>
                <ul class="arrow">
                    <li><a title="View all posts filed under Graphic Design" href="#">Graphic Design</a></li>
                    <li><a title="View all posts filed under Photography" href="#">Photography</a></li>
                    <li><a title="View all posts filed under Typography" href="#">Typography</a></li>
                    <li><a title="View all posts filed under Web Design" href="#">Web Design</a></li>
                    <li><a title="View all posts filed under Web Development" href="#">Web Development</a></li>
                </ul>
            </section>

            <section>
                <h3>Archives by Tag</h3>
                <ul class="arrow">
                    <li><a href="#">Aside</a></li>
                        <li><a href="#">Audio</a></li>
                        <li><a href="#">Gallery</a></li>
                        <li><a href="#">Image</a></li>
                        <li><a href="#">Link</a></li>
                        <li><a href="#">Quote</a></li>
                        <li><a href="#">Standard</a></li>
                        <li><a href="#">Video</a></li>
                </ul>
            </section>

            <section>
                <h3>Archives by Author</h3>
                <ul class="arrow">
                    <li><a href="#">admin</a></li>
                </ul>
            </section>
        </section>
        <!-- end one third -->
        <!-- begin one third -->
        <section class="one-third column-last">
            <h2>Latest 20 Posts</h2>
            <ul class="arrow">
                <li><a href="#">How to Make Innovative Ideas Happen</a></li>
                <li><a href="#">Web Development for the iPhone and iPad</a></li>
                <li><a href="#">How To Design A Mobile Game With HTML5</a></li>
                <li><a href="#">The Elements of the Mobile User Experience</a></li>
                <li><a href="#">Tips for a Finely Crafted Website</a></li>
                <li><a href="#">How to Build a Mobile Website</a></li>
                <li><a href="#">Secrets of High-Traffic WordPress Blogs</a></li>
                <li><a href="#">A Fun Approach to Creating More Successful Websites</a></li>
                <li><a href="#">Guidelines for Mobile Web Development</a></li>
                <li><a href="#">The Creative Way to Maximize Design Ideas with Type</a></li>
                <li><a href="#">How to Market Your Mobile Application</a></li>
                <li><a href="#">Typographic Design Patterns and Best Practices</a></li>
                <li><a href="#">Mobile Considerations in User Experience Design</a></li>
                <li><a href="#">Creating Mobile-Optimized Websites Using WordPress</a></li>
                <li><a href="#">How to Become a Top WordPress Developer</a></li>
                <li><a href="#">Easily Customize WordPress’ Default Functionality</a></li>
                <li><a href="#">The Art of Staying Up To Date</a></li>
                <li><a href="#">Progressive and Responsive Navigation</a></li>
                <li><a href="#">The Creative Way to Maximize Design Ideas with Type</a></li>
                <li><a href="#">Persuasion Triggers in Web Design</a></li>
            </ul>
        </section>
        <!-- end one third -->

        <!-- end main content -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>