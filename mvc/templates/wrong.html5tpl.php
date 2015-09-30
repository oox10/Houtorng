<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo _SYSTEM_SERVER_ADDRESS;?>theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo _SYSTEM_SERVER_ADDRESS;?>theme/css/css_login.css" />
    <link type="text/css" href="<?php echo _SYSTEM_SERVER_ADDRESS;?>tool/jScrollPane/jScrollPane.css" rel="stylesheet" media="all" />
	
	<!-- JS -->
	<script type="text/javascript" src="<?php echo _SYSTEM_SERVER_ADDRESS;?>tool/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo _SYSTEM_SERVER_ADDRESS;?>js_library.js"></script>
	<script type="text/javascript" src="<?php echo _SYSTEM_SERVER_ADDRESS;?>js_login.js"></script>
	
	<!-- PHP -->
	<?php 
	$page_element  = isset($this->vars['system_data']['data']) ? $this->vars['system_data']['data'] : '';
	$alert_message = isset($this->vars['system_data']['info']) ? $this->vars['system_data']['info'] : '';
	?>
	
	
  </head>
  <body>
	<div class='system_main_area'>
	  <div class='system_header_area'>
	  </div>
	  <div class='system_body_area'>
	    <div class='system_login_block'>
		  
		  <div class='login_header'>
		    <div class='login_title'>
			  <div class='archive_name' style='text-align:center;'>   <?php echo isset($page_element['archive']['archive_name']) ? $page_element['archive']['archive_name'] : '連結發生錯誤'; ?> </div>
			  <div class='archive_handle'> <?php if(isset($page_element['archive']['archive_handle'])) echo ' © '.$page_element['archive']['archive_handle']; ?> </div>
		    </div>
		  </div>
		  
		  <!-- 帳號登入 -->
		  <div class='login_block '>
		      <div class='login_element'>
			    <div class='field_name'> 系通發生錯誤 : <span style='color:red;font-weight:600;'> <?php echo $alert_message; ?></span> </div>
			  </div>
              <div class='login_element'>
                <div class='field_name'>若有任何問題請聯繫 [ <?php echo _SYSTEM_MAIL_CONTACT;?> ] </div>
			  </div> 			   
			</div>
			<div class='login_option'>
			  <div class='tr_like'>
			    <button  type='button' class='form_submit' id=''>回到登入頁面</button>   
			  </div>
			</div>
		</div>
		
	  </div> 
	  <div class='system_footer_area'></div>
	</div>
	
	<!-- 框架外結構  -->
	<div class='system_message_area'>
	  <div class='message_block'>
		<div id='message_container'>
		  <div class='msg_title'></div>
		  <div class='msg_info'><?php echo $alert_message; ?></div>
		</div>
		<div id='area_close'></div>
      </div>
	</div> 
	
	<!-- 系統Loading -->
    <div class='system_loading_area'>
	  <div class='loading_block' >
	    <div class='loading_string'> 系統處理中 </div>
		<div class='loading_image' id='sysloader'></div>
	    <div class='loading_info'>
		  <span >如果系統過久無回應，請按[ Esc ] 關閉 loading 版面，並重新操作剛才的動作.</span>
	    </div>
	  </div>
	</div>
	
	
  </body>
</html>