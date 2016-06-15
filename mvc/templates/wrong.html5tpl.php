<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_account.css" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.4.min.js"></script>
	
	<!-- PHP -->
	<?php 
	
	$page_element  = isset($this->vars['server']['data']) ? $this->vars['server']['data'] : '';
	$alert_message = isset($this->vars['server']['info']) ? $this->vars['server']['info'] : '';
	?>
	
	
  </head>
  <body>
    <div class='system_main_area '>
	  <!-- 系統TITLE BANNER -->
	  
	  <div class='system_body_area has_footer'>
	    <div class='system_body_block'>
		  <div class='ad_login_block tr_like' >
		
			  <div class='system_descrip_block'>
				<div class='desc_border'>相關資訊</div>
				  <p class='format_desc'>
					<ol class='test_list'>
					  <li><span class='test_title'>外交部國際傳播司</span>:<a href='http://www.mofa.gov.tw/Organization.aspx?n=2997758C3CAF3A58&sms=F685A0BE8BCF5188#hashA3013EA380D20271' target='_blank'> http://www.mofa.gov.tw/ </a></li>
					</ol>
				  </p>
				<div class='desc_border'>系統需求</div>
				  <p class='format_desc'>
					本系統使用 HTML5 , CSS3 網頁標準製作，請使用支援此標準的瀏覽器，並請勿關閉瀏覽器的 Javascript 支援，以得到最好的體驗。本系統支援瀏覽器清單如下: 				
				  </p>
				  <div class='support_browser tr_like'>
					<div class='support_item' ><a class='mark30 pic_chrome' title='前往下載 Chrome 瀏覽器' href='http://www.google.com/intl/zh-TW/chrome/' target='_blank' ></a></div>
					<div class='support_item' ><a class='mark30 pic_firefox' title='前往下載 Firefox 瀏覽器' href='http://mozilla.com.tw/firefox/new/' target='_blank' ></a></div>
					<div class='support_item' ><a class='mark30 pic_safari' title='前往下載 Safari 瀏覽器' href='http://www.apple.com/tw/safari/' target='_blank' ></a></div>
					<div class='support_item' ><a class='mark30 pic_opera' title='前往下載 Opera 瀏覽器' href='http://www.opera.com/zh-tw' target='_blank' ></a></div>
					<div class='support_item' ><a class='mark30 pic_explorer' href='http://windows.microsoft.com/zh-tw/internet-explorer/ie-9-worldwide-languages' target='_blank' ></a><span> 11 以上版本</span></div>
				  </div>
				  
				  <div class='desc_border'>連絡我們</div>
				  <table class='contact_table'>
					<tr> <td> 藍星球資訊股份有限公司 </td></tr>
					<tr> <td >（02）8978-7198#28</td> </tr>
					<tr> <td ><a href='mailto:<?php echo _SYSTEM_MAIL_CONTACT;?>' ><?php echo _SYSTEM_MAIL_CONTACT;?></a></td></tr>
				  </table>
			  </div>
			  <div class='system_login_area'>
				<div class='signin_header'> <h1>連結發生錯誤</h1> </div>
				<div class='alert_form'>			
				  <div class='login_element'>
			        <div class='field_name'> 錯誤訊息 : <span style='color:red;font-weight:600;'> <?php echo $alert_message; ?></span> </div>
			      </div>
				</div>
				<div class='register_borad'>
				  <a href="javascript: void(0)"   onclick="window.history.go(-1);" >回到上一頁</a>
				</div>			
			  </div>
			
		  </div>
		</div>
	  </div>
	</div>
	<?php include("area_admin_footer.php"); ?>
	
  </body>
</html>