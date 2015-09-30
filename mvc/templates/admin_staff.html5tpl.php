<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_staff.css" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.structure.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/jScrollPane/jScrollPane.css" rel="stylesheet" media="all" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="tool/jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="tool/Highcharts-4.0.4/js/highcharts.js"></script>
	<script type="text/javascript" src="tool/jScrollPane/jScrollPane_Group.js"></script>
	<script type="text/javascript" src="tool/canvasloader-min.js"></script>	
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_admin.js"></script>
	
	<!-- PHP -->
	<?php
	$user_account = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : 'Anonymous';
	$staff_list = isset($this->vars['system_data']['data']) ? $this->vars['system_data']['data'] : array();  
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
		  <span class='system_search ' > SS </span>
		</div>
		<div class='topic_banner tr_like'>
		  <div class='topic_header'> 
		    <div class='topic_title'> 員工帳號管理 </div>
			<div class='topic_descrip'>  系統帳號新增、維護與控管介面</div>
		  </div>
		  <div class='system_footprint'>
		    <ol class='footprint'> 
			  <li class='option'> Home </li>  
			  <li class='option nowat'> 員工帳號管理 </li>  
			</ol>
		  </div> 
		</div>
		<div class='main_content' >
		  <div class='data_record_block' id='record_selecter' >
		    <div class='record_header'>
			  <span class='record_name'>帳號清單</span>
			  <span class='record_option'>
			    <a class='option view_switch' >  −  </a>
			  </span>
			</div> 
			<div class='record_body'>
		      <div class='record_control'>
			    <span class='record_limit'>  
			      顯示 : <select class='record_view' ><option value=1> 1 </option><option value=5> 5 </option><option value=10 selected> 10 </option><option value='all' > ALL </option></select> 筆
			    </span>
			    <span class='record_search'>
			      搜尋 : <input class='search_input' type=text >
			    </span>
			  </div>
			  <table class='record_list'>
		        <tr class='data_field'>
			      <td>編號</td>
				  <td>帳號</td>
			      <td>姓名</td>
				  <td>職稱</td>
				  <td>信箱</td>
				  <td>電話</td>
				  <td>狀態</td>
			    </tr>
			    <tbody class='data_result'>
			    <?php foreach($staff_list as $staff): ?>  
			      <tr class='data_record _staff_read' no='<?php echo $staff['uno']?>' >
                    <td field='user_idno'  ><?php echo $staff['user_idno']; ?></td>
			        <td field='user_id'    ><?php echo $staff['user_id']; ?></td>
				    <td field='user_name'  ><?php echo $staff['user_name']; ?></td>
				    <td field='user_staff' ><?php echo $staff['user_staff']; ?></td>
				    <td field='user_mail'  ><?php echo $staff['user_mail']; ?></td>
				    <td field='user_tel'   ><?php echo $staff['user_tel']; ?></td>
				    <td ><i class='mark16 <?php echo $staff['account_start'] ? 'pic_account_on':'pic_account_off'; ?>' title='<?php echo $staff['account_info']; ?>' ></i></td>
				  </tr> 
			    <?php endforeach; ?>
			      <tr class='data_field'>
			        <td>編號</td>
				    <td>帳號</td>
			        <td>姓名</td>
				    <td>職稱</td>
				    <td>信箱</td>
				    <td>電話</td>
				    <td style='text-align:center;' ><i class='sysbtn btn_plus' id='act_staff_new' title='新增員工帳號'> + </i> </td>
			      </tr> 
				</tbody>
				<tbody class='data_target'></tbody>
			  </table>
			  <div class='record_control'>
			    <span class='record_result'>  
			      顯示 <span> 1 </span> - <span> 10 </span> /  共 <span> <?php echo count($staff_list); ?></span>  筆
			    </span>
				<span class='record_pages'>
				  <a class='page_tap page_to' page='prev' > &#171; </a>
				  <span class='page_select'>
				  <?php for($p=1 ; $p<=( count($staff_list)/10 + ((count($staff_list)%10)?1:0) ) ; $p++) : ?>  
			        <a class='page_tap <?php echo $p==1? 'page_now':'page_to';?>' page=<?php echo $p; ?> ><?php echo $p; ?></a>
				  <?php endfor; ?>
				  </span>
				  <a class='page_tap page_to' page='next' > &#187; </a>
				</span>
			  </div>
		    </div>
		  </div>
		  
		  <div class='data_record_block' id='record_editor'>
		    <div class='record_header'>
			  <span class='record_name'>帳號資料</span>
			  <span class='record_option'>
			    <i class='sysbtn' id='act_staff_save'><a class='btn_mark pic_save'  ></a></i>
				<a class='option view_switch' id='editor_switch' >  +  </a>
				<a class='option' id='editor_reform'  >  &times;  </a>
			  </span>
			</div> 
		    <div class='record_body tr_like' id='record_form_block'>  
			  <div class='form_block float_cell' id='meta_input'>
			      <div class='data_col tr_like'> <span class='data_field'> 員工編號 </span><span class='data_value'> <input type='text' class='_variable' id='user_idno' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 登入帳號 </span><span class='data_value'> <input type='text' class='_variable' id='user_id' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 員工姓名 </span><span class='data_value'> <input type='text' class='_variable' id='user_name' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 員工職稱 </span><span class='data_value'> <input type='text' class='_variable' id='user_staff' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 所屬部門 </span><span class='data_value'> <input type='text' class='_variable' id='user_organ' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 連絡電話 </span><span class='data_value'> <input type='text' class='_variable' id='user_tel' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 連絡信箱 </span><span class='data_value'> <input type='text' class='_variable' id='user_mail' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 連絡地址 </span><span class='data_value'> <input type='text' class='_variable' id='user_address' /> </span> </div>
			  </div>
			  <div class='form_block float_cell' id='status_input'>
			    <div class='data_col tr_like'> 
				  <span class='data_field'> 帳號狀態 </span>
				  <span class='data_value'> 
				    <select class='_variable' id='user_status'>
					    <option value=''> - </option>
					    <option value='0'> 0. 帳號已關閉 </option>
					    <option value='1'> 1. 帳號審核中 </option>
					    <option value='2'> 2. 審核通過，待啟動帳號 </option>
					    <option value='3'> 3. 已發送啟動通知 </option>
					    <option value='4'> 4. 重新設定密碼 </option>
					    <option value='5'> 5. 帳號已開通 </option>
					</select>
				  </span> 
				</div>
				<div class='data_col tr_like'> 
				  <span class='data_field'> 使用期限 </span>
				  <span class='data_value'> 
				    <input type='text' class='datetime _variable' id='date_open' /> - <input type='text' class='datetime _variable' id='date_access' />
				  </span>
				</div>
				<div class='data_col tr_like'> 
				  <span class='data_field'> 帳號權限 </span>
				  <span class='data_value'> 
				    <input type='checkbox' disabled=true> 登入 
					<input type='checkbox' disabled=true> 帳號
					<input type='checkbox' disabled=true> 客戶
					...
				  </span> 
				</div>
			    <div class='data_col tr_like'> <span class='data_field'> 相關備註 </span><span class='data_value'> <textarea class='_variable' id='user_note' /></textarea> </span> </div>
				<div class='data_col tr_like action_col'> 
				  <span class='data_field' > 帳號功能 </span>
				  <span class='data_value'> 
				    <select class='staff_function _reset' id='execute_function_selecter' >
					  <option value=''> - </option>
					  <optgroup label='[ 發信功能 ]'>
					    <option value='act_staff_mail_accept' > - 寄發帳號開通信 </option>
						<option value='' disabled=true> - 寄發信箱確認信 </option>
					    <option value='act_staff_mail_repw' disabled=true  > - 寄發密碼重新設定通知 </option>
					  </optgroup>
					  <optgroup class='_attention' label='[ 帳號功能 ]' >
					    <option value='act_staff_del'> - 刪除員工帳號 </option>
					  </optgroup>
					</select> 
				    <i class='sysbtn btn_activate' id='act_func_execute'> 執行 </i>
				  </span> 
				</div>
			    
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
		  <div class='msg_info'></div>
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