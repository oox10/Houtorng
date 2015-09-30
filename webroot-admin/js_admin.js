/*    
  
  javascrip use jquery 
  rcdh 10 javascript pattenr rules v1
  
*/
 
  /**************************************   
	    HAN-Archive Admin System     
  **************************************/
	
  $(window).load(function () {   //  || $(document).ready(function() {	
	
	
	/* [ System Work Function Set ] */
	
	
	//-- page initial alert
	if($('.msg_info').html()){
	  system_message_alert('','');
	}
	
	//-- admin manual action navigation
	$('.func_activate').click(function(){
	  if($(this).hasClass('func_undo')){
	    alert("尚未開放");
	  }else{
	    location.href='admain.php?act='+$(this).attr('id');
	  }
	});
	
	//-- system manual heightline & footpring insert
	var act_name = location.search.replace(/^\?act=/,'');
	if($('#'+act_name).length){
	  $('#'+act_name).parent().addClass('atthis');	
	  var action_name = $('#'+act_name).html();
	}
	
	if($('.footprint li.nowat').length){
	  $('.footprint li.nowat').html(action_name);
	}
	
	
	//-- 系統loading 版面設定
	if(!$('.system_loading_area').length){  
	  var SysLoader = $('<div/>').addClass('system_loading_area');
	  var loadBlock = $('<div/>').addClass('loading_block');
	  $('<div/>').addClass('loading_string').html('系統處理中').appendTo(loadBlock);
	  $('<div/>').addClass('loading_image').attr('id','sysloader').appendTo(loadBlock);
	 // $('<div/>').addClass('loading_info').html('如果系統過久無回應，請按[ Esc ] 關閉 loading 版面，並重新操作剛才的動作.').appendTo(loadBlock);
	  SysLoader.append(loadBlock);
	  $('body').append(SysLoader);	  
	}
	  sysloading = new CanvasLoader('sysloader');
      sysloading.setColor('#449dc7'); // default is '#000000'
      sysloading.setShape('spiral'); // default is 'oval'
      sysloading.setDiameter(30); // default is 40
      sysloading.setDensity(30); // default is 40
      sysloading.setRange(0.7); // default is 1.3
      sysloading.setFPS(20); // default is 24
      sysloading.hide(); // Hidden by default
	
	
	//-- 系統Loading 沒反應之處理
	function cancel_pre_action(){
      if(window.stop !== undefined){
        window.stop();
      }else if(document.execCommand !== undefined){
       document.execCommand("Stop", false);
      }
    }
    
	//-- cancel system loading
	$(document).keydown(function(event){
	  if(event.keyCode==27){
	    if($('.system_loading_area').is(':visible')){
		  cancel_pre_action();
		  system_loading();
		}
	  }	
	});
	
	
	//-- 系統介面排版設定
	resite_form_area();
	$(window).resize(function() {
	  resite_form_area();			
	});
	
	
	// 設定填寫版面排版
	function resite_form_area(){
	  if( $('.data_record_block').length ){	  
	    if( $('.data_record_block').width() < 1050 ){
		  $('.float_cell').removeClass('col2').addClass('col1');  
	    }else{
		  $('.float_cell').removeClass('col1').addClass('col2');  	
		}
	  }
	}
	
	
	/* [ Admin Account Function Set ] */
	
	//-- 系統帳號相關功能
	
	// 帳號功能版面開關 
	$('.account_info').click(function(){
	  if($('.account_control').length){
		$('.account_control').toggle();   
	  }		
	});
	
	$('#acc_logout').click(function(){
	  location.href = 'admain.php?act=logout' 	;  
	});
	
	
	
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	
	/* [ Admin Work Function Set ] */
	
	var data_orl = {};
	
	
	//-- check editor value modify
	$('._variable').on('keyup change blur',function(){
	  var field_name = $(this).attr('id');
	  var form_value = $(this).val();
	  
	  if(data_orl[field_name] == undefined ){
		data_orl[field_name] = '';  
	  }
	  
	  if( data_orl[field_name] !== form_value ){
	    $(this).addClass('_modify');    
	  }else{
	    if($(this).hasClass('_modify')){
		  $(this).removeClass('_modify');    
		}
	  }
	});
	
	
	
	//-- return to list
	$(document).on('click','._return_list',function(){
	  if($('._return_form').length){
		$('#editor_backto').trigger('click');  
	  }
	  $('#editor_reform').trigger('click');
	});
	
	//-- return to form
	$(document).on('click','._return_form',function(){
	  $('#editor_backto').trigger('click');
	});
	
	
	
	//-- 資料頁面開關
	$('.view_switch').click(function(){
	  var target_block = $(this).parents('div.record_header').next();
	  if( target_block.is(":visible")){
	    $(this).html(' + ');
	  }else{
		$(this).html(' − ');
	  }
	  target_block.toggle();
	});
	
	
	//-- 關閉編輯頁面
	$('#editor_reform').click(function(){
	  
	  if($('._modify').length){
	    if( !confirm("確定要放棄變更資料?") ){
		  return false;
		}
	  }
	  
	  $('._variable').val('').removeClass("_modify").prop('disabled',false).prop('readonly',false);  // 欄位重設
	  $('._reset').val('');  // 動作重設
	  $('._target').removeClass('_target'); // 移除目標資料標註
	  $('._relative').empty(); // 關連資料需清空
	  
	  $('#record_selecter').find('.record_list').children('.data_target').empty().hide();
	  $('#record_selecter').find('.record_list').children('.data_result').show();
	  $('#record_selecter').find('.record_control').show();
	  
	  var target_block = $(this).parents('div.record_header').next();
	  if(target_block.is(":visible")){
        $('#editor_switch').trigger('click');
	  }
	  active_header_footprint_option('record_selecter','','_return_list');
	  if($("tr.data_record[no='_addnew']").length){ $("tr.data_record[no='_addnew']").remove(); }
	  
	});
	
	
	
	/* { GROUP } Data Split 、 Select & Page Tap */
	
	//-- 資料顯示列數切換資料與分頁
	$('.record_view').change(function(){
	  var record_view = $(this).val();
	  // select display row num 
	  var display_row_num = record_table_display( record_view , $('tr.data_record').length ,  1 );
	  // create page switch element
	  record_page_built( display_row_num , $('tr.data_record').length , 1);
	});
	
	//-- 資料跳頁
	$(document).on('click','.page_to',function(){
	  
	  var page_to  = $(this).attr('page');
      var page_now = parseInt($('.page_now').attr('page'));
	  var display_row_num = $('.record_view').val()=='all' ? $('tr.data_record').length : $('.record_view').val() ;
	  var max_page = parseInt( $('tr.data_record').length/display_row_num ) + ($('tr.data_record').length%display_row_num ? 1 : 0 );
	  
	  switch(page_to){
		case 'prev':  var new_page = (page_now-1) > 0 ? page_now-1 : page_now  ;  break;
		case 'next':  var new_page = ((page_now+1) > max_page) ? page_now : page_now+1 ;  break;
        default:  new_page = page_to;  break; 		
	  }
	  record_table_display( display_row_num , $('tr.data_record').length , new_page ) ; 
	  record_page_built( display_row_num , $('tr.data_record').length , new_page)
	});
	
	
	//-- 資料搜尋 Step 1
    var search_buff  = '';
	var display_data = {};
	$('.search_input').keydown(function(){
	  search_buff = $('.search_input').val();
	  
	  // 儲存原始分頁變數
	  if( !Object.keys(display_data).length ){
		display_data.page_num =  parseInt($('.page_now').attr('page'));
		display_data.row_num  =  $('.record_view').val();
	  }
	});
	
	//-- 資料搜尋 Step 2
	$('.search_input').keyup(function(){
	  	
	  if( $('.search_input').val() !=''  &&  $('.search_input').val() !='＿' ){
	    if(search_buff != $('.search_input').val()){  //搜尋內容有改變才需要執行
		  
		  // 搜尋資料,並顯示資料列
		  var search_term = $('.search_input').val();
		  $('tr.data_record').hide();
	      $('tr.data_record').filter(function(index){
		    if($(this).find("td:contains('"+search_term+"')" ).length){
		      $(this).find("td:contains('"+search_term+"')" ).addClass('search_hits');  	
		      return true;
		    }
	      }).show();    
	      
		  // 重新設定資料分頁
		  $('.record_view').val('all');
		  record_page_built( $('tr.data_record').length , $('tr.data_record').length , 1);
		}
	  }else{
		$('td.search_hits').removeClass('search_hits'); // 移除搜尋標記
		// 重新設定分頁顯示
		var display_row_num = display_data.row_num =='all' ? $('tr.data_record').length : display_data.row_num;
		record_table_display( display_row_num , $('tr.data_record').length , display_data.page_num ) ; 
	    record_page_built( display_row_num , $('tr.data_record').length , display_data.page_num);
		$('.record_view').val(display_data.row_num);    // 還原分頁設定 

		// 清空分頁設定變數
		display_data = {};
	  }
	  
	});
	
	
	
	//-- 依據當前頁面顯示資料
	function record_table_display( display_row_num , total_record_count , page_now ){
	  if(display_row_num!='all' && parseInt(display_row_num) ){
		for(var i=1 ; i <= total_record_count ; i++ ){  
		  if( parseInt((i-1)/display_row_num) === page_now-1 ){
			$('tr.data_record:nth-child('+i+')').css('display','table-row');  
		  }else{
			$('tr.data_record:nth-child('+i+')').css('display','none');   
		  }	
		}
		return parseInt(display_row_num);	
	  }else{
		$('tr.data_record').css('display','table-row');  
		return total_record_count;
	  }
	}
	
	//-- 依據每頁資料數量建置分頁
	function record_page_built( display_row_num , total_record_count , page_now){
	  $('.page_select').empty();
	  var total_page = parseInt( total_record_count/display_row_num ) + ((total_record_count%display_row_num) ? 1 : 0);
	  for(var p=1 ; p<=total_page ; p++ ){
		var page_class = (p==page_now) ? 'page_tap page_now' : 'page_tap page_to';
		$('<a>').addClass(page_class).attr('page',p).html(p).appendTo( ".page_select" );
      }	
	}
	
	
	
	$('.record_view').trigger('change');
	
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	
	
	
	/* [ Admin Staff Function Set ] */
	
	
	//-- datepicker initial
	$("#date_open,#date_access").datepicker({
	    dateFormat: 'yy-mm-dd',
	    onClose: function(dateText, inst) { 
	      if(/\d{4}-\d{2}-\d{2}$/.test(dateText)){
		    $(this).val(dateText+' 00:00:01');
		  }
	    } 
	});
	
	
	//-- admin staff get user data
	
	$(document).on('click','._staff_read',function(){
	  
      // initial	  
	  $('._target').removeClass('_target');
	  $('._variable').val('');
	  
	  // get value
	  var user_no    = $(this).attr('no');
	  var dom_record = $(this);
	  
	  // active ajax
	  if( ! user_no ){
	    system_message_alert('',"資料錯誤");
		return false;
	  }
	  
	  
	  if( user_no=='_addnew' ){  
	  
	    dom_record.addClass('_target');
		data_orl = {};
		$("._variable").each(function(){
		  
		  if( $(this).attr('id') == 'user_status'){
		    $(this).val('4');
		    data_orl[$(this).attr('id')] = '4';
			$(this).prop('disabled',true);
		  }else{
		    $(this).val('');
		    data_orl[$(this).attr('id')] = '';
		  }
		  
		  
		});
		$dom = dom_record.clone().removeClass('_staff_read');
	    $('#record_selecter').find('.record_control').hide();
		$('#record_selecter').find('.record_list').children('.data_result').hide();
		$('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
		$('#record_editor').find('a.view_switch').trigger('click');
		active_header_footprint_option('record_selecter','新增員工帳戶','_return_list');
	  
	  }else{
	    
		$.ajax({
          url: 'admain.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'act_staff_read',target:user_no},
		  beforeSend: 	function(){ system_loading();  },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
		    
			if(response.action){  
			  dom_record.addClass('_target');
			  data_orl = response.data;
			  $.each(response.data,function(field,meta){
				if(  $("._variable[id='"+field+"']").length ){
				  $("._variable[id='"+field+"']").val(meta);
				}
			  });
			  
			  $dom = dom_record.clone().removeClass('_staff_read');
			  $('#record_selecter').find('.record_control').hide();
			  $('#record_selecter').find('.record_list').children('.data_result').hide();
			  $('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
			  $('#record_editor').find('a.view_switch').trigger('click');
			  
			  active_header_footprint_option('record_selecter',response.data.user_name,'_return_list');
			  
		    }else{
			  system_message_alert('',response.info);
		    }
	      },
		  complete:		function(){   }
	    }).done(function() { system_loading();   });
	  
	  }
	
	});
	
	
	
	//-- save data modify
	$('#act_staff_save').click(function(){
	  
      // initial	  
	  var staff_no   =  $('._target').length? $('._target').attr('no') : '';
	  var modify_data = {};
	  var dom_record = $('._target');
	  var act_object = $(this);
	  
	  // get value
	  $('._variable').each(function(){
	    var field_name  = $(this).attr('id');
	    var field_value = $(this).val();
		if( data_orl[field_name] !== field_value){
		  modify_data[field_name]  =  field_value;
	    }
	  });
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64.encode(JSON.stringify(modify_data)));
	  
	  // check process data
	  if( !staff_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
	  // activa switch checked
	  if( act_object.prop('disabled') ){
	    return false;
	  }
	  
	  
      // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_staff_save',target:staff_no,data:passer_data},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			$.each(response.data,function(field,meta){ 
			  if( $("._variable[id='"+field+"']").length ){
				$("._variable[id='"+field+"']").val(meta).removeClass('_modify');
			  }
			  if( dom_record.children("td[field='"+field+"']").length ){
			    dom_record.children("td[field='"+field+"']").html(meta);
			  }
			});
			data_orl = response.data;
		    if( staff_no == '_addnew'){  dom_record.attr('no',response.data.uno) }
		  
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	});
	
	
	//-- create new staff data
	$('#act_staff_new').click(function(){
	    
	  // initial page
	  $('#editor_reform').trigger('click');
	  
	  // create new record
	  $tr = $("<tr/>").addClass('data_record _staff_read').attr('no','_addnew');
	  $tr.append(" <td field='user_idno'  > - </td>");
	  $tr.append(" <td field='user_id'  ></td>");
	  $tr.append(" <td field='user_name'  > </td>");
	  $tr.append(" <td field='user_staff'  ></td>");
	  $tr.append(" <td field='user_mail'  ></td>");
	  $tr.append(" <td field='user_tel'  ></td>");
	  $tr.append(" <td ></td>");
		
	  // inseart to record table	
	  if(!$("tr.data_record[no='_addnew']").length){
	    $tr.prependTo('tbody.data_result').trigger('click');
	  }	
	});
	
	
	
	//-- iterm function execute
	$('#act_func_execute').click(function(){
	  
	  var staff_no     =  $('._target').length? $('._target').attr('no') : '';
	  var execute_func =  $('#execute_function_selecter').length ? $('#execute_function_selecter').val() : '';
	  
	  // check process target
	  if( !staff_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
	  // check process action
	  if( !execute_func.length ){
	    system_message_alert('',"尚未選擇執行功能");
	    return false;
	  }  
	  
	  // confirm to admin
	  if(!confirm("確定要對資料執行 [ "+$("option[value='"+execute_func+"']").html()+" ] ?")){
	    return false;  
	  }
	  
	  
	   // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:execute_func,target:staff_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			switch(execute_func){
			  case 'act_staff_del' : act_staff_del_after(response.data);break;
			  case 'act_staff_mail_accept': alert("已成功寄出帳號開通信件 TO: "+response.data.user_id+" "); break;
			}
			
		  }else{
			system_message_alert('',response.info);
	      }
		  
	    },
		complete:	function(){  }
      }).done(function(r) {  system_loading(); });
	  
	});
	
	// 執行帳號刪除後的動作
	function act_staff_del_after(StaffNo){
	  $("tr._target[no='"+StaffNo+"']").remove();
	  $('#editor_reform').trigger('click');
	}
	
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
	
	
	/* [ Admin SellB2B Function Set ] */
	
	
	//-- create new customer data
	$('#act_customer_new_b2b').click(function(){
	    
	  // initial page
	  $('#editor_reform').trigger('click');
	  
	  // create new record
	  $tr = $("<tr/>").addClass('data_record _customer_read').attr('no','_addnew');
	  $tr.append(" <td field='system_cid'    > - </td>");
	  $tr.append(" <td field='company_name'  > 新增客戶 </td>");
	  $tr.append(" <td field='contact_person'> </td>");
	  $tr.append(" <td field='contact_phone' > </td>");
	  $tr.append(" <td field='user_name'     > </td>");
	  $tr.append(" <td field='sell_status'   > </td>");
	  $tr.append(" <td field='update_time'   > NOW </td>");
		
	  // inseart to record table	
	  if(!$("tr.data_record[no='_addnew']").length){
	    $tr.prependTo('tbody.data_result').trigger('click');
	  }	
	});
	
	//-- create new customer data
	$('#act_customer_new_b2c').click(function(){
	    
	  // initial page
	  $('#editor_reform').trigger('click');
	  
	  // create new record
	  $tr = $("<tr/>").addClass('data_record _customer_read').attr('no','_addnew');
	  $tr.append(" <td field='system_cid'    > - </td>");
	  $tr.append(" <td field='contact_person'  > 新增客戶 </td>");
	  $tr.append(" <td field='contact_phone'> </td>");
	  $tr.append(" <td field='contact_mail' > </td>");
	  $tr.append(" <td field='user_name'     > </td>");
	  $tr.append(" <td field='sell_status'   > </td>");
	  $tr.append(" <td field='update_time'   > NOW </td>");
		
	  // inseart to record table	
	  if(!$("tr.data_record[no='_addnew']").length){
	    $tr.prependTo('tbody.data_result').trigger('click');
	  }	
	});
	
	
	
	//-- admin sell get customer data & order list
	$(document).on('click','._customer_read',function(){
	  
      // initial	  
	  $('._target').removeClass('_target');
	  $('._variable').val('');
	  
	  // get value
	  var target_no    = $(this).attr('no');
	  var dom_record = $(this);
	  
	  // active ajax
	  if( ! target_no ){
	    system_message_alert('',"資料錯誤");
		return false;
	  }
	  
	  
	  if( target_no=='_addnew' ){  
	  
	    dom_record.addClass('_target');
		data_orl = {};
		$("._variable").each(function(){
		  $(this).val('');
		  data_orl[$(this).attr('id')] = '';
		});
		$dom = dom_record.clone().removeClass('_customer_read');
	    $('#record_selecter').find('.record_control').hide();
		$('#record_selecter').find('.record_list').children('.data_result').hide();
		$('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
		$('#record_editor').find('a.view_switch').trigger('click');
		active_header_footprint_option('record_selecter','新增客戶資料','_return_list');
	  
	  }else{
	    
		$.ajax({
          url: 'admain.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'act_customer_read',target:target_no},
		  beforeSend: 	function(){ system_loading();  },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
		    
			if(response.action){  
			  dom_record.addClass('_target');
			  
			  var customer_data = response.data.customer ? response.data.customer : {};
			  data_orl = customer_data;
			  var customer_orders= response.data.orders   ? response.data.orders : {};
			  
			  $.each(customer_data,function(field,meta){
				if(  $("._variable[id='"+field+"']").length ){
				  $("._variable[id='"+field+"']").val(meta);
				}
			  });
			  
			  // insert order data
			  if($('#order_list').length && response.data.orders){
				$.each(customer_orders,function( num , order ){
				  var $column = $("<tr/>").addClass('_order_read').attr('no',order.number);
				  $column.append("<td>??</td>");
				  $column.append("<td>"+order.number+"</td>");
				  $column.append("<td>"+order.date_start.substr(0,10)+' ~ '+order.date_end.substr(0,10)+"</td>");
				  $column.append("<td>"+order.order_type+"</td>");
				  $column.append("<td><span class='mark16 _order_status_"+order.order_status+"'></span></td>");
				  $column.appendTo("#order_list");
			    });
			  }
			  
			  $dom = dom_record.clone().removeClass('_customer_read');
			  $('#record_selecter').find('.record_control').hide();
			  $('#record_selecter').find('.record_list').children('.data_result').hide();
			  $('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
			  $('#record_editor').find('a.view_switch').trigger('click');
			  
			  
			  var target_term = customer_data.company_name && customer_data.company_name !='NULL' ? customer_data.company_name : customer_data.contact_person;
			  active_header_footprint_option('record_selecter',target_term,'_return_list');
			  
		    }else{
			  system_message_alert('',response.info);
		    }
	      },
		  complete:		function(){   }
	    }).done(function() { system_loading();   });
	  }
	});
	
	
	//-- save costomers data modify
	$('#act_customer_save').click(function(){
	  
      // initial	  
	  var target_no   =  $('._target').length? $('._target').attr('no') : '';
	  var modify_data = {};
	  var dom_record = $('._target');
	  var act_object = $(this);
	  var checked = true;
	  // get value
	  $('._variable').each(function(){
	    var field_name  = $(this).attr('id');
	    var field_value = $(this).val();
		if( data_orl[field_name] !== field_value){
		  modify_data[field_name]  =  field_value;
	    }
		
		if( $(this).parent().prev().hasClass('_necessary') && field_value==''  ){
		  system_message_alert('',"請填寫必要欄位 ( * 標示)");
		  checked = false;
		  return false;
		}
	  });
	  
	  if(!checked){
		return false;  
	  }
	  
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64.encode(JSON.stringify(modify_data)));
	  
	  // check process data
	  if( !target_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
	  // activa switch checked
	  if( act_object.prop('disabled') ){
	    return false;
	  }
	  
      // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_customer_save',target:target_no,refer:window.location.href,data:passer_data},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			$.each(response.data,function(field,meta){ 
			  if( $("._variable[id='"+field+"']").length ){
				$("._variable[id='"+field+"']").val(meta).removeClass('_modify');
			  }
			  if( dom_record.children("td[field='"+field+"']").length ){
			    dom_record.children("td[field='"+field+"']").html(meta);
			  }
			});
			data_orl = response.data;
			if( target_no == '_addnew'){  $('._target').attr('no',response.data.system_cid) }
		    
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	});
	
	
	// reset lv2 form data
	function reset_order_data(){
	  $("._variable2").each(function(){		
		if($(this).is(':checkbox') || $(this).is(':radio')){
		  $(this).prop('checked',false);
		}else{
		  $(this).val('');	
		}
		$(this).removeClass('_modify2')
	  }); 
	  $('._relative2').empty();
	  $('._reset').val('');
      data_orl2 = {};	  
	}
	
	
	//-- order data read And Open Order Data Div
	$(document).on('click','._order_read',function(){
	  
	  var customers = $('tr._target').attr('no');
	  var order_no  = $(this).attr('no');
	   
	  if( !order_no ){
		alert("訂單續號錯誤");  
		return false;  
	  }
	  reset_order_data();
	    
	    $.ajax({
          url: 'admain.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'act_order_read',target:order_no,refer:customers},
		  beforeSend: 	function(){ system_loading();  },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
		    
			if(response.action){  
			  
			  
			  var order_data = response.data.order ? response.data.order : {};
			  data_orl2 = order_data;
			  
			  $.each(order_data,function(field,meta){
				if(  $("._variable2[id='"+field+"']").length ){
				  if( $("._variable2[id='"+field+"']:checkbox").length){
					var selected = parseInt(meta) ? true : false ;
					$("._variable2[id='"+field+"']:checkbox").prop('checked',selected);
				  }else{
					$("._variable2[id='"+field+"']").val(meta);	  
				  }
				}else if($("._variable2[name='"+field+"']:radio").length ){
				  $("._variable2[name='"+field+"'][value='"+meta+"']").prop('checked',true);	
				}
			  });   
			  
			  
			  // insert order archive
			  if($('#order_archive').length && response.data.archives){
				$.each(response.data.archives,function( num , archive ){
				  var $column = $("<tr/>").addClass('relate_element').attr('no',archive.ano);
	              $column.append("<td><div class='element_status'><span class='mark16 pic_delete act_archive_delete act_option'></span></div></td>");
	              $column.append("<td>"+archive.archive_name+"</td>");
	              $column.append("<td><div class='_update limit_iprange' contenteditable='true'>"+archive.limit_iprange+"</div></td>");
	              $column.append("<td><div class='_update limit_online'  contenteditable='true'>"+archive.limit_online+"</div></td>");
				  $column.append("<td><div class='act_archive_account' title='管理登入帳號' ><a class='mark16 pic_db_account'></a></div></td>");
	              $column.appendTo("#order_archive");
			    });
			  }
			  
			  
			  // insert order contract
			  if($('#order_contract').length && response.data.contract){
				$.each(response.data.contract,function( num , contract ){
				  var $column = $("<tr/>").addClass('relate_element').attr('no',contract.acc_name);
				  $column.append("<td ><span class='act_option act_contract_del'><a class='mark16 pic_delete'></a></span></td>");
				  $column.append("<td class='act_contract_read'>"+contract.file_name+"</td>");
				  $column.append("<td><span title='"+contract.time_upload+"'>"+ contract.user_name+"</span> 上傳</td>");
				  $column.appendTo("#order_contract");
			    });
			  }
			  
			  
			  /*
			  dom_record.addClass('_target');
			  
			  var customer_data = response.data.customer ? response.data.customer : {};
			  data_orl = customer_data;
			  var customer_orders= response.data.orders   ? response.data.orders : {};
			  
			  $.each(customer_data,function(field,meta){
				if(  $("._variable[id='"+field+"']").length ){
				  $("._variable[id='"+field+"']").val(meta);
				}
			  });
			  
			  // insert order archive
			  if($('#order_list').length && response.data.orders){
				$.each(customer_orders,function( num , order ){
				  var $column = $("<tr/>").addClass('_order_read').attr('no',order.number);
				  $column.append("<td>"+order.number+"</td>");
				  $column.append("<td>"+order.date_start.substr(0,10)+' ~ '+order.date_end.substr(0,10)+"</td>");
				  $column.append("<td>"+order.order_type+"</td>");
				  $column.append("<td>"+order.order_status+"</td>");
				  $column.append("<td>??</td>");
				  $column.appendTo("#order_archive");
			    });
			  }
			  
			  $dom = dom_record.clone().removeClass('_customer_read');
			  $('#record_selecter').find('.record_control').hide();
			  $('#record_selecter').find('.record_list').children('.data_result').hide();
			  $('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
			  $('#record_editor').find('a.view_switch').trigger('click');
			  */	  
			  
			  
			  active_header_footprint_option('record_editor','合約:<i class="_target_order" no="'+order_no+'">'+order_no+"</a>",'_return_form');
			  $('.focus_block').show();
	  
		    }else{
			  system_message_alert('',response.info);
		    }
	      },
		  complete:		function(){   }
	    }).done(function() { system_loading();   });
	  
	});
	
	
	//-- new customers order data
    $('#act_order_new').click(function(){
		
      var customers   = $('tr._target').attr('no'); 		
	  if(customers == '_addnew'){
		system_message_alert('',"客戶資料尚未儲存，新增訂單前請先儲存客戶資料!!");
		return false;
	  }	
		
	  reset_order_data();
	  active_header_footprint_option('record_editor','合約:<i class="_target_order" no="_addnew">新增合約</a>','_return_form');
	  $('.focus_block').show();
	});	
	
	
	//-- save costomers order data modify
	$('#act_order_save').click(function(){
	  
      // initial	  
	  var customers   = $('tr._target').attr('no');
	  var order_no   =  $('._target_order').length? $('._target_order').attr('no') : '';
	  
	  var modify_data = {};
	  var act_object  = $(this);
	  
	  // get value
	  $('._variable2').each(function(){
		if( $(this).attr('name')=='order_status' ){
		  var field_name  = 'order_status';
		  var field_value = $('._variable2[name="order_status"]:checked').val();   
		}else if($(this).attr('id')=='paid'){
		  var field_name  = $(this).attr('id');
		  var field_value = $(this).prop('checked') ? "1":"0";
		}else{
		  var field_name  = $(this).attr('id');
	      var field_value = $(this).val();
		}
		if( data_orl2[field_name] !== field_value){
		  modify_data[field_name]  =  field_value;
	    }
	  });
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64.encode(JSON.stringify(modify_data)));
	  
	  // check process data
	  if( !order_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
      // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_save',target:order_no,refer:customers,data:passer_data},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			if(order_no != response.data){
			   $('._target_order').attr('no',response.data).html(response.data); 
			}
			$('._modify2').removeClass('_modify2');
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	});
	
	
	// 新增訂單資料庫
	$('#act_order_archive_add').change(function(){
		
	  var order_no   =  $('._target_order').length? $('._target_order').attr('no') : '';		
	  if(order_no == '_addnew'){
		$(this).val('');
		system_message_alert('',"訂單資料尚未儲存，新增標的前請先儲存訂單資料!!");
		return false;
	  }		
		
	  var archive_id = $(this).val();
	  var archive_name = $('.archive[value="'+archive_id+'"]').html();
	  
	  if(!$('tr.relate_element[no="'+archive_id+'"]').length){
	    var $column = $("<tr/>").addClass('relate_element').attr('no',archive_id);
	    $column.append("<td><div class='element_status'><span class='act_include_archive mark16 pic_save '></span></div></td>");
	    $column.append("<td>"+archive_name+"</td>");
	    $column.append("<td><div class='_update limit_iprange' contenteditable='true'>0.0.0.0</div></td>");
	    $column.append("<td><div class='_update limit_online'  contenteditable='true'>0</div></td>");
		$column.append("<td><div class='act_archive_account' title='管理登入帳號' ><a class='mark16 pic_db_account' style='display:none;'></a></div></td>");
	    $column.appendTo("#order_archive");
	  }else{
		system_message_alert('','資料庫已經存在');  
	  }
	  $(this).val('');
	  
	});
	
	// 儲存訂單標的資料 
	$(document).on('click','.act_include_archive',function(){
	  
	  var record = {};
	  
	  var order_no   =  $('._target_order').length? $('._target_order').attr('no') : '';
	  if(!order_no){
		system_message_alert('','尚未選擇訂單');    
	    return false;
	  }
	  
	  var archive    = $(this).parents('tr');
	  var archive_no = archive.attr('no');
	  if(!archive_no){
		system_message_alert('','尚未選擇資料庫');    
		return false;
	  }
	  
	  var limit_iprange   = archive.find('.limit_iprange').html();
	  if(!limit_iprange){
	    system_message_alert('','IP存取範圍未填寫'); 
        return false;		
	  }
	  
	  var limit_online   = archive.find('.limit_online').html();
	  if(!limit_online){
	    system_message_alert('','同時在線人數未填寫');  
        return false;		
	  }
	  
	  record['cid']  = $('tr._target').attr('no');
	  record['o_no'] = order_no;
	  record['a_no'] = archive_no;
	  record['limit_online']  = limit_online;
	  record['limit_iprange'] = limit_iprange;
	  
	  var passer_data = encodeURIComponent(Base64.encode(JSON.stringify(record)));
	  // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_archive_update',data:passer_data},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			archive.find('.element_status').html("<span class='mark16 pic_delete act_archive_delete act_option'></span>");  
			archive.find('.pic_db_account').show(); 
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });
	  
	});
	
	//-- 修改訂單標的內容
	$(document).on('keyup','._update',function(){
	  var archive    = $(this).parents('tr');
      archive.find('.element_status').html("<span class='act_include_archive mark16 pic_save '></span>");   	    
	});

	
	//-- 刪除訂單標的資料庫
	$(document).on('click','.act_archive_delete',function(){
	  var order_no   =  $('._target_order').length? $('._target_order').attr('no') : '';	
	  var ach_no   = $(this).parents('tr.relate_element').attr('no');
	  var ach_name = $(this).parents('td').next().html();
	  
	  
	  if(!order_no){ system_message_alert('error','尚未選擇合約資料'); return false; }	
	  if(!ach_no){ system_message_alert('error','尚未選擇標的') ; return false; }
	  if(!confirm('確定要刪除 "'+ach_name+'" 此標的?')){ return false; }
	  
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_archive_delete',target:order_no,refer:ach_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			$("tr.relate_element[no='"+ach_no+"']").empty().remove();
			system_message_alert('',ach_name+' : 標的已被刪除');
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });	
		
	});
	
	
	//-- 開啟資料庫帳號管理介面
	$(document).on('click','.act_archive_account',function(){
		
      var order_no   =  $('._target_order').length? $('._target_order').attr('no') : '';
	  var ach_no     =  $(this).parents('tr.relate_element').attr('no');
	  
	  if(!order_no){ system_message_alert('error','尚未選擇合約資料'); return false; }	
	  if(!ach_no){ system_message_alert('error','尚未選擇標的') ; return false; }
	  
	  $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_archive_accounts',target:order_no,refer:ach_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			
			$('#admin_archive_name').attr('no',response.data.archive.order).html(response.data.archive.name);
			
			$.each(response.data.account , function(k,user){
			  var $column = $("<tr/>").addClass('archive_account').attr('no',user.index);
	          $column.append("<td>"+user.account+"</td>");
	          $column.append("<td><span title='"+user.register_date+"'>"+user.register_date.substr(0,10)+"</span></td>");
	          $column.append("<td>"+user.count+"</td>");
	          $column.append("<td><span class='active_option act_account_active' pass='"+user.pass+"'><i class='active_switch'></i></span></td>");
		      $column.appendTo("#account_pool");		
			});
			
			$('.system_assist_area').show();	
			
			
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });
	    
	});
	
	
	//-- 關閉資料庫帳號管理介面
	$('#act_close_area').click(function(){
	  $(this).parents('.system_assist_area').hide();  
	  // 清空區塊資料 
      $('#admin_archive_name').html('').attr('no','');
	  $('#account_pool').empty();
	});
	
	
	//-- 開關資料庫帳號
	$(document).on('click','.act_account_active',function(){
	  
	  var option = $(this);
	  var act_string  = $(this).parents('tr.archive_account').attr('no');
	  var act_newpass = parseInt($(this).attr('pass')) ? 0 : 1 ;
	  
	  $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_archive_account_active',target:act_string,refer:act_newpass},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			option.attr('pass',response.data);
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });
	  
	});
	
	//-- 開啟新增資料庫帳號介面	
	$('#act_order_archive_account_add').click(function(){
	  var dt = new Date(); 	
	  if($('#account_pool').length){
		var $column = $("<tr/>").addClass('archive_account').attr('no','_addnew');
	    $column.append("<td><div class='new_account_input' contenteditable='true'></div></td>");
	    $column.append("<td>"+dt.getFullYear()+"-"+(dt.getMonth()+1)+"-"+dt.getDate()+"</td>");
	    $column.append("<td>0</td>");
	    $column.append("<td><i class='mark16 pic_save act_account_save'></i></td>");
		$column.appendTo("#account_pool");
	  }
	});
	
	
	//-- 儲存資料庫帳號	
	$(document).on('click','.act_account_save',function(){
	  
	  var order_archive_id   =   $('#admin_archive_name').attr('no');	
	  var new_account        =   $(this).parents('tr.archive_account').find('.new_account_input').html();
	  var account_dom        =   $(this).parents('tr.archive_account');
	  
	  if(!order_archive_id){ system_message_alert('error','尚未選擇合約資料'); return false; }	
	  if(!new_account){ system_message_alert('error','尚未填寫帳號') ; return false; }
	  
	  $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_order_archive_account_save',target:new_account,refer:order_archive_id},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			account_dom.attr('no',response.data);
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });
	  
	});
	
	
	
	
	
  
  });  //-- end of initial --//
  
  
  /* [ System Trival Function Set ] */
  
  //-- 加入回家選項
  function active_header_footprint_option(domid,target_name,return_to){  
	  if($('#'+domid).length){
		var $target = $('#'+domid).find('.record_header').children('.record_name');
		if( !target_name || $target.hasClass("_return_list") || $target.hasClass("_return_form")){  
		  // 移除 header return 選項
		   $target.removeClass(return_to).next(".record_target").remove();
		}else{
		  // 加入 header return 選項
		  $DOM = $("<span/>").addClass('record_target').html(target_name);
          $target.addClass(return_to).after($DOM);
		}
	  }
  }
  
  
  
  

   /* [ System Work Function Set ] */
	
  //-- message alert 
  function system_message_alert(mtype,messg){
    
	mtype = mtype ? mtype : 'error';
	
	$('.system_message_area').finish();
	
	if($('#message_container').length){
	  if(messg){
	    $('#message_container').children('.msg_title').html(messg);
	    $('#message_container').children('.msg_info').html('');
	  }
	}
	
    $('.system_message_area').addClass(mtype).finish().show().delay(2000).animate({opacity:'0'},2000,function(){ 
	  $(this).hide().css('opacity','0.8').removeClass(mtype);
	  $('#message_container').children('.msg_title').html('');
	  $('#message_container').children('.msg_info').html('');
	});
	
  }
  
  
  //-- System loading   # All Page Mask Loading
  function system_loading(){
    var display='show';
	clearTimeout($.data(this, 'timer'));
	if($('.system_loading_area').is(':visible')){
	  sysloading.hide();
	  $('.loading_info').css('opacity','0');
	  display = 'none';
	}else{
	  sysloading.show();
	  display = 'block';
	  $.data(this, 'timer', setTimeout(function() {
        $('.loading_info').animate({opacity:'1'},1000);
      }, 8000));
	}	
	$('.system_loading_area').css('display',display);
  }
  
  
  //-- action loading # Action botton Loading 
  function active_loading( domObject , status){
	if( ! domObject.prev().hasClass('_actprocess') ){
	   var processing = domObject.attr('id')+'_activating';
	   $DOM = $("<span/>").addClass('_actprocess').attr('id',processing).css('padding','0 10px');
	   domObject.before($DOM);
	}else{
	  var processing = domObject.prev().attr('id');
	}	
	switch(status){
	  case false   : domObject.prop('disabled',false);  $('#'+processing).html("<img src='theme/image/act_mark_fail.png' />").finish().animate({'opacity':0},4000,function(){  $('._actprocess').remove(); }); break;
	  case true    : domObject.prop('disabled',false);  $('#'+processing).html("<img src='theme/image/act_mark_done.png' />").finish().animate({'opacity':0},4000,function(){  $('._actprocess').remove(); }); break;
	  case 'initial': $('#'+processing).html("<img src='theme/image/act_mark_process.gif' />"); domObject.prop('disabled','true'); break; 
	}
  }
  
  
  //顯示倒數秒收
  function showTime()
  {  
	waitTime -= 1;
    document.getElementById('wait_time').innerHTML= waitTime;
    
    if(waitTime==0)
    {
      location.href='index.php';
    }
    //每秒執行一次,showTime()
    setTimeout("showTime()",1000);
  }
  
  
  
  
  
  
  
  
  
  
  
  


