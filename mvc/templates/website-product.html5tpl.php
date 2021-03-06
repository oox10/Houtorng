<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- begin meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
	<meta name="description" content="HOU TORNG is a professional metal heat treating equipment manufacturer.">
	<meta name="keywords" content="HOU TORNG, HOUTORNG, metal heat treating equipment, heat treatment, furnace, continuous mesh belt, chain conveyor furnace, atmosphere generator, thermal processing equipment">
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
	
	<title>${HOU TORNG - Products}</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
	<!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">${Products & Services}</h1>
        </header>
        <!-- end page header -->

        <!-- begin sidebar -->
        <aside id="sidebar" class="one-fourth">
            <div class="widget">
                <h3>${Product Navigation}</h3>
                <nav>
                  <ul class="menu">
                    <li class="current-menu-item"><a class='product_type' href="index.php?act=product">${Product Video}</a></li>
					<?php foreach($classlv as $pdtype=>$pdlist): ?>    
					  <?php if(count($pdlist)>1):  // 有子類別，設定為開關 ?>
					  <li class='' ><a class='product_type product_level sublv-switch' ><?php echo $pdtype;?></a>
					    <ul class="menu hide">
					    <?php foreach($pdlist as $pd): ?>
					      <li class=""><a href="index.php?act=product/<?php echo rawurlencode($pd);?>"><?php echo $pd; ?></a></li>
					    <?php endforeach; ?>
					    </ul>
					  </li>
					  <?php else: // 無子類別，設定連結  ?>
					  <li class='' ><a class='product_type' href="index.php?act=product/<?php echo rawurlencode($pdtype);?>" ><?php echo $pdtype;?></a></li>
					  <?php endif;?>
					<?php endforeach; ?>
                  </ul>
                </nav>
            </div>
        </aside>
        <!-- end sidebar -->

        <!-- begin main content -->
        <section id="main" class="three-fourths column-last">
		
		    <!-- begin youtube video 嵌入Youtube影片-->
            <section>
                <h2 class="hmark">${Product Video}</h2>
                <div class="entry-video">
                    <iframe width="700" height="394" src="https://www.youtube.com/embed/ndcHlsA2LR0?rel=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </section>
            <!-- end youtube video -->
			
		    
			<ul class="square">
                    <li>${Mesh Belt Type Continuous Heat Treatment Equipment}</li>
                    <li>${Mesh Belt Type Continuous Stainless Steel Heat Treatment Furnace}</li>
                    <li>${Full Set Batch Type All Case Heat-treatment Equipment}</li>
                    <li>${Rotary Retort Carburizing Furnace}</li>
					<li>${Pit Type Carburizing and Nitriding Furnace}</li>
					<li>${Endothermic Gas Generator}</li>
                    <li>${Exothermic Gas Generator}</li>
                    <li>${Bell Type Annealing Furnace}</li>
                    <li>${Mesh Belt Type Continuous Dehydrogen Furnace}</li>
					<li>${Batch Type Aluminum Alloy T4、T6 Heat Treatment Equipment}</li>
            </ul>
			
        </section>
        <!-- end main content -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>