<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<title><?php echo defined('_SYSTEM_HTML_TITLE') ? _SYSTEM_HTML_TITLE : 'RCDH System'; ?></title>
	
	<!-- CSS -->
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.structure.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css" rel="stylesheet" />
	<link type="text/css" href="tool/font-awesome-4.6.2/css/font-awesome.min.css" rel="stylesheet" />
	
	<!-- JS -->
	<script type="text/javascript" src="tool/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="tool/jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="tool/canvasloader-min.js"></script>	
    <script type="text/javascript" src="tool/html2canvas.js"></script>	  
	
	<!-- dropzone file uoloader -->
	<script type="text/javascript" src="tool/dropzone-4.2.0/dropzone.min.js"></script>
	
	
	<!-- Self -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_product_admin.css" />
	
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_admin.js"></script>
	<script type="text/javascript" src="js_product_admin.js"></script>
	
	
	<!-- PHP -->
	<?php
	$user_info 		= isset($this->vars['server']['data']['user']) 		? $this->vars['server']['data']['user'] 	: array('user'=>array('user_name'=>'Anonymous'),'group'=>array());
	$data_lang  	= isset($this->vars['server']['data']['lang']) 		? $this->vars['server']['data']['lang'] 	: array();  
	$data_list  	= isset($this->vars['server']['data']['products']) 	? $this->vars['server']['data']['products'] : array();  
	$data_count 	= count($data_list);
	
	$page_info 		= isset($this->vars['server']['info']) ? $this->vars['server']['info'] : '';  
	
	?>
  </head>
  <body>
	<div class='system_main_area'>
	  <div class='system_manual_area'>
	  <?php include('area_admin_manual.php'); ?>
	  </div>
	  <div class='system_content_area'>
        <div class='tool_banner' >
		  <ol id='system_breadcrumbs' typeof="BreadcrumbList" >
		  </ol>
		  <span class='account_option tool_right'>
		    <div class='account_info'>
			  <span id='acc_mark'><i class='m_head'></i><i class='m_body'></i></span>
			  <span id='acc_string'> 
			    <i class='acc_name'><?php echo $user_info['user']['user_name']; ?></i>
			    <i class='acc_group'><?php echo $user_info['user']['user_group']; ?></i>
			  </span>
			  <span id='acc_option'><a class='mark16 pic_more'></a> </span>
			</div>
		    <div class='account_control arrow_box'>
			  <ul class='acc_option_list'>
			    <li >
				  <label title='目前群組'> <i class="fa fa-university" aria-hidden="true"></i> 群組 </label>
				  <select id='acc_group_select'>
				    <?php foreach($user_info['group'] as $gset): ?>  
				    <option value='<?php echo $gset['id']?>' <?php echo $gset['now']?'selected':'' ?> > <?php echo $gset['name']; ?></option>
				    <?php endforeach; ?>
				  </select>
				</li>
				<li> 
				  <label> <i class="fa fa-user-secret" aria-hidden="true"></i> 角色 </label>
				  <span>
				    <?php foreach($user_info['group'] as $gid => $gset): ?>  
				    <?php if($gset['now']) echo join(',',$gset['roles']); ?>
				    <?php endforeach; ?>
				  </span> 
				</li>
				<li>
				  <label> <i class="fa fa-clock-o" aria-hidden="true"></i> 登入</label>
				  <span> <?php echo $user_info['login']; ?></span>
				</li>
			  </ul>
			  <div class='acc_option_final'>
			    <span id='acc_logout'> 登出 </span>
			  </div>
		    </div>
		  </span>
		</div>
		
		<div class='topic_banner'>
		  <div class='topic_header'> 
		    <div class='topic_title'> 產品資料管理 </div>
			<div class='topic_descrip'> 產品資料設定與影像管理 </div>
		  </div>
		  <div class='lunch_option'> 
		    
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
					<td ><i class='_status_option mark24 <?php echo $data['_view'] ? 'pic_status_start':'pic_status_stop'; ?>' title='' ></i></td>
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
			      顯示 <span> 1 </span> - <span> 10 </span> /  共 <span> <?php echo $data_count; ?></span>  筆
			    </span>
				<span class='record_pages'>
				  <a class='page_tap page_to' page='prev' > &#171; </a>
				  <span class='page_select'>
				  <?php for($p=1 ; $p<=( count($data_list)/10 + ((count($data_list)%10)?1:0) ) ; $p++) : ?>  
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
				  <div class='data_col tr_like'> 
				    <span class='data_field'> 產品排序 </span> 
				    <span class='data_value'>
					  <select class='_variable' id='view_order' style='width:80px;'>
					  <?php for($i=1;$i<50;$i++):?>
					    <option value='<?php echo $i;?>'> <?php echo $i;?> </option>
					  <?php endfor; ?>
					  </select>(小排在前)
					</span> 
			      </div>
				  <div class='data_col tr_like'> 
				    <span class='data_field'> 顯示於網站 </span> 
				    <span class='data_value'>
					  關閉 <span class='active_option' id='_view' pass=1><i class='active_switch'></i></span> 顯示
					</span> 
			      </div>
				  <div class='data_col tr_like'> 
				    <span class='data_field'> 顯示於首頁 </span> 
				    <span class='data_value'>
					  關閉 <span class='active_option' id='view_index' pass=0><i class='active_switch'></i></span> 顯示
					</span> 
			      </div>
				  <div class='data_col'> 
 				    <div style='table-column'>
				      <span class='data_field'> 上傳照片: </span>
				      <span class='data_value'><i class='sysbtn btn_activate' id='act_open_upload'> 開啟 </i></span>
					  
					</div >
					<div style='table-column'>
					  <ul class='object-pool tr_like _relative' id='product_display_object'>
					    
					  </ul>
                      				  
					</div>
					<div style='table-column'>
				      <span class='data_field'> tips 排序: </span>
				      <span class='data_value'> <span class='data_value' > 拖曳照片可改變影像顯示順序 </span> </span>
					</div >
				  </div>
				  <div class='data_col tr_like'> <span class='data_field'> 影片多媒體 </span> <span class='data_value'> <input type='text'  class='_variable' id='media'  /> </span> </div>
				  
				 
				  <div class='data_col tr_like action_col'> 
				    <span class='data_field' > 其他功能 </span>
				    <span class='data_value'> 
				      <select class='staff_function _reset' id='execute_function_selecter' >
					    <option value=''> - </option>
					    <optgroup class='_attention' label='[ 產品管理 ]' >
					      <option value='pdel'> - 刪除產品資料 </option>
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
	
	
	<!-- 檔案上傳區塊  -->
	<div class='upload_area'>
      <div class='header_border'>
	    <h1> 檔案上傳 </h1>
	    <span id='progress_info'>
		  <span id='num_of_upload' >0</span> -
		  <span id='num_of_queue' >0</span> /
		  <span id='execute_timer' >0</span>
		  <span id='complete_time' > _ </span>
		</span>
		<div class='area_option'>
		  <i class='mark16 pci_area_mini option' ></i>
		  <i class='mark16 pci_area_close_x option' id='act_upload_close' ></i>
		</div>
	  </div>
	  <div class='upload_setting'>
	    <div class='upload_config'>
		  <div class='field_set'>
			<label>處理結果</label>
			<textarea class='' id='upl_process_result' disabled=true ></textarea>
		  </div> 
		</div>
		<div class='upload_action'>
		  <button type='button' class='select' id='act_select_file'> 新增檔案 </button>
		  <button type='button' class='active' id='act_active_upload' disabled=true  data-folder=''> 上傳 </button>
		  <button type='button' class='cancel' id='act_clean_upload'> 清空 </button>
		</div>
	  </div>
	  <div class='upload_list ' id='upload_dropzone'></div>
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
	<!-- 系統report -->
      <div class='system_feedback_area'>
        <div class='feedback_block'>
        <div class='feedback_header tr_like' >
          <span class='fbh_title'> 系統回報 </span>
          <a class='fbh_option' id='act_feedback_close' title='關閉' ><i class='mark16 pic_close'></i></a>
        </div>
        <div class='feedback_body' >
          <div class='fb_imgload'> 建立預覽中..</div>
          <div class='fb_preview'></div>
          <div class='fb_areasel'>
            <span>回報頁面:</span>
            <input type='radio' class='feedback_area_sel' name='feedback_area' value='system_body_block'>全頁面
            <input type='radio' class='feedback_area_sel' name='feedback_area' value='system_content_area'>中版面
            <input type='radio' class='feedback_area_sel' name='feedback_area' value='system_edit_area'>右版面
            <input type='radio' class='feedback_upload_sel' name='feedback_area' value='user_upload'><input type='file'  id='feedback_img_upload' >
          </div>
          <div class='fb_descrip'>
            <div class=''>
              <span class='fbd_title'>回報類型:</span>
              <input type='checkbox' class='feedback_type' name='fbd_type' value='資料問題' ><span >資料問題</span>，
              <input type='checkbox' class='feedback_type' name='fbd_type' value='系統問題' ><span >系統問題</span>，
              <input type='checkbox' class='feedback_type' name='fbd_type' value='使用問題' ><span >使用問題</span>，
              <input type='checkbox' class='feedback_type' name='fbd_type' value='建議回饋' ><span >建議回饋</span>，
              <input type='checkbox' class='feedback_type' name='fbd_type' value='其他' >其他:<input type='text' class='fbd_type_other' name='fbd_type_other' value='' >
            </div>
            <div class='fbd_title'>回報描述:</div>
            <textarea  class='feedback_content'  name='fbd_content'></textarea>
          </div>
        </div>
        <div class='feedback_bottom tr_like' >
          <a class='sysbtn btn_feedback' id='act_feedback_cancel' > <i class='mark16 pic_account_off'></i> 取 消 </a>
          <a class='sysbtn btn_feedback' id='act_feedback_submit' > <i class='mark16 pic_account_on'></i> 送 出 </a>		
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