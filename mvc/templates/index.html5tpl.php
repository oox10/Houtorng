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
	<?php if(isset($_SESSION['language'])&&$_SESSION['language']=='meta_cht'):?>
	<link href="style-cht.css" type="text/css" rel="stylesheet">
	<?php else: ?>
	<link href="style.css" type="text/css" rel="stylesheet">
	<?php endif; ?>
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
	
	<title>${HOU TORNG - Industrial Heat Treating Equipment Manufacturer}</title>
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
                            <img src="images/slider/slides/frontphoto-940x350.jpg" alt="Furnace">
                            <div class="flex-caption">
							
                                <h2>${_SLIDER_P01_TITLE}</h2>
                                <p>HOU TORNG ENGINEERING CO., LTD. is a manufacturer of standard & custom metal heat treating equipment.<a href="index.php?act=aboutus">(see more)</a></p>
                            </div>
                        </li>
						<li>
                            <img src="images/slider/slides/construction-940x350.jpg" alt="Construction">
                            <div class="flex-caption">
                                <h2>${_SLIDER_P02_TITLE}</h2>
                                <p>There is no substitute for hard work and experience.</p>
                            </div>
                        </li>
						<li>
                            <img src="images/slider/slides/NMHG2-940x350.jpg" alt="NMHG">
                            <div class="flex-caption">
                                <h2>${_SLIDER_P03_TITLE}</h2>
                                <p>We have over 20 years combined experience in the heat treating equipment industry.<a href="about-us.php">(see more)</a></p>
                            </div>
						</li>	
                        <li>
                            <img src="images/slider/slides/wood-items-940x350.jpg" alt="WoodTools">
                            <div class="flex-caption">
                                <h2>${_SLIDER_P04_TITLE}</h2>
                                <p>We have the ability to customize a furnace for any customer requirement.</p>
                            </div>
                        </li>

                        <li>
                            <img src="images/slider/slides/worker-940x350.jpg" alt="Worker">
                            <div class="flex-caption">
                                <h2>${_SLIDER_P05_TITLE}</h2>
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
            <h2>${Why Choose Us}</h2>

            <!-- begin iconbox carousel -->
            <ul class="iconbox-carousel">
                <li>
                    <div class="iconbox cog">
                        <h4><span class="iconbox-icon"></span>${Professional}</h4>
                        <p>${Our winning team consists of trained technicians, knowledgeable experts and dedicated product specialists.}</p>
                    </div>
                </li>
				<li>
                    <div class="iconbox globe">
                        <h4><span class="iconbox-icon"></span>${Stable and Dependable}</h4>
                        <p>${We have over 20 years combined experience in the heat treating equipment industry.}</p>
                    </div>
                </li>
                <li>
                    <div class="iconbox write">
                        <h4><span class="iconbox-icon"></span>${Easy to Customize}</h4>
                        <p>${We’re flexible and cost-effective. We have the ability to customize a furnace for any customer requirement.}</p>
                    </div>
                </li>
				<li>
                    <div class="iconbox address-book">
                        <h4><a href="contact.php"><span class="iconbox-icon"></span>${Customer Support}</a></h4>
                        <p>${Our world-wide technical support ensures customers a service they can depend on.}</p>
                    </div>
                </li>
            </ul>
            <!-- end iconbox carousel -->
        </section>
        <!-- end services -->

        <!-- begin selected projects -->
        <section>
            <h2>${Our Products} <span class="more">&ndash; <a href="index.php?act=product">${View All Products} &raquo;</a></span></h2>

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
                          <!-- <li style="display: none;"><a class="fancybox index" data-fancybox-group="gallery-living-brown" href="<?php echo $pimg['acc_name'];?>" title="<?php echo $pd['title_product'];?>"><span class="overlay zoom"></span><img src="<?php echo $pimg['acc_name'];?>" alt=""></a></li> -->
						  <?php endif; ?>	
						<?php endforeach; ?>
						</ul>
                    </div>
                    <h4 class="entry-title"><a href="index.php?act=product/<?php echo rawurlencode($pd['title_product']);?>"><?php echo $pd['title_product'];?></a></h4>
                    <div class="entry-content">
                        <p><?php //echo $pd['title_product'];?></p>
                    </div>
                </li>
			
			
			<?php endforeach; ?>	
			
            </ul>
            <!-- end project carousel -->
        </section>
        <!-- end selected projects -->

        <div class="clear"></div>

        <!-- begin clients -->
        <section>
            <h2>${Our Clients} <span class="more">&ndash; <a href="index.php?act=business">${View More Clients} &raquo;</a></span></h2>
            <div class="client-wrap">
                <ul class="clients clearfix">
				    <li><a target="_blank" href="http://www.seec.com.tw"><img src="images/client-logos/client_seec.jpg" alt="士林電機" title="士林電機"></a></li>
					<li><a target="_blank" href="http://www.ch-forging.com.tw"><img src="images/client-logos/client_chf.jpg" alt="江興鍛壓工業" title="江興鍛壓工業"></a></li>
					<li><a target="_blank" href="http://www.kingduan.com.tw/"><img src="images/client-logos/client_kingduan.jpg" alt="金鍛工業" title="金鍛工業"></a></li>
                    <li><a target="_blank" href="http://www.itwbuildex.com/index.html"><img src="images/client-logos/client001.jpg" alt="ITW" title="ITW"></li>
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
