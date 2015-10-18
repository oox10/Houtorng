<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- begin meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
	<meta name="description" content="HOU TORNG is a professional metal heat treating equipment manufacturer.">
	<meta name="keywords" content="HOU TORNG, HOUTORNG, metal heat treating equipment, heat treatment, furnace, continuous mesh belt, chain conveyor furnace, atmosphere generator">
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
	<!-- begin language switcher -->
	<script src="js/jquery.polyglot.language.switcher.js" type="text/javascript"></script> 
    <!-- end language switcher -->
    <script src="js/ddlevelsmenu.js" type="text/javascript"></script> <!-- drop-down menu -->
    <script type="text/javascript"> <!-- drop-down menu -->
        ddlevelsmenu.setup("nav", "topbar");
    </script>
    <script src="js/tinynav.min.js" type="text/javascript"></script> <!-- tiny nav -->
    <script src="js/jquery.ui.totop.min.js" type="text/javascript"></script> <!-- scroll to top -->
    <script src="js/jquery.validate.min.js" type="text/javascript"></script> <!-- form validation -->
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script> <!-- Google maps -->
    <script src="js/jquery.gmap.min.js" type="text/javascript"></script> <!-- gMap -->
	<script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
	
	<!-- php variable-->
	<?php
	$products = isset($this->vars['system_data']['data']['product']) ?  $this->vars['system_data']['data']['product'] : array();
	$classlv  = isset($this->vars['system_data']['data']['classlv']) ?  $this->vars['system_data']['data']['classlv'] : array();
	?>
    
	<title>${HOU TORNG - Contact}</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
	<?php include('includes/header.php'); ?>
        
    <!-- begin content -->
        <section id="content" class="container clearfix">
        	<!-- begin page header -->
            <header id="page-header">
            	<h1 id="page-title">${Contact Us}</h1>	
            </header>
            <!-- end page header -->
        	
            <!-- begin main content -->
            
            <!-- begin google map --> 
            <section>
                <div id="map"
                    data-address="No.36, Ln. 1274, Zhongzheng Rd., Zhongli Dist., Taoyuan City 320, Taiwan"
                    data-zoom="15"
					style="width: 100%; height: 400px;">
                </div>
            </section>
            <!-- end google map -->
            
            <!-- begin main -->
            <section id="main" class="three-fourths">
            <!-- begin contact form -->
            <h2>${Send Us Your Inquiry}</h2>
            <p>${To make an inquiry, please fill in the form below and we will contact you in the very near future.}</p>
            <div id="contact-notification-box-success" class="notification-box notification-box-success" style="display: none;">
                <p>${Your message has been successfully sent. We will get back to you as soon as possible.}</p>
                <a href="#" class="notification-close notification-close-success">x</a>
            </div>

                <div id="contact-notification-box-error" class="notification-box notification-box-error " style="display: none;">
                    <p id="contact-notification-box-error-msg" data-default-msg="Your message couldn't be sent because a server error occurred. Please try again."></p>
                    <a href="#" class="notification-close notification-close-error">x</a>
                </div>
            <form id="contact-form" class="content-form" method="post" action="">
                <p>
                    <label for="name">${Name:}<span class="note">*</span></label>
                    <input id="name" type="text" name="name" class="required">
                </p>
                <p>
                    <label for="email">${Email:}<span class="note">*</span></label>
                    <input id="email" type="email" name="email" class="required">
                </p>
                <p>
                    <label for="url">${Company:}</label>
                    <input id="company" type="text" name="company">
                </p>
                <p>
                    <label for="subject">${Subject:}<span class="note">*</span></label>
                    <input id="subject" type="text" name="subject" class="required">
                </p>
                <p>
                    <label for="message">${Message:}<span class="note">*</span></label>
                    <textarea id="message" cols="68" rows="8" name="message" class="required"></textarea>
                </p>
                <p>
				  <label for="message">${Turing:}<span class="note">*</span></label>
                  <div>  
					<span type="text" id='captcha_input' name="turing" contenteditable="true"></span>  					
				    <img src="captcha/code.php" id="captcha">
                    [ <a class='captcha_refresh' onclick="document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds(); document.getElementById('captcha_input').innerHTML='';" title='reset'></a> ] 
                  </div>
				</p>
                <p>
                    <input id="submit" class="button" type="submit" name="submit" value="${Send Message}">
                </p>
            </form>
            <p><span class="note">*</span> ${Required fields}</p>
            <!-- end contact form -->
            </section>
            <!-- end main -->
            
            <!-- begin sidebar -->
            <aside id="sidebar" class="one-fourth column-last">
            	<div class="widget contact-info">
                    <h3>${Contact Info}</h3>
                    <p class="address"><strong>${Address:}</strong>&nbsp;${ No.36, Ln. 1274, Zhongzheng Rd., Zhongli Dist., Taoyuan City 320, Taiwan}</p>
                    <p class="phone" ><strong style='vertical-align:top;'>${Phone:}</strong> <span style='display:inline-block;margin-left:4px;'>${886-3-427-1570}<br>${886-3-427-1571}</span></p>
                    <p class="fax"><strong>${Fax:}</strong>&nbsp;${886-3-426-1570}</p>
					<p class="email"><strong>Email:</strong> <a href="mailto:houtrung@ms58.hinet.net">houtrung@ms58.hinet.net</a></p>
                    <p class="business-hours"><strong>${Business Hours:}</strong><br>
                    ${Monday-Friday}: 08:00-17:00 (UTC+8:00)<br>
                    
                    </p>
                </div>
            </aside>
            <!-- end sidebar -->
            
            <!-- end main content -->
        </section>
        <!-- end content -->             
    
	<!-- begin footer -->
	<?php include('includes/footer.php'); ?>
	<!-- end footer -->
</div>
<!-- end container -->

</body>
</html>