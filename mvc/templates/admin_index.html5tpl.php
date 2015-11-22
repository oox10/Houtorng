<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_index.css" />
    <link type="text/css" href="tool/jScrollPane/jScrollPane.css" rel="stylesheet" media="all" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_index.js"></script>
	
	
	<!-- PHP -->
	<?php 
	$alert_message = isset($this->vars['system_data']['info']) ? $this->vars['system_data']['info'] : '';
	?>
	
	
	
  </head>
  <body>
	<div class='system_main_area'>
	  <div class='system_header_area'>
	  </div>
	  <div class='system_body_area'>
	    <div class='system_login_block'>
		  <form class='login_form tr_like'>
		    <div class='user_picture'>
		      <img class='user_thumb' src='theme/image/user_thumb.png' />
		    </div>
			<div class='login_block '>
		      <div class='login_title'>
			    厚彤後台管理系統  v1.0   
			  </div>
			  <div class='login_element'>
			    <input type='text' class='form_input'  id='dt_aduacct'   placeholder="Account"> 
			  </div>
			  <div class='login_element '>
			    <input type='password' class='form_input' id='dt_adupass'  placeholder="Password"> 
			    <span class='form_submit'>
				  <button  type='button' class='form_submit' id='act_admin_login'>Log In</button>
				</span>
			  </div>
			  <div class='login_element '>
			  </div>			   
			</div>
		  </form>
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
		  <span style='display:none;'>如果系統過久無回應，請按[ Esc ] 關閉 loading 版面，並重新操作剛才的動作.</span>
	    </div>
	  </div>
	</div>
	
	
  </body>
</html>