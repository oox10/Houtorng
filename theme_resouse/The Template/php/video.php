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
    <script src="js/mediaelement-and-player.min.js" type="text/javascript"></script> <!-- video and audio players -->
    <script src="js/jquery.fitvids.js" type="text/javascript"></script> <!-- responsive video embeds -->
	<script src="js/jquery.tweet.js" type="text/javascript"></script> <!-- Twitter widget -->
	<script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
	
	<title>Finesse - Video</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
	<!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">Video</h1>
        </header>
        <!-- end page header -->

        <!-- begin main content -->
        <section id="main" class="three-fourths">
            <!-- begin self-hosted video -->
            <section>
                <h2>Self-Hosted Video</h2>
                <div class="entry-video large-video">
                    <video width="700" height="393" style="width: 100%; height: 100%;" poster="images/entries/video/video1-700x393.png" controls preload="none">
                        <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
                        <source type="video/mp4" src="media/echo-hereweare.mp4" />
                        <!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
                        <source type="video/webm" src="media/echo-hereweare.webm" />
                        <!-- Ogg/Vorbis for older Firefox and Opera versions -->
                        <source type="video/ogg" src="media/echo-hereweare.ogv" />
                        <!-- Optional: Add subtitles for each language -->
                        <track kind="subtitles" src="media/mediaelement.srt" srclang="en" />
                        <!-- Optional: Add chapters -->
                        <track kind="chapters" src="#" srclang="en" />
                        <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
                        <object type="application/x-shockwave-flash" data="js/flashmediaelement.swf">
                            <param name="movie" value="js/flashmediaelement.swf" />
                            <param name="flashvars" value="controls=true&amp;file=media/echo-hereweare.mp4" />
                            <!-- Image as a last resort -->
                            <img src="images/entries/video/video1-700x393.png" title="No video playback capabilities" alt="" />
                        </object>
                    </video>
                </div>
            </section>
            <!-- end self-hosted video -->

            <hr>

            <!-- begin vimeo video -->
            <section>
                <h2>Vimeo Video</h2>
                <div class="entry-video">
                    <iframe src="http://player.vimeo.com/video/11624173?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="700" height="350" allowFullScreen></iframe>
                </div>
            </section>
            <!-- end vimeo video -->

            <hr>

            <!-- begin youtube video -->
            <section>
                <h2>YouTube Video</h2>
                <div class="entry-video">
                    <iframe width="700" height="394" src="http://www.youtube.com/embed/J2DVZQtoHbQ?rel=0" allowfullscreen></iframe>
                </div>
            </section>
            <!-- end youtube video -->
        </section>
        <!-- end main content -->

        <!-- begin sidebar -->
        <aside id="sidebar" class="one-fourth column-last">
            <div class="widget">
                <h3>Secondary Navigation</h3>
                <nav>
                    <ul class="menu">
                        <li><a href="#">Example of a Link</a></li>
                        <li class="current-menu-item"><a href="#">The Active Link</a></li>
                        <li><a href="#">Example of a Link</a></li>
                        <li><a href="#">Example of a Link</a></li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- end sidebar -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>