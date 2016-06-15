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
	
	<!-- Self -->
	<link rel="stylesheet" type="text/css" href="theme/css/css_default.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_main.css" />
	<link rel="stylesheet" type="text/css" href="theme/css/css_staff_admin.css" />
	
	<script type="text/javascript" src="js_library.js"></script>
	<script type="text/javascript" src="js_admin.js"></script>
	<script type="text/javascript" src="js_staff_admin.js"></script>
	
	
	<!-- PHP -->
	<?php
	$user_info 		= isset($this->vars['server']['data']['user']) 		? $this->vars['server']['data']['user'] 	: array('user'=>array('user_name'=>'Anonymous'),'group'=>array());
	$role_list  	= isset($this->vars['server']['data']['roles']) 	? $this->vars['server']['data']['roles'] 	: array();  
	$data_list  	= isset($this->vars['server']['data']['accounts']) 	? $this->vars['server']['data']['accounts'] : array();  
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
		    <div class='topic_title'> 群組帳號管理 </div>
			<div class='topic_descrip'> 群組內之帳號審核、設定與管理 </div>
		  </div>
		  <div class='lunch_option'> 
		    
		  </div>
		</div>
		
		<div class='main_content' >
		  <!-- 資料列表區 -->
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
			      <td title='編號'	>編號</td>
				  <td title='群組'	>群組</td>
				  <td title='帳號'	>帳號</td>
			      <td title='單位'	>單位</td>
				  <td title='姓名'	>姓名</td>
				  <td title='電話'	>電話</td>
				  <td style='text-align:center;' ><i class='sysbtn btn_plus' id='act_staff_new' title='新增群組帳號'> + </i> </td>
			    </tr>
			    <tbody class='data_result'>
			    <?php foreach($data_list as $data): ?>  
			      <tr class='data_record _data_read' no='<?php echo intval($data['uno']);?>' >
                    <td field='uno'  	   ><?php echo $data['uno']; ?></td>
			        <td field='user_group' ><?php echo $data['user_group']; ?></td>
				    <td field='user_id'    ><?php echo $data['user_id']; ?></td>
				    <td field='user_organ' ><?php echo $data['user_organ']; ?></td>
				    <td field='user_name'  ><?php echo $data['user_name']; ?></td>
				    <td field='user_tel'   ><?php echo $data['user_tel']; ?></td>
				    <td ><i class='mark24 pic_account_status<?php echo $data['user_status'];?>' title='<?php echo $data['account_info']; ?>' ></i></td>
				  </tr> 
			    <?php endforeach; ?>
			      <tr class='data_field'>
			        <td title='編號'	>編號</td>
				    <td title='群組'	>群組</td>
				    <td title='帳號'	>帳號</td>
			        <td title='單位'	>單位</td>
				    <td title='姓名'	>姓名</td>
				    <td title='電話'	>電話</td>
				    <td title='狀態'	>狀態</td>
			      </tr> 
				</tbody>
				<tbody class='data_target'></tbody>
			  </table>
			  <div class='record_control'>
			    <span class='record_result'>  
			      顯示 <span> 1 </span> - <span> 10 </span> /  共 <span> <?php echo count($data_count); ?></span>  筆
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
			  <span class='record_name'>帳號資料</span>
			  <span class='record_option'>
                <i class='sysbtn' id='act_staff_save'><a class='btn_mark pic_save'  ></a></i>
				<a class='option view_switch' id='editor_switch' >  +  </a>
				<a class='option' id='editor_reform'  >  &times;  </a>
			  </span>
			</div> 
		    <div class='record_body tr_like' id='record_form_block'>  
			  <div class='form_block float_cell' id='meta_input'>
			      <div class='data_col tr_like'> <span class='data_field _necessary'> 登入帳號 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_id' default='readonly' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 姓名 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_name' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 代號 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_idno' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 職稱 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_staff' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 單位 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_organ' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field'> 連絡電話 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_tel' /> </span> </div>
				  <div class='data_col tr_like'> <span class='data_field _necessary'> 連絡信箱 </span><span class='data_value'> <input type='text' class='_variable _update' id='user_mail' /> </span> </div>
			  </div>
			  <div class='form_block float_cell' id='status_input'>
			    
				<div class='data_col tr_like'> 
				  <span class='data_field'> 使用期限 </span>
				  <span class='data_value'> 
				    <input type='text' class='datetime _variable _update' id='date_open' /> - <input type='text' class='datetime _variable _update' id='date_access' />
				  </span>
				</div>
				<div class='data_col tr_like'> 
				  <span class='data_field'> IP限制 </span>
				  <span class='data_value'> <input type='text' class='_variable _update' id='ip_range' /></span>
				</div>
				<div class='data_col tr_like' style='display:none;'> 
				  <span class='data_field'> 帳號群組 </span>
				  <span class='data_value'>  <span class='_variable' name='groups' id="main_group" >123</span>  </span> 
				</div>
				<div class='data_col tr_like' style='display:none;'> 
				  <span class='data_field'> 帳號角色 </span>
				  <span class='data_value'> 
				  <?php foreach($role_list as $role) : ?>  
				  <input type='checkbox' class='_variable _update' name='roles'  value='<?php echo $role['rno'];?>' > <label title='<?php echo $role['descrip'];?>'><?php echo $role['name'];?></label>
				  <?php endforeach; ?>  
				  </span> 
				</div>
				<div class='data_col tr_like' style='display:none;'> 
				  <span class='data_field'> 關聯群組 </span>
				  <span class='data_value'> <span class='_variable' name='groups' id="rela_group" >456</span> -</span> 
				</div>
				<div class='data_col tr_like'> 
				  <span class='data_field'> 帳號狀態 </span>
				  <span class='data_value'> 
				    <select class='_variable _update' id='user_status'>
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
			    <div class='data_col tr_like action_col'> 
				  <span class='data_field' > 帳號功能 </span>
				  <span class='data_value'> 
				    <select class='staff_function _reset' id='execute_function_selecter' >
					  <option value=''> - </option>
					  <optgroup label='[ 發信功能 ]'>
					    <option value='startmail' > - 寄發帳號開通&密碼重設通知 </option>
					  </optgroup>
					  <optgroup class='_attention' label='[ 帳號功能 ]' >
					    <option value='dele'> - 刪除帳號 </option>
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