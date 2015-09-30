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
	<script src="js/jquery.jcarousel.min.js" type="text/javascript"></script> <!-- carousel -->
    <script src="js/jquery.ui.totop.min.js" type="text/javascript"></script> <!-- scroll to top -->
	<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script> <!-- lightbox -->
    <script src="js/jquery.cycle.all.js" type="text/javascript"></script> <!-- entry slider -->
    <script src="js/jquery.fitvids.js" type="text/javascript"></script> <!-- responsive video embeds -->
	<script src="js/jquery.tweet.js" type="text/javascript"></script> <!-- Twitter widget -->
	<script src="js/jquery.touchSwipe.min.js" type="text/javascript"></script> <!-- touchSwipe -->
    <script src="js/custom.js" type="text/javascript"></script> <!-- jQuery initialization -->
    <!-- end JS -->
	
	<!-- php variable-->
	<?php
	$products = isset($this->vars['system_data']['data']['product']) ?  $this->vars['system_data']['data']['product'] : array();
	$classlv  = isset($this->vars['system_data']['data']['classlv']) ?  $this->vars['system_data']['data']['classlv'] : array();
	$target   = isset($this->vars['system_data']['data']['target'])  ?  $this->vars['system_data']['data']['target'] : '';
	$result   = isset($this->vars['system_data']['data']['result'])  ?  $this->vars['system_data']['data']['result'] : array();
	
	$product_index = $target ? '':'current-menu-item';
	
	?>
	
	
	<title>HOU TORNG - Products</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
	<!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">Products & Services</h1>
        </header>
        <!-- end page header -->

        <!-- begin sidebar -->
        <aside id="sidebar" class="one-fourth">
            <div class="widget">
                <h3>Product Navigation</h3>
                <nav>
                  <ul class="menu">
                    <li class="<?php echo $product_index; ?>"><a class='product_type' href="index.php?act=product">Product Video</a></li>
					<?php foreach($classlv as $pdtype=>$pdlist): ?>    
					  <?php if(count($pdlist)>1):  // 有子類別，設定為開關 ?>
					  <li class='' ><a class='product_type product_level sublv-switch' ><?php echo $pdtype;?></a>
					    <ul class="menu <?php echo in_array($target,$pdlist) ? 'show':'hide'; ?>">
					    <?php foreach($pdlist as $pd): ?>
					      <li class="<?php echo ($pd==$target)?'current-menu-item':''; ?>"><a href="index.php?act=product/<?php echo rawurlencode($pd);?>"><?php echo $pd; ?></a></li>
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
		
		    <!-- begin  產品照片slider-->
            <section>
                <h2><?php echo $result['title_product']?></h2>
                <div class="entry-slider">
                    <ul>
						<?php foreach($result['images'] as $key => $pimg): ?>
                          <?php if(!$key): ?>
						  <li><a class="fancybox" data-fancybox-group="gallery-living-brown" href="<?php echo $pimg['acc_name'];?>" title="<?php echo $result['title_product'];?>"><span class="overlay zoom"></span><img src="<?php echo $pimg['acc_name'];?>" alt=""></a></li>	
						  <?php else:  ?>
                          <li style="display: none;"><a class="fancybox" data-fancybox-group="gallery-living-brown" href="<?php echo $pimg['acc_name'];?>" title="<?php echo $result['title_product'];?>"><span class="overlay zoom"></span><img src="<?php echo $pimg['acc_name'];?>" alt=""></a></li>
						  <?php endif; ?>	
						<?php endforeach; ?>
					</ul>
                </div>
            </section>
            <!-- end 產品照片slider-->

			<!-- begin 特色與應用 -->
			<?php if($result['design']): ?>
			<div class="one-half">
				<h2>Features</h2>
				<p>
				<ul class="check">
				<?php 
				$designs = preg_split('/‧|，|、/',$result['design']);
				foreach($designs as $d){
				  if($d){ echo "<li>".$d."</li>"; }
                }    
				?>
				</ul>
				</p>
			</div>
			<?php endif;?>
			
			<?php if($result['useto']): ?>
			<div class="one-half column-last">
				<h2>Applications</h2>
				<p>
				<ul class="square">
                <?php 
				$designs = preg_split('/‧|，|、/',$result['useto']);
				foreach($designs as $d){
				  if($d){ echo "<li>".$d."</li>"; }
                }    
				?>
				</ul>
				</p>
			</div>
			<?php endif;?>
			
			<div class="clear"></div>
			
			<!-- end 特色與應用-->
			
			
			
			
        </section>
        <!-- end main content -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>