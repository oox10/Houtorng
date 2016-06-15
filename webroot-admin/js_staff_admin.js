/* [ Admin Staff Function Set ] */
	
  
  $(window).load(function () {   //  || $(document).ready(function() {		
	
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
	$(document).on('click','._data_read',function(){
	  
      // initial	  
	  $('._target').removeClass('_target');
	  
	  // get value
	  var user_no    = $(this).attr('no');
	  var dom_record = $(this);
	  
	  // active ajax
	  if( ! user_no ){
	    system_message_alert('',"資料錯誤");
		return false;
	  }
	  
	  initial_record_editer();
	  
	  if( user_no=='_addnew' ){
	    dom_record.addClass('_target');
		data_orl = {};
		
		$('#user_id').prop('readonly',false);
		$('#main_group').html('同管理者');
		$('#user_status').prop('disabled',true).val(2)
		
		$dom = dom_record.clone().removeClass('_data_read');
	    $('#record_selecter').find('.record_control').hide();
		$('#record_selecter').find('.record_list').children('.data_result').hide();
		$('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
		$('#record_editor').find('a.view_switch').trigger('click');
		active_header_footprint_option('record_selecter','新增帳戶','_return_list');
	  
	  }else{
	    
		$.ajax({
          url: 'index.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'Staff/read/'+user_no},
		  beforeSend: 	function(){ system_loading();  },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
		    if(response.action){  
			  dom_record.addClass('_target');
			  
			  var dataObj =  response.data.user;
			  data_orl = dataObj;
			  
			  // change _data_read area
			  $dom = dom_record.clone().removeClass('_data_read');
			  $('#record_selecter').find('.record_control').hide();
			  $('#record_selecter').find('.record_list').children('.data_result').hide();
			  $('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
			  $('#record_editor').find('a.view_switch').trigger('click');
			  
			  // insert data
			  insert_staff_data_to_form(dataObj);
			  
			  // set foot print 
			  active_header_footprint_option('record_selecter',dataObj.user_name,'_return_list');
			  
			  // hash the address
			  location.hash = dataObj.user_id
			  
			  
		    }else{
			  system_message_alert('',response.info);
		    }
	      },
		  complete:		function(){   }
	    }).done(function() { system_loading();   });
	  }
	
	});
	
	
    //-- link to account logs
	$('#act_staff_logs').click(function(){
	  
      // initial	  
	  var staff_id    =  $('#user_id').val().length? $('#user_id').val() : '';
	  
      // check process data
	  if( !staff_id.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  } 
	  window.open('index.php?act=Record/account/'+staff_id,'_blank');
	});
    
    
	//-- save data modify
	$('#act_staff_save').click(function(){
	  
      // initial	  
	  var staff_no    =  $('._target').length? $('._target').attr('no') : '';
	  var modify_data = {};
	  var roles_data  = {};
	  
	  var act_object  = $(this);
	  var checked = true;
	  
	  // option active checked  // 檢查按鈕是否在可執行狀態
	  if( act_object.prop('disabled') ){
	    return false;
	  }
	  
	  // check process data
	  if( !staff_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  } 
	  
	  // get value
	  $('._update').each(function(){
	    if($(this)[0].tagName=='INPUT' && $(this).attr('type')=='checkbox'){
		  var field_name = $(this).attr('name');
		  roles_data[$(this).val()] = $(this).prop('checked') ? 1 : 0;
		}else{
		  var field_name  = $(this).attr('id');
	      var field_value = $(this).val();
		  if( data_orl[field_name] !== field_value){
		    modify_data[field_name]  =  field_value;
	      }
		  
		  if( $(this).parent().prev().hasClass('_necessary') && field_value==''  ){  
			$(this).focus();
			system_message_alert('',"請填寫必要欄位 ( * 標示)");
		    checked = false;
		    return false;
		  }
		}
	  });
	  
	  if(!checked){
		return false;  
	  }
	  
	  // encode data
	  var passer_data  = encodeURIComponent(Base64.encode(JSON.stringify(modify_data)));
	  var passer_roles = encodeURIComponent(Base64.encode(JSON.stringify(roles_data)));
      // active ajax
      $.ajax({
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Staff/save/'+staff_no+'/'+passer_data+'/'+passer_roles},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  
		  if(response.action){
			
			var dataObj = response.data.user;
			data_orl = dataObj;
			
			// insert data
			insert_staff_data_to_form(dataObj);
			
			// update data no 
			if( staff_no == '_addnew'){  $('._target').attr('no',dataObj.uno) }
		  
		  }else{
			system_message_alert('',response.info);
	      }
		  
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	});
	
	
	//-- get staff data to editer  // 從server取得使用者資料並放入編輯區
	function insert_staff_data_to_form(dataObj){
	  var dom_record  = $('._target'); 
	  
	  $.each(dataObj,function(field,meta){
		if(field=='roles' && meta){
		  //  'R01':1 'R02':0 ...	
		  $.each(meta,function(rid,checked){
			$("input:checkbox[name='roles'][value='"+rid+"']").prop('checked',checked);    
		    $(".role_map[data-role='"+rid+"']").attr('on',checked);
		  });
		}else if(field=='groups'){
			$("span[name='groups']").html('');	  
			$.each(meta,function(i,g){
			  if(g.master){
				$("span#main_group").html("<i title='"+g.ug_info+"'>"+g.ug_name+"</i>");  
			  }else{
				$("span#rela_group").append("<i title='"+g.ug_info+"'>"+g.ug_name+"</i>");	  
			  }
			});  
		}else{
			if(  $("._variable[id='"+field+"']").length ){  
			  $("._variable[id='"+field+"']").val(meta);  
			}
		}
		
		// update target record 
		var record_field = dom_record.children("td[field='"+field+"']");
		if( record_field.length && record_field.html() != meta  ){
		  record_field.html(meta);
	    }
	  });
	  
	  $('._modify').removeClass('_modify');
	}
	
	//-- change role map display
    $("input[name='roles']").change(function(){	
	  $(".role_map[data-role='"+$(this).val()+"']").attr('on',$(this).prop('checked')*1);
	});
    
	//-- create new staff data
	$('#act_staff_new').click(function(){
	    
	  // initial page
	  $('#editor_reform').trigger('click');
	  
	  // create new record
	  $tr = $("<tr/>").addClass('data_record _data_read').attr('no','_addnew');
	  $tr.append(" <td field='uno'  > - </td>");
	  $tr.append(" <td field='user_group'  ></td>");
	  $tr.append(" <td field='user_id'  > </td>");
	  $tr.append(" <td field='user_organ'  ></td>");
	  $tr.append(" <td field='user_name'  ></td>");
	  $tr.append(" <td field='user_tel'  ></td>");
	  $tr.append(" <td ><i class='mark24 pic_account_status1'></i></td>");
	  
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

      // check process action
	  if( staff_no=='_addnew' ){
	    system_message_alert('',"資料尚在編輯中，請先儲存資料");
		return false;
	  }	    
	  
	  // confirm to admin
	  if(!confirm("確定要對資料執行 [ "+$("option[value='"+execute_func+"']").html()+" ] ?")){
	    return false;  
	  }
	  
	  
	   // active ajax
      $.ajax({
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Staff/'+execute_func+'/'+staff_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  
		  if(response.action){
			switch(execute_func){
			  case 'dele' : act_staff_del_after(response.data);break;
			  case 'startmail': alert("已成功寄出帳號開通信件 TO: "+response.data+" "); break;
			}
		  }else{
			system_message_alert('',response.info);
	      }
		  
	    },
		complete:	function(){  }
      }).done(function(r) {  system_loading(); });
	  $('#execute_function_selecter').val('');
	});
	
	// 執行帳號刪除後的動作
	function act_staff_del_after(StaffNo){
      $("tr._target[no='"+StaffNo+"']").remove();
	  $('#editor_reform').trigger('click');
	  $('.record_view').trigger('change');
	}
	
	
	
	/**-- [ group member setting Setting ] --**/

    //-- Open group member Setting area
    $('#act_set_gmember').click(function(){
	  
	  // Update DB
	  $.ajax({
		url: 'index.php',
		type:'POST',
		dataType:'json',
		data: {act:'Staff/gmember'},
		beforeSend: function(){  system_loading(); },
		error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
		success: 	function(response) {
		  if(response.action){
			var obj = response.data.members;
			$.each(obj,function(key,mem){
			  var $DOM = $("<tr/>").addClass('gmember').attr('no',mem['user_id']);
              $DOM.append("<td>"+mem['user_id']+"</td>");  
			  $DOM.append("<td>"+mem['user_organ']+"</td>");
			  $DOM.append("<td>"+mem['user_name']+"</td>");
			  $DOM.append("<td>"+mem['roles'].join(',')+"</td>");
			  if(mem['master']){
				$DOM.append("<td>-</td>");  
			  }else{
				$DOM.append("<td><button type='button' class='act_leave_group cancel'><i class='mark16 pic_group_leave'></i></button></td>");  
			  }
			  $DOM.appendTo('#member_list');
			});
			
		  }else{
			system_message_alert('',response.info);
		  }
		},
		complete:	function(){  }
	  }).done(function(r) {   system_loading();   });
	  
	  $('.group_setting_area').show();
	});
	
	// group leave function
	$(document).on('click','.act_leave_group',function(){
	  var user   = $(this).parents('tr.gmember').attr('no');
      var record = $(this).parents('tr.gmember');
	  
      $.ajax({
		url: 'index.php',
		type:'POST',
		dataType:'json',
		data: {act:'Staff/gpdef/'+user},
		beforeSend: function(){  system_loading(); },
		error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
		success: 	function(response) {
		  if(response.action){
			record.remove();
			system_message_alert('alert',"使用者已移出群組");
		  }else{
			system_message_alert('',response.info);
		  }
		},
		complete:	function(){  }
	  }).done(function(r) {   system_loading();   });
	  
	  // remove 
		
	});
	
	// group add function
	$('#act_addto_group').click(function(){
	  
	  var user = $('#add_member').val()
	  var role = {};
	  $("input[name='add_role']").each(function(){
		role[$(this).val()] = $(this).prop('checked') ? 1 : 0;   
	  });
	  
	  // check user
	  if( !user ){
	    system_message_alert('',"尚未選擇成員");
		return false;
	  }	
	  
	  // check role
	  if( !$("input[name='add_role']:checked").length ){
	    system_message_alert('',"尚未設定角色");
		return false;
	  }	
	  
	  
	  var passer_data  = encodeURIComponent(Base64.encode(JSON.stringify(role)));
	  
	  $.ajax({
		url: 'index.php',
		type:'POST',
		dataType:'json',
		data: {act:'Staff/gpadd/'+user+'/'+passer_data},
		beforeSend: function(){  system_loading(); },
		error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
		success: 	function(response) {
		  if(response.action){
			var mem = response.data;  
			if($("tr.gmember[no='"+mem['user_id']+"']").length){
			  $("tr.gmember[no='"+mem['user_id']+"']").children('td:nth-child(4)').html(mem['roles'].join(','));
			}else{
			  var $DOM = $("<tr/>").attr('no',mem['user_id']);
		      $DOM.append("<td>"+mem['user_id']+"</td>");  
		      $DOM.append("<td>"+mem['user_organ']+"</td>");
		      $DOM.append("<td>"+mem['user_name']+"</td>");
		      $DOM.append("<td>"+mem['roles'].join(',')+"</td>");
		      if(mem['master']){
			    $DOM.append("<td> - </td>");  
		      }else{
			    $DOM.append("<td><button type='button' class='act_leave_group cancel'><i class='mark16 pic_group_leave'></i></button></td>");  
		      }
		      $DOM.appendTo('#member_list');	
			}
			system_message_alert('alert',"帳號加入成功");
		  }else{
			system_message_alert('',response.info);
		  }
		},
		complete:	function(){
		  $('#add_member').val('');
		  $("input[name='add_role']").prop('checked',false);
		}
	  }).done(function(r) {   system_loading();   });
	  
	  
	});
	
	
	//-- Close Project Setting & cancal now
    $('#close_setter').click(function(){
	  $('._setinit').empty().val('');
	  $("input[name='add_role']").prop('checked',false);	  
      $('.group_setting_area').hide();   
    });
	
	
	// initial account data  //帶有參數的網址連結資料
    if(document.location.hash.match(/^#.+/)){
	    $target = $("td[field='user_id']:contains("+location.hash.replace(/^#/,'')+")").parents('tr._data_read ');
        if($target.length){ 
		
		  if( !$target.hasClass( '_target' )){
			$target.trigger('click');		
	      }
	    }else{
		  system_message_alert('','查無資料');
	    }
	}
	
	
	
  });	
  
  
  