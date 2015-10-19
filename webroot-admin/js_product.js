/*    
  
  javascrip use jquery 
  rcdh 10 javascript pattenr rules v1
  
*/
 
  /***************************************************   
	    Houtorng Admin System # products admin action     
  ***************************************************/
	
  $(window).load(function () {   //  || $(document).ready(function() {	
	
	/* [ Admin Producted Function Set ] */
	
	data_orl = {};
	
	//-- add drag sort function
	$('tbody.data_result').sortable({
	  placeholder: "ui-state-highlight",
	  update: function( event, ui ) {
		  
        var element_order = $( ".data_record" ).map(function(){ return $(this).attr('no'); }).get().join(','); 
		console.log(element_order);
		  
		$.ajax({
            url: 'admain.php',
	        type:'POST',
	        dataType:'json',
	        data: {act:'act_product_sort',target:element_order},
		    beforeSend: function(){  system_loading(); },
            error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	        success: 	function(response) {
		      if(response.action){
			    system_message_alert('alert', '已重新排序');
		      }else{
			    system_message_alert('error',response.info);
	          }
	        },
		    complete:	function(){  }
          }).done(function(r) { system_loading();  });
	  }
		
	});
	
	

	
	//-- admin task get user data
	$(document).on('click','._data_read',function(){
	  
      // initial	  
	  $('._target').removeClass('_target');
	  $('._variable').val('');
	  
	  // get value
	  var data_no    = $(this).attr('no');
	  var dom_record = $(this);
	  
	  // active ajax
	  if( ! data_no ){
	    system_message_alert('',"資料錯誤");
		return false;
	  }
	  
	  location.hash = data_no;
	  
	  
	  if( data_no=='_addnew' ){  
	  
	    dom_record.addClass('_target');
		data_orl = {};
		$("._variable").each(function(){
		  $(this).val('');
		  data_orl[$(this).attr('id')] = '';
		});
		$dom = dom_record.clone().removeClass('_data_read');
	    $('#record_selecter').find('.record_control').hide();
		$('#record_selecter').find('.record_list').children('.data_result').hide();
		$('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
		$('#record_editor').find('a.view_switch').trigger('click');
		
		active_header_footprint_option('record_selecter','新增產品','_return_list');
		reload_order_contract_list(0)
		$('#_view,#view_index').attr('pass',0);
		
		
	  }else{
	    
		$.ajax({
          url: 'admain.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'act_product_read',target:data_no},
		  beforeSend: 	function(){ system_loading();  },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
		    
			if(response.action){  
			  dom_record.addClass('_target');
			  data_orl = response.data;
			  
			  $.each(response.data,function(table,meta){
				$.each(meta,function(field,meta){
				  if(  $('#'+table).find("._variable[id='"+field+"']").length ){
				     $('#'+table).find("._variable[id='"+field+"']").val(meta);
				  }
			    });
			  });
			  
			  $('#_view').attr('pass',response.data.products._view);
			  $('#view_index').attr('pass',response.data.products.view_index);
			  
			  $dom = dom_record.clone().removeClass('_data_read');
			  $('#record_selecter').find('.record_control').hide();
			  $('#record_selecter').find('.record_list').children('.data_result').hide();
			  $('#record_selecter').find('.record_list').children('.data_target').empty().append( $dom).show();
			  $('#record_editor').find('a.view_switch').trigger('click');
			  
			  active_header_footprint_option('record_selecter',response.data.meta_cht.title_product,'_return_list');
			  reload_order_contract_list(data_no);
			  
		    }else{
			  system_message_alert('',response.info);
		    }
	      },
		  complete:		function(){   }
	    }).done(function() { system_loading();   });
	  }
	
	});
	
	
	
	//-- admin product create new
	$('#act_product_new').click(function(){
	    
	  // initial page
	  //$('#editor_reform').trigger('click');
	  
	  // create new record
	  $tr = $("<tr/>").addClass('data_record _data_read').attr('no','_addnew');
	  $tr.append(" <td field='rno'  >NEW</td>");
	  $tr.append(" <td field='title_type'  > </td>");
	  $tr.append(" <td field='title_product'  ></td>");
	  $tr.append(" <td field='editer'  ></td>");
	  $tr.append(" <td field='time_edited'  ></td>");
	  $tr.append(" <td ></td>");
	 
	  // inseart to record table	
	  if(!$("tr.data_record[no='_addnew']").length){
	    $tr.prependTo('tbody.data_result').trigger('click');
	  }
	  
	  $('#_view').attr('pass',0);
	  $('#view_index').attr('pass',0);
	  
	  $('li.langsel:nth-child(1)').trigger('click');
	  
	});
	
	
	//-- save data modify
	$('#act_product_save').click(function(){
	  
      // initial	  
	  var data_no   =  $('._target').length? $('._target').attr('no') : '';
	  var modify_data = {};
	  var dom_record = $('._target');
	  var act_object = $(this);
	  
	  // get value
	  $('._variable').each(function(){
	    
		var table_name  = $(this).parents('.form_element').attr('id')
		var field_name  = $(this).attr('id');
	    var field_value = $(this).val();
		
		if(modify_data[table_name] == undefined){
	      modify_data[table_name] = {}; 
		}
		
		if( $(this).parent().prev().hasClass('_necessary') && field_value==''  ){
		  system_message_alert('',"請填寫必要欄位 ( * 標示)");
		  checked = false;
		  return false;
		}
		
		if(data_no == '_addnew'){
		  modify_data[table_name][field_name]  =  field_value;	
		}else{
		  if( data_orl[table_name][field_name] !== field_value){
		    modify_data[table_name][field_name]  =  field_value;
	      }
		}
		
		
	  });
	  modify_data['products']['_view']  =  $('#_view').attr('pass');
	  modify_data['products']['view_index']  =  $('#view_index').attr('pass');
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64.encode(JSON.stringify(modify_data)));
	  
	  // check process data
	  if( !data_no.length ){
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
	    data: {act:'act_product_save',target:data_no,data:passer_data},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			
			$.each(response.data,function(table,meta){
			  $.each(meta,function(field,mvalue){ 
			    if( $('#'+table).find("._variable[id='"+field+"']").length ){
				  $('#'+table).find("._variable[id='"+field+"']").val(mvalue).removeClass('_modify');
			    }
				if(table=='meta_cht'){
				  if( dom_record.children("td[field='"+field+"']").length ){
			        dom_record.children("td[field='"+field+"']").html(mvalue);
			      }	
				}
			  });
			});
			$('#_view').attr('pass',response.data.products._view);
			$('#view_index').attr('pass',response.data.products.view_index);
			
			data_orl = response.data;
		    if( data_no == '_addnew'){  
			  dom_record.attr('no',response.data.products.pid);
			  dom_record.children("td[field='rno']").html(response.data.products.pid);
			}
		    
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	  
	});
	
	
	//-- 開關資料
	$(document).on('click','#_view,#view_index',function(){
	  if(parseInt($(this).attr('pass'))){
		$(this).attr('pass',0);
	  }else{
		$(this).attr('pass',1); 
	  }
	});
	
	//-- meta language switch
	
	if($('.langsel').length){
	  $('.langsel').click(function(){
		$('.meta_lang').hide();
		$('#'+$(this).attr('lang')).show()
		$('.current').removeClass('current');
        $(this).addClass('current');		
	  });
	}
	
	
	//-- 開啟上傳訂單介面
	$('#act_open_upload').click(function(){
		
	  var data_no   =  $('._target').length? $('._target').attr('no') : '';
	  if(data_no == '_addnew'){
		system_message_alert('',"產品尚未儲存，請先儲存資料!!");
		return false;
	  }	
		
	  if(!data_no){
		system_message_alert('error','尚未選擇合約資料');
	    return false;
	  }	
	  
      $('#upload_record_no').html(data_no);
      $('#record_num').val(data_no);
	  
	  if($('.system_upload_area').length){
		$('.system_upload_area').show();  
	  }
	});
	
	
	//-- 關閉上船訂單介面
	$('#act_close_upload').click(function(){
	    var order_no   =  $('._target').length? $('._target').attr('no') : '';		
        if($('.system_upload_area').length){
		  $('.system_upload_area').hide();
          $('#upload_order_no').html('');		
		  $('#order_num').val('');
		  reload_order_contract_list(order_no);
	    }	  
	});
	
    //-- 重新讀取產品附件列表
	function reload_order_contract_list(target_no){
	  // active ajax
      $.ajax({
        url: 'admain.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'act_get_pjobj',target:target_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			$('#product_display_object').empty();
			$.each(response.data,function( num , contract ){
			  var $column = $("<li/>").addClass('relate_element').attr('no',contract.att_no);
			  $column.append("<div class='redisplay' ><img src='"+contract.acc_name+"'/></td>");
			  $column.append("<div class='reoption'  ><span class='act_option act_reobj_del'><a class='mark16 pic_delete'></a></span><span class='info_size'>"+(contract.file_size/1000)+'KB'+"</span></div>");
			  $column.appendTo("#product_display_object");
			});
			
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) { system_loading();  });
	}
	
	
	
	
	  
	//-- 刪除產品顯示物件
	$(document).on('click','.act_reobj_del',function(){
	    var att_no   = $(this).parents('li.relate_element').attr('no');
	    $(this).parents('li.relate_element').addClass('delete_flag');
	    
		if(!att_no){ system_message_alert('error','尚未選擇附件') ;  return false; }
	  
	    if(!confirm('確定要刪除此附件?')){
		  $(this).parents('div.relate_element').removeClass('delete_flag');	
		  return false;  
	    }
	  
        $.ajax({
          url: 'admain.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'act_reobj_del',target:att_no},
		  beforeSend: function(){  system_loading(); },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 	function(response) {
		    if(response.action){
			  $("li.relate_element[no='"+att_no+"']").empty().remove();
			  system_message_alert('alert', '附件已被刪除');
		    }else{
			  system_message_alert('',response.info);
	        }
	      },
		  complete:	function(){  }
        }).done(function(r) { system_loading();  });
	});  
	 
	 //-- 讀取訂單附件檔案
	  $(document).on('click','.act_contract_read',function(){
	    var ach_no   = $(this).parents('tr.relate_element').attr('no');
        if(!ach_no){ system_message_alert('error','尚未選擇附件') ; return false; }
	    var win = window.open('admain.php?act=adSellDoc&doc='+ach_no, '_blank');
	  });
	
	  // 可排序
      $( "#product_display_object" ).sortable({
	    update: function( event, ui ) {
		  var data_no   =  $('._target').length? $('._target').attr('no') : '';
		  var element_order = $( "#product_display_object" ).find('li').map(function(){ return $(this).attr('no'); }).get().join(','); 
		  
		  $.ajax({
            url: 'admain.php',
	        type:'POST',
	        dataType:'json',
	        data: {act:'act_reobj_sort',target:data_no,refer:element_order},
		    beforeSend: function(){  system_loading(); },
            error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	        success: 	function(response) {
		      if(response.action){
			    system_message_alert('alert', '已重新排序');
		      }else{
			    system_message_alert('error',response.info);
	          }
	        },
		    complete:	function(){  }
          }).done(function(r) { system_loading();  });
		}
	  });
      $( "#sortable" ).disableSelection();
  
	
	
	
	  
	
	/*
	//-- 執行訂單功能
	$('#order_func_execute').click(function(){
      
	  var order_no      =  $('._target_order').length? $('._target_order').attr('no') : '';		
      var function_name = $('#order_function_selecter').val();
	  
	  
	  if(!order_no){ system_message_alert('error','尚未選擇合約'); return false; }
	  if(order_no == '_addnew'){
		system_message_alert('',"訂單資料尚未儲存");
		return false;
	  }	
	  if(!function_name){ system_message_alert('error','尚未選擇合約功能'); return false;}
	  
	  switch(function_name){
		case 'act_order_del':
		  if(!confirm('確定要刪除 "'+order_no+'" 此合約資料?')){ return false; }
		  if(!confirm('請再次確認要刪除 "'+order_no+'" 此合約資料?')){ return false; }

		  $.ajax({
            url: 'admain.php',
	        type:'POST',
	        dataType:'json',
	        data: {act:'act_order_del',target:order_no},
		    beforeSend: function(){  system_loading(); },
            error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	        success: 	function(response) {
		      if(response.action){
			    system_message_alert('',order_no+' : 合約已被刪除');
				$('#editor_backto').trigger('click');   // step 01. return to customers data
				$('tr._order_read[no="'+response.data+'"]').empty().remove();   // step 02. delete order list
			  }else{
			    system_message_alert('',response.info);
	          }
	        },
		    complete:	function(){  }
          }).done(function(r) { system_loading();  });
		  break;  
	  }
	  
	});
	*/
	
	  
	
	
	
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
  
  });  //-- end of initial --//
  
  
  
  
  
  
  
  
  
  
  
  
  


