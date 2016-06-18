<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- begin meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
	<meta name="description" content="HOU TORNG is a professional metal heat treating equipment manufacturer.">
	<meta name="keywords" content="HOU TORNG, HOUTORNG, metal heat treating equipment, furnace, continuous mesh belt, chain conveyor furnace, atmosphere generator">
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
	<script src="js/jquery.tweet.js" type="text/javascript"></script> <!-- Twitter widget -->
	<script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
	
	<!-- php variable-->
	<?php
	$classlv  = isset($this->vars['system_data']['data']['classlv']) ?  $this->vars['system_data']['data']['classlv'] : array();
	$business  = isset($this->vars['system_data']['data']['business']) ?  $this->vars['system_data']['data']['business'] : array();
	
	
	?>
    
	<title>${HOU TORNG - About Us}</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
    <!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">${Business}</h1>	
        </header>
        <!-- end page header -->
        
        <!-- begin main content -->
        
		<!-- begin table -->
        <section>
			
			<?php foreach($business as $ptype=>$pset): ?>   
            <table class="gen-table">
                <caption>
                <?php echo $ptype; ?>
                </caption>
                <thead>
                    <tr>
                        <?php  $ptype = ($pset[0]['product_type']) ? true : false; ?>
						<?php echo  $ptype ? "<th>型號</th>" :''; ?>
						<?php  $pout = ($pset[0]['output']) ? true : false; ?>
						<?php echo  $pout ? "<th>產能</th>" :''; ?>
                        <th>公司</th>
                        <th>地區</th>
                        <th>用途</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
                <tbody>
                <?php foreach($pset as $key => $p): ?>    
					<tr class="<?php echo $key%2 ?'':'odd'; ?>" >
                        <?php echo  $ptype ? "<td>".$p['product_type']."</td>" :''; ?>
						<?php echo  $pout ? "<td>".$p['output']."</td>" :''; ?>
						<td><?php echo $p['company']; ?></td>
                        <td><?php echo $p['location']; ?></td>
                        <td><?php echo $p['useTo']; ?></td>
                    </tr>
                <?php endforeach; ?> 
                </tbody>
            </table>
		    <div class="space20"></div>
			<?php endforeach; ?>
			
			
        </section>
        <!-- end table -->
        
        <div class="clear"></div>
		<div class="space20"></div>
		
		
		<!-- begin clients -->
        <section>
            <h2>${Our Clients}</h2>
            <div class="client-wrap " style='border-top:0px #FFFFFF solid;'>
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
	
        <!-- end main content -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>