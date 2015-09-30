<?php //@skip-indexing ?>
<?php
session_start();
$paths = array(realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR));
set_include_path(implode(PATH_SEPARATOR, $paths));

include_once (dirname(__FILE__) . '/settings.php');
include_once (dirname(__FILE__) . '/admin/util.php');
include_once (dirname(__FILE__) . '/admin/db.php');
require_once 'Zend/Search/Lucene.php';

setlocale(LC_CTYPE, LOCALE);
$all_settings = get_all_settings();
Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive ());
$index = new Zend_Search_Lucene(get_setting('search_indexes_folder', $all_settings));
$search = $_REQUEST['s'];
$hits = $index->find(strtolower($search));
$current_page = array_key_exists('p', $_REQUEST)? $_REQUEST['p'] : '0';
$current_page = (intval($current_page)==0)? 1 : intval($current_page);
$current_page = max(1, min(count($hits), $current_page));

$items_per_page = get_setting('search_result_items', $all_settings);
$no_of_pages = intval(count($hits)/$items_per_page);
if(count($hits) % get_setting('search_result_items', $all_settings) > 0){
    $no_of_pages++;
}
$prev_page = ($current_page-1 > 0)? $current_page-1 : -1;
$next_page = ($current_page+1 <= $no_of_pages)? $current_page+1 : -1;
?>

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
	
	<title>Finesse - Search Results</title>
</head>

<body>
<!-- begin container -->
<div id="wrap">
    <?php include('includes/header.php'); ?>
        
    <!-- begin content -->
    <section id="content" class="container clearfix">
        <!-- begin page header -->
        <header id="page-header">
            <h1 id="page-title">Search Results</h1>	
        </header>
        <!-- end page header -->
        
        <!-- begin main content -->
        <p><?php echo count($hits);?> results found for &lsquo;<?php echo htmlentities($search);?>&rsquo;.</p>
        
        <!-- begin search results -->
        <ul id="search-results">
            <?php
                for($i = (($current_page-1)*$items_per_page); $i<min(($current_page*$items_per_page), count($hits)); $i++){
                    $page_title = $hits[$i]->getDocument()->getFieldValue('title');
                    $url = $hits[$i]->getDocument()->getFieldValue('url');
                    try{
                $short_description = $hits[$i]->getDocument()->getFieldValue('body');
                $first_pos = stripos($short_description, $search);
                if($first_pos){
                    $short_description = substr($short_description, $first_pos, intval(get_setting('search_description_length', $all_settings)));
                    if($first_pos > 0){
                        $short_description = '&hellip; '.$short_description;
                    }
                }else{
                    $short_description = '';
                }
                    }catch(Exception $e){
                        $short_description = '';
                    }

                    $page_title = preg_replace("/$search/i", '<strong>$0</strong>', $page_title);
                    $short_description = preg_replace("/$search/i", '<strong>$0</strong>', $short_description);

                    echo '<li>';
                    echo '<h2><a href="'.$url.'">'.$page_title.'</a></h2>';
                    echo '<p>'.$short_description.' &hellip;</p>';
                    echo '<p><a href="'.$url.'">'.$url.'</a></p>';
                    echo '</li>';
                }
            ?>
        </ul>
        <!-- end search results -->
        
        <!-- begin pagination -->
        <?php
        if(count($hits) > 0){
            echo '<nav class="page-nav">';
            echo '<span>Page '.$current_page.' of '.$no_of_pages.'</span>';
            echo '<ul>';
            echo '<li><a href="'.$_SERVER['PHP_SELF'].'?s='.$search.'">&laquo; First</a></li>';
            if($prev_page != -1){
                echo '<li><a href="'.$_SERVER['PHP_SELF'].'?s='.$search.'&p='.$prev_page.'">&lsaquo; Previous</a></li>';
            }
            $start_page = max(1, 5*(intval($current_page/5)));
            $end_page = min($no_of_pages, $start_page+4);
            while($start_page<=$end_page){
                if($start_page==$current_page){
                    echo '<li class="current">'.$start_page.'</li>';
                }else{
                    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?s='.$search.'&p='.$start_page.'">'.$start_page.'</a></li>';
                }
                $start_page++;
            }
            if($next_page != -1){
                echo '<li><a href="'.$_SERVER['PHP_SELF'].'?s='.$search.'&p='.$next_page.'">Next &rsaquo;</a></li>';
            }
            if($no_of_pages > 1){
                echo '<li><a href="'.$_SERVER['PHP_SELF'].'?s='.$search.'&p='.$no_of_pages.'">Last &raquo;</a></li>';
            }
            echo '</ul>';
            echo '</nav>';
        }
        ?>
        <!-- end pagination -->
        
        <!-- end main content -->
    </section>
    <!-- end content -->

    <?php include('includes/footer.php'); ?>
</div>
<!-- end container -->

</body>
</html>