<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_business.css" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.structure.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css" rel="stylesheet" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="tool/jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="tool/canvasloader-min.js"></script>	
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_admin.js"></script>
	<script type="text/javascript" src="js_product.js"></script>
	
	<!-- PHP -->
	<?php
	$user_account = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : 'Anonymous';
	$data_lang = isset($this->vars['system_data']['data']['lang']) ? $this->vars['system_data']['data']['lang'] : array();  
	$data_list = isset($this->vars['system_data']['data']['record']) ? $this->vars['system_data']['data']['record'] : array();  
	$page_info = isset($this->vars['system_data']['info']) ? $this->vars['system_data']['info'] : '';  
	
	$list_count= count($data_list) ? array_sum(array_map(function($a){return count($a);}, $data_list)) : 0 ;
	
	?>
  </head>
  <body>
	<div class='system_main_area'>
	  <div class='system_manual_area'>
	  <?php include('area_admin_manual.php'); ?>
	  </div>
	  <div class='system_content_area'>
        <div class='tool_banner' >
		  <span class='system_alert'></span>
		  <span class='system_setting'></span>
		  <span class='account_option tool_right'>
		    <div class='account_info'>
			  <span id='acc_mark'><i class='m_head'></i><i class='m_body'></i></span>
			  <span id='acc_string'> <?php echo $user_account; ?> </span>
			  <span id='acc_option'><a class='mark16 pic_more'></a> </span>
			</div>
		    <div class='account_control arrow_box'>
			  <ul class='acc_option_list'>
			    <li>  </li>
			  </ul>
			  <div class='acc_option_final'>
			    <span id='acc_logout'> 登出 </span>
			  </div>
		    </div>
		  </span>
		  <span class='system_search ' > </span>
		</div>
		<div class='topic_banner tr_like'>
		  <div class='topic_header'> 
		    <div class='topic_title'> 業務實績 </div>
			<div class='topic_descrip'>  業務實績列表編輯</div>
		  </div>
		  <div class='system_footprint'>
		    <ol class='footprint'> 
			  <li class='option'> Home </li>  
			  <li class='option nowat'>  </li>  <!-- 內容由 javascript insert -->
			</ol>
		  </div> 
		</div>
		<div class='main_content' >
		  <!-- 資料列表區 -->
		  <div class='data_record_block' id='record_selecter' >
		    <div class='record_header'>
			  <span class='record_name'>實績清單</span>
			  <span class='record_option'>
			    <a class='option view_switch' >  −  </a>
			  </span>
			</div> 
			<div class='record_body'>
		      <div class='record_control'>
			    <span class='record_limit'>  
			      顯示 : <select class='record_view' ><option value='all' > ALL </option></select> 筆
			    </span>
			  </div>
			  <?php foreach($data_list as $type=>$product_set): ?>
			  <table class='record_list'>
		        <tr class='data_title'><td colspan=7><?php echo $type;?></td></tr>
				<tr class='data_field'>
			      <td title='型號'		> 型號</td>
				  <td title='公司'		> 公司</td>
				  <td title='地區'		> 地區</td>
				  <td title='產量'		> 產量</td>
				  <td title='數量'		> 數量  </td>
				  <td title='用途'		> 用途  </td>
				  <td title='顯示'		> 顯示  </td>
			    </tr>
			    <tbody class='data_result'>
			    <?php foreach($product_set as $data): ?>  
			      <tr class='data_record _data_read' no='<?php echo $data['bin']?>' >
                    <td field='product_type' ><?php echo $data['product_type']; ?></td>
			        <td field='company'  	 ><?php echo $data['company']; ?></td>
				    <td field='location'  	 ><?php echo $data['location']; ?></td>
				    <td field='output'		 ><?php echo $data['output']; ?></td>
					<td field='sellCount'	 ><?php echo $data['sellCount']; ?></td>
					<td field='useTo'		 ><?php echo $data['useTo']; ?></td>
					<td ><i class='_status_option mark24 <?php echo $data['_show'] ? 'pic_status_start':'pic_status_stop'; ?>' title='' ></i></td>
				  </tr> 
			    <?php endforeach; ?>
			      <tr class='data_field'>
			        <td title='型號'		> 型號</td>
				    <td title='公司'		> 公司</td>
				    <td title='地區'		> 地區</td>
				    <td title='產量'		> 產量</td>
				    <td title='數量'		> 數量  </td>
				    <td title='用途'		> 用途  </td>
				    <td style='text-align:center;' ><i class='sysbtn btn_plus' id='act_product_new' title='新增資料'> + </i> </td>
			      </tr> 
				</tbody>
				<tbody class='data_target'></tbody>
			  </table>
			  <?php endforeach; ?>
			  
			  
			  <div class='record_control'>
			    <span class='record_result'>  
			       共 <span> <?php echo $list_count; ?></span>  筆
			    </span>
				
			  </div>
		    </div>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- 框架外結構  -->
	<div class='system_message_area'>
	  <div class='message_block'>
		<div id='message_container'>
		  <div class='msg_title'></div>
		  <div class='msg_info'><?php echo $page_info;?></div>
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