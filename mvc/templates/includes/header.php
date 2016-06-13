<?php include('menu.php'); ?>
<!-- begin header -->
<header id="header" class="container">
    <!-- begin header top -->
    <section id="header-top" class="clearfix">
        <!-- begin header left -->
        <div class="one-half">
            <h1 id="logo"><a href="index.php"><img src="images/logo.png" alt="HouTorng"></a></h1>
            <p id="tagline">${Industrial Heat Treating Equipment Manufacturer}</p>
        </div>
        <!-- end header left -->

        <!-- begin header right -->
        <div class="one-half column-last">
            <!-- begin language switcher 語言選單-->
            <div id="polyglotLanguageSwitcher">
                <form action="">
                    <select id="polyglot-language-options">
                        <option id="en" value="en" <?php echo isset($_SESSION['language'])&&$_SESSION['language']=='meta_eng'?'selected':'';?>>English</option>
 						<option id="tw" value="tw" <?php echo isset($_SESSION['language'])&&$_SESSION['language']=='meta_cht'?'selected':'';?>>中文</option>
                    </select>
                </form>
            </div>
            <!-- end language switcher -->

            <!-- begin contact info 聯絡資訊-->
            <div class="contact-info">
                <p class="phone">+886-3-427-1570</p>
                <p class="email"><a href="mailto:houtrung@ms58.hinet.net">houtrung@ms58.hinet.net</a></p>
            </div>
            <!-- end contact info -->
        </div>
        <!-- end header right -->
    </section>
    <!-- end header top -->

    <!-- begin navigation bar -->
    <section id="navbar" class="clearfix">
        <!-- begin navigation -->
        <nav id="nav">
            <?php print_main_menu($menu); ?>
        </nav>
        <!-- end navigation -->

        
    </section>
    <!-- end navigation bar -->

</header>
<!-- end header -->