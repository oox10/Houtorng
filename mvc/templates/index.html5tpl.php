<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- begin meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
	<meta name="description" content="HOU TORNG is a professional metal heat treating equipment manufacturer.">
	<meta name="keywords" content="HOU TORNG, HOUTORNG, metal heat treating equipment, heat treatment, furnace, continuous mesh belt, atmosphere generator, thermal processing equipment">
	<meta name="author" content="Doraho">
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
    <script src="js/jquery.polyglot.language.switcher.js" type="text/javascript"></script> <!-- language switcher -->
    <script src="js/ddlevelsmenu.js" type="text/javascript"></script> <!-- drop-down menu -->
    <script type="text/javascript"> <!-- drop-down menu -->
        ddlevelsmenu.setup("nav", "topbar");
    </script>
    <script src="js/tinynav.min.js" type="text/javascript"></script> <!-- tiny nav -->
    <script src="js/jquery.validate.min.js" type="text/javascript"></script> <!-- form validation -->
    <script src="js/jquery.flexslider-min.js" type="text/javascript"></script> <!-- slider -->
    <script src="js/jquery.jcarousel.min.js" type="text/javascript"></script> <!-- carousel -->
    <script src="js/jquery.ui.totop.min.js" type="text/javascript"></script> <!-- scroll to top -->
    <script src="js/jquery.fancybox.pack.js" type="text/javascript"></script> <!-- lightbox -->
    <script src="js/jquery.cycle.all.js" type="text/javascript"></script> <!-- entry slider -->
    <script src="js/mediaelement-and-player.min.js" type="text/javascript"></script> <!-- video and audio players -->
    <script src="js/jquery.fitvids.js" type="text/javascript"></script> <!-- responsive video embeds -->
    <script src="js/jquery.tweet.js" type="text/javascript"></script> <!-- Twitter widget -->
    <script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
	
	
	<!-- php variable-->
	<?php
	$products = isset($this->vars['system_data']['data']['product']) ?  $this->vars['system_data']['data']['product'] : array();
	$classlv  = isset($this->vars['system_data']['data']['classlv']) ?  $this->vars['system_data']['data']['classlv'] : array();
	?>
	
	
	<title>HOU TORNG - Industrial Heat Treating Equipment Manufacturer</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
    <!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin slider 主視覺投影片-->
        <section id="slider-home">
            <div class="flex-container">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="images/slider/slides/frontphoto-940x350.png" alt="Furnace">
                            <div class="flex-caption">
                                <h2>Welcome to HouTorng !</h2>
                                <p>You can describe your slides using captions. This is an example of a caption with. <a href="about-us.php">(see more)</a></p>
                            </div>
                        </li>
						<li>
                            <img src="images/slider/slides/construction-940x350.png" alt="Construction">
                            <div class="flex-caption">
                                <h2>Professional</h2>
                                <p>There is no substitute for hard work and experience.</p>
                            </div>
                        </li>
						<li>
                            <img src="images/slider/slides/cover.png" alt="Construction2">
                            <div class="flex-caption">
                                <h2>Stable and Dependable</h2>
                                <p>We have over 20 years combined experience in the heat treating equipment industry.</p>
                            </div>
						</li>	
                        <li>
                            <img src="images/slider/slides/wood-items-940x350.png" alt="WoodTools">
                            <div class="flex-caption">
                                <h2>Easy to Customize</h2>
                                <p>We have the ability to customize a furnace for any customer requirement.</p>
                            </div>
                        </li>

                        <li>
                            <img src="images/slider/slides/worker-940x350.png" alt="Worker">
                            <div class="flex-caption">
                                <h2>Professional Services</h2>
                                <p>Our world-wide technical support ensures customers a service they can depend on.</p>
                            </div>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
        </section>
        <!-- end slider -->

        <div class="space40"></div>

        <!-- begin services -->
        <section>
            <h2>Why Choose Us</h2>

            <!-- begin iconbox carousel -->
            <ul class="iconbox-carousel">
                <li>
                    <div class="iconbox cog">
                        <h4><span class="iconbox-icon"></span>Professional</h4>
                        <p>Our winning team consists of trained technicians, knowledgeable experts and dedicated product specialists.</p>
                    </div>
                </li>
				<li>
                    <div class="iconbox globe">
                        <h4><span class="iconbox-icon"></span>Stable and Dependable</h4>
                        <p>We have over 20 years combined experience in the heat treating equipment industry.</p>
                    </div>
                </li>
                <li>
                    <div class="iconbox write">
                        <h4><span class="iconbox-icon"></span>Easy to Customize</h4>
                        <p>We’re flexible and cost-effective. We have the ability to customize a furnace for any customer requirement.</p>
                    </div>
                </li>
				<li>
                    <div class="iconbox address-book">
                        <h4><a href="contact.php"><span class="iconbox-icon"></span>Customer Support</a></h4>
                        <p>Our world-wide technical support ensures customers a service they can depend on.</p>
                    </div>
                </li>
            </ul>
            <!-- end iconbox carousel -->
        </section>
        <!-- end services -->

        <!-- begin selected projects -->
        <section>
            <h2>Our Products <span class="more">&ndash; <a href="index.php?act=product">View All Products &raquo;</a></span></h2>

            <!-- begin project carousel -->
            <ul class="project-carousel">
			
			<?php foreach($products as $key=>$pd):?>
			    <li class="entry">
                    <div class="entry-slider">
                        <ul>
						<?php foreach($pd['images'] as $key => $pimg): ?>
                          <?php if(!$key): ?>
						  <li><a class="fancybox index" data-fancybox-group="gallery-living-brown" href="<?php echo $pimg['acc_name'];?>" title="<?php echo $pd['title_product'];?>"><span class="overlay zoom"></span><img src="<?php echo $pimg['acc_name'];?>" alt=""></a></li>	
						  <?php else:  ?>
                          <li style="display: none;"><a class="fancybox index" data-fancybox-group="gallery-living-brown" href="<?php echo $pimg['acc_name'];?>" title="<?php echo $pd['title_product'];?>"><span class="overlay zoom"></span><img src="<?php echo $pimg['acc_name'];?>" alt=""></a></li>
						  <?php endif; ?>	
						<?php endforeach; ?>
						</ul>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-slider.php"><?php echo $pd['title_product'];?></a></h4>
                    <div class="entry-content">
                        <p><?php //echo $pd['title_product'];?></p>
                    </div>
                </li>
			
			
			<?php endforeach; ?>	
			<?php 
			/* List Sample
                <li class="entry">
                    <div class="entry-image">
                        <a class="fancybox" href="images/entries/full-size/dining-white.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-white-220x130.png" alt=""></a>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-image.php">White Dining Room</a></h4>
                    <div class="entry-content">
                        <p>Image project with lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-image">
                        <a class="fancybox" data-fancybox-group="gallery-living-large-windows" href="images/entries/full-size/living-large-windows.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/living-large-windows-220x130.png" alt=""></a>
                        <a class="fancybox invisible" data-fancybox-group="gallery-living-large-windows" href="images/entries/full-size/living-brown.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/living-brown-220x130.png" alt=""></a>
                        <a class="fancybox invisible" data-fancybox-group="gallery-living-large-windows" href="images/entries/full-size/dining-and-living-cream.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-and-living-cream-220x130.png" alt=""></a>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-image.php">Living with Large Windows</a></h4>
                    <div class="entry-content">
                        <p>Gallery project with lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-slider">
                        <ul>
                            <li><a class="fancybox" data-fancybox-group="gallery-living-brown" href="images/entries/full-size/living-brown.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/living-brown-220x130.png" alt=""></a></li>
                            <li style="display: none;"><a class="fancybox" data-fancybox-group="gallery-living-brown" href="images/entries/full-size/dining-and-living-cream.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-and-living-cream-220x130.png" alt=""></a></li>
                            <li style="display: none;"><a class="fancybox" data-fancybox-group="gallery-living-brown" href="images/entries/full-size/living-white.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/living-white-220x130.png" alt=""></a></li>
                        </ul>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-slider.php">Brown Living Room</a></h4>
                    <div class="entry-content">
                        <p>Gallery project with slider and lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-video">
                        <video width="220" height="130" style="width: 100%; height: 100%;" poster="images/entries/220x130/dining-and-living-cream-220x130.png" controls preload="none">
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
                                <img src="images/entries/220x130/dining-and-living-cream-220x130.png" title="No video playback capabilities" alt="" />
                            </object>
                        </video>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-self-hosted-video.php">Self-Hosted Video Project</a></h4>
                    <div class="entry-content">
                        <p>Self-hosted video project.</p>
                    </div>
                </li>
                <!-- begin row 2 -->
                <li class="entry">
                    <div class="entry-image">
                        <a class="fancybox" href="images/entries/full-size/living-white.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/living-white-220x130.png" alt=""></a>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-image.php">White Living Room</a></h4>
                    <div class="entry-content">
                        <p>Image project with lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-image">
                        <a class="fancybox" data-fancybox-group="gallery-study" href="images/entries/full-size/study.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/study-220x130.png" alt=""></a>
                        <a class="fancybox invisible" data-fancybox-group="gallery-study" href="images/entries/full-size/dining-white2.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-white2-220x130.png" alt=""></a>
                        <a class="fancybox invisible" data-fancybox-group="gallery-study" href="images/entries/full-size/dining-brown.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-brown-220x130.png" alt=""></a>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-image.php">Study</a></h4>
                    <div class="entry-content">
                        <p>Gallery project with lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-slider">
                        <ul>
                            <li><a class="fancybox" data-fancybox-group="gallery-dining-white2" href="images/entries/full-size/dining-white2.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-white2-220x130.png" alt=""></a></li>
                            <li style="display: none;"><a class="fancybox" data-fancybox-group="gallery-dining-white2" href="images/entries/full-size/dining-brown.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-brown-220x130.png" alt=""></a></li>
                            <li style="display: none;"><a class="fancybox" data-fancybox-group="gallery-dining-white2" href="images/entries/full-size/dining-white.jpg" title="Project Title"><span class="overlay zoom"></span><img src="images/entries/220x130/dining-white-220x130.png" alt=""></a></li>
                        </ul>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-slider.php">White Dining Room 2</a></h4>
                    <div class="entry-content">
                        <p>Gallery project with slider and lightbox.</p>
                    </div>
                </li>
                <li class="entry">
                    <div class="entry-video">
                        <iframe src="http://player.vimeo.com/video/11624173?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="220" height="110" allowFullScreen></iframe>
                    </div>
                    <h4 class="entry-title"><a href="portfolio-item-embedded-video.php">Arhitectural Film &ndash; Interior</a></h4>
                    <div class="entry-content">
                        <p>Embedded video project.</p>
                    </div>
                </li>
			*/
			?>
            </ul>
            <!-- end project carousel -->
        </section>
        <!-- end selected projects -->

        <div class="clear"></div>

        <!-- begin clients -->
        <section>
            <h2>Our Clients</h2>
            <div class="client-wrap">
                <ul class="clients clearfix">
                    <li><a target="_blank" href="http://temp.net-pro.com.tw/profile.htm"><img src="images/client-logos/client001.png" alt="ITW" title="ITW"></li>
                    <li><a target="_blank" href="http://www.greatknives.com.tw/index.html"><img src="images/client-logos/client002.png" alt="Great Knives" title="Great Knives"></a></li>
                    <li><a target="_blank" href="http://tsubakimoto.com.tw/"><img src="images/client-logos/client003.png" alt="台灣椿本" title="台灣椿本"></a></li>
                    <li><a target="_blank" href="http://www.chunyu.com.tw/TW/index.aspx"><img src="images/client-logos/client004.png" alt="春雨工業" title="春雨工業"></a></li>
					<li><a target="_blank" href="http://www.fu-chuan.com.tw/en/index.php"><img src="images/client-logos/client005.png" alt="福泉鋼業" title="福泉鋼業"></a></li>
				</ul>
            </div>
        </section>
        <!-- end clients -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>
