<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_admin_product.css" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.structure.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css" rel="stylesheet" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="tool/jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="tool/canvasloader-min.js"></script>	
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_admin.js"></script>
	<script type="text/javascript" src="js_product.js"></script>
	
	<!-- Upload main CSS file -->
	<link href="tool/mini-upload-form/assets/css/style.css" rel="stylesheet" />
	<script src="tool/mini-upload-form/assets/js/jquery.knob.js"></script>
    <!-- jQuery File Upload Dependencies -->
	<script src="tool/mini-upload-form/assets/js/jquery.ui.widget.js"></script>
	<script src="tool/mini-upload-form/assets/js/jquery.iframe-transport.js"></script>
	<script src="tool/mini-upload-form/assets/js/jquery.fileupload.js"></script>
	<!-- Upload JS file -->
	<script src="tool/mini-upload-form/assets/js/script.js"></script>
	
	<!-- PHP -->
	<?php
	$user_account = isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : 'Anonymous';
	$data_lang = isset($this->vars['system_data']['data']['lang']) ? $this->vars['system_data']['data']['lang'] : array();  
	$data_list = isset($this->vars['system_data']['data']['record']) ? $this->vars['system_data']['data']['record'] : array();  
	$page_info = isset($this->vars['system_data']['info']) ? $this->vars['system_data']['info'] : '';  
	
	$list_count= count($data_list) ? count($data_list) : 0 ;
	
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
		    <div class='topic_title'> 產品管理 </div>
			<div class='topic_descrip'>  產品資料管理與顯示設定</div>
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
			  <span class='record_name'>產品清單</span>
			  <span class='record_option'>
			    <a class='option view_switch' >  −  </a>
			  </span>
			</div> 
			<div class='record_body'>
		      <div class='record_control'>
			    <span class='record_limit'>  
			      顯示 : <select class='record_view' ><option value=5> 5 </option><option value=10 selected> 10 </option><option value='all' > ALL </option></select> 筆
			    </span>
			    <span class='record_search'>
			      搜尋 : <input class='search_input' type=text >
			    </span>
			  </div>
			  <table class='record_list'>
		        <tr class='data_field'>
			      <td title='序號'		>No.</td>
				  <td title='類型'		> 類型</td>
				  <td title='品項'		> 品項</td>
				  <td title='建立者'	> 建立者</td>
				  <td title='建立時間'	> 建立時間</td>
				  <td title='狀態'		> 狀態  </td>
			    </tr>
			    <tbody class='data_result'>
			    <?php foreach($data_list as $data): ?>  
			      <tr class='data_record _data_read' no='<?php echo $data['pno']?>' >
                    <td field='rno'  			><?php echo $data['pno']; ?></td>
			        <td field='title_type'  	><?php echo $data['title_type']; ?></td>
				    <td field='title_product'  	><?php echo $data['title_product']; ?></td>
				    <td field='editer'			><?php echo $data['editer']; ?></td>
					<td field='time_edited'		><?php echo $data['time_edited']; ?></td>
					<td ><i class='_status_option mark24 <?php echo $data['_mask'] ? 'pic_status_stop':'pic_status_start'; ?>' title='' ></i></td>
				  </tr> 
			    <?php endforeach; ?>
			      <tr class='data_field'>
			        <td title='序號'	>No.</td>
				    <td title='類型'	> 類型</td>
				    <td title='品項'	> 品項</td>
					<td title='建立者'	> 建立者</td>
					<td title='建立時間'	> 建立時間</td>
				    <td style='text-align:center;' ><i class='sysbtn btn_plus' id='act_product_new' title='新增客戶資料'> + </i> </td>
			      </tr> 
				</tbody>
				<tbody class='data_target'></tbody>
			  </table>
			  <div class='record_control'>
			    <span class='record_result'>  
			      顯示 <span> 1 </span> - <span> 10 </span> /  共 <span> <?php echo $list_count; ?></span>  筆
			    </span>
				<span class='record_pages'>
				  <a class='page_tap page_to' page='prev' > &#171; </a>
				  <span class='page_select'>
				  <?php for($p=1 ; $p<=( $list_count/10 + (($list_count%10)?1:0) ) ; $p++) : ?>  
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
			  <span class='record_name'>產品資料</span>
			  <span class='record_option'>
			    <i class='sysbtn' id='act_product_save'><a class='btn_mark pic_save'  ></a></i>
				<a class='option view_switch' id='editor_switch' >  +  </a>
				<a class='option' id='editor_reform'  >  &times;  </a>
			  </span>
			</div> 
		    <div class='record_body tr_like' id='record_form_block'>  
			  <div class='form_block float_cell col1' id='meta_input'>
			    <div class='form_border'> 
				  <h1>編輯產品資料</h1>
                  <ul>
				    <?php foreach($data_lang as $key=>$lang):?>
					<li class='langsel <?php echo $key===0?'current':''; ?>' lang='<?php echo $lang['Name']; ?>' ><?php echo $lang['Comment']; ?></li>
				    <?php endforeach; ?>
				  </ul>
				</div>
				<?php foreach($data_lang as $lang):?>
			    <div class='form_element meta_lang' id='<?php echo $lang['Name']; ?>'>
			      <div class='data_col tr_like'> <span class='data_field '> 			<?php echo $lang['Name']=='meta_cht' ? '產品類型' : 'Type';   ?> </span> <span class='data_value'> <input type='text' class='_variable' id='title_type' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field _necessary'> 	<?php echo $lang['Name']=='meta_cht' ? '產品名稱' : 'Name';   ?> </span> <span class='data_value'> <input type='text' class='_variable' id='title_product' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 				<?php echo $lang['Name']=='meta_cht' ? '設計特點' : 'Strong'; ?> </span> <span class='data_value'> <textarea  class='_variable' id='design' ></textarea> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 				<?php echo $lang['Name']=='meta_cht' ? '產品用途' : 'UseTo';  ?> </span> <span class='data_value'> <textarea  class='_variable' id='useto'  ></textarea> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 				<?php echo $lang['Name']=='meta_cht' ? '產品規格' : 'Specification';  ?> </span> <span class='data_value'> <input type='text' class='_variable'  id='specification' /> </span> </div>
				</div>
                <?php endforeach; ?>				
			  </div>
			  <div class='form_block float_cell col1' id='relative_list'>
			    <div class='form_border'> 
				  <h1>產品顯示設定</h1>
				</div>
				<div class='form_element' id='products' >
				  <div class='data_col tr_like'> <span class='data_field '> 產品型號 </span> <span class='data_value'> <input type='text' class='_variable' id='product_id' readonly /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 購買客戶 </span> <span class='data_value'> <input type='text'  class='_variable' id='clients'  /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 顯示於網頁 </span> 
				    <span class='data_value'>
					  關閉 <span class='active_option' id='_mask' pass=1><i class='active_switch'></i></span> 顯示
					  ，
					  排序:
					  <select class='_variable' id='view_order' style='width:80px;'>
					  <?php for($i=1;$i<50;$i++):?>
					    <option value='<?php echo $i;?>'> <?php echo $i;?> </option>
					  <?php endfor; ?>
					  </select>(小排在前)
					</span> 
			      </div>
				  <div class='data_col'> 
 				    <div style='table-column'>
				      <span class='data_field'> 上傳照片: </span>
				      <span class='data_value'> <span class='sysbtn' id='act_open_upload' title='開啟上傳'  ><a class='mark16 pic_upload'></a></span></span>
					  <span class='data_value' > ( 拖曳可改變影像顯示排序 ) </span>
					</div >
					<div style='table-column'>
					  <ul class='object-pool tr_like _relative' id='product_display_object'>
					    
					  </ul> 
					</div>
				  </div>
				 
				  
                  <div class='data_col tr_like'> <span class='data_field '> 資料備註 </span> <span class='data_value'> <input type='text' class='_variable' id='temp'  /> </span> </div>
				  <div class='data_col tr_like action_col'> 
				    <span class='data_field' > 其他功能 </span>
				    <span class='data_value'> 
				      <select class='staff_function _reset' id='execute_function_selecter' >
					    <option value=''> - </option>
					    <optgroup class='_attention' label='[ 產品管理 ]' >
					      <option value='act_customers_del'> - 刪除產品資料 </option>
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
	
	<!-- 系統檔案上傳 -->
	<div class='system_upload_area'>
	  <div id='order_upload'>
		<div class='cont_block'>
		  <form id="upload" method="post" action="?act=act_upload_pdobj" enctype="multipart/form-data">
		    <input type='hidden' id='record_num' name='record_num' value=''  />
			<div class='upload_banner'><span class='block_title'> <i id='upload_record_no'></i>    圖片上傳 : </span></div> 
			<div class='upload_option'><a class='mark16 pic_close' id='act_close_upload'></a></div> 
			<div id="drop">
			  將檔案拖曳到此 或
			  <a>選擇檔案</a>
			  <input type="file" name="upl" multiple />
			</div>
			<ul class='_relative'> <!-- The file uploads will be shown here --> </ul>
		  </form>
		</div>
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