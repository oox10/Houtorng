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
		$.ajax({
            url: 'index.php',
	        type:'POST',
	        dataType:'json',
	        data: {act:'Products/psort/'+element_order},
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
          url: 'index.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'Products/read/'+data_no},
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
	  modify_data['products']['_view']  	 =  $('#_view').attr('pass');
	  modify_data['products']['view_index']  =  $('#view_index').attr('pass');
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64M.encode(JSON.stringify(modify_data)));
	  
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
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Products/save/'+data_no+'/'+passer_data},
		beforeSend: function(){  active_loading(act_object,'initial'); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  
		  if(response.action){
			
			$.each(response.data[1],function(table,meta){
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
			$('#_view').attr('pass',response.data[1].products._view);
			$('#view_index').attr('pass',response.data[1].products.view_index);
			
			data_orl = response.data[1];
		    if( data_no == '_addnew'){  
			  dom_record.attr('no',response.data[1].products.pid);
			  dom_record.children("td[field='rno']").html(response.data[1].products.pid);
			}
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  active_loading(act_object , r.action );  });
	  
	});
	
	
	
	//-- iterm function execute
	$('#act_func_execute').click(function(){
	  
	  var data_no     =  $('._target').length? $('._target').attr('no') : '';
	  var execute_func =  $('#execute_function_selecter').length ? $('#execute_function_selecter').val() : '';
	  
	  // check process target
	  if( !data_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
	  // check process action
	  if( !execute_func.length ){
	    system_message_alert('',"尚未選擇執行功能");
	    return false;
	  } 

      // check process action
	  if( data_no=='_addnew' ){
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
	    data: {act:'Products/'+execute_func+'/'+data_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  
		  if(response.action){
			switch(execute_func){
			  case 'pdel' : act_product_del_after(data_no);break;
			}
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  system_loading(); });
	  $('#execute_function_selecter').val('');
	});
	
	// 執行刪除後的動作
	function act_product_del_after(ProductNo){
      $("tr._target[no='"+ProductNo+"']").remove();
	  $('#editor_reform').trigger('click');
	  $('.record_view').trigger('change');
	}
	
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
	
	
    //-- 重新讀取產品附件列表
	function reload_order_contract_list(target_no){
	  // active ajax
      $.ajax({
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Products/pjobj/'+target_no},
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
	
	
    // 可排序
    $( "#product_display_object" ).sortable({
	  update: function( event, ui ) {
	    var data_no   =  $('._target').length? $('._target').attr('no') : '';
	    var element_order = $( "#product_display_object" ).find('li').map(function(){ return $(this).attr('no'); }).get().join(','); 
	  
	    $.ajax({
		  url: 'index.php',
		  type:'POST',
		  dataType:'json',
		  data: {act:'Products/objsort/'+data_no+'/'+element_order},
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
  
	
	
	//-- delete item attachment
	$(document).on('click','.act_reobj_del',function(){
	  var data_no     =  $(this).parents('.relate_element').length? $(this).parents('.relate_element').attr('no') : '';
	  var target_dom  =  $(this).parents('.relate_element');
	  // check process target
	  if( !data_no.length ){
	    system_message_alert('',"尚未選擇資料");
	    return false;
	  }  
	  
	  // confirm to admin
	  if(!confirm("確定要刪除影像 ?")){
	    return false;  
	  }
	  
	   // active ajax
      $.ajax({
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Products/objdel/'+data_no},
		beforeSend: function(){  system_loading(); },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  if(response.action){
			target_dom.remove();
			system_message_alert('alert',"影像已刪除");
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  system_loading(); });
	});
	
	//-- 打開上傳區
	
	var upload_process_fleg = false;
	
	$('#act_open_upload').click(function(){
	  $('.upload_area').css('display','flex');	
	  if ($('#upload_dropzone').is(':empty')){
        $('#upload_dropzone').addClass('dropzone_sign');
      }
	  
	  var upload_folder = '';
	  if( $('#upl_folder').is(':empty') ){
        if($('#upl_folder').data('cache')){
		  upload_folder = $('#upl_folder').data('cache');	
		}else{
		  var now = new Date(Date.now());
	      var month = parseInt(now.getMonth())+1;
		  month = month.toString().length==2 ? month : '0'+month.toString();
		  upload_folder = now.getFullYear()+"-"+month+"-"+now.getDate()+"_"+$('#acc_string').text();  
		}		 
		$('#upl_folder').val(upload_folder);
	  }
	  
	});
	
	
	$('#act_upload_close').click(function(){
	  $('.upload_area').css('display','none');
	  $('#act_clean_upload').trigger('click');
	});
	
	var $dropZone =  $("div#upload_dropzone").dropzone({
	  autoProcessQueue:false,
	  createImageThumbnails:true,
	  parallelUploads:1,
	  maxFiles:100,
	  url: "index.php?act=Products/objupl/", 
	  clickable: "#act_select_file",
	  paramName: "file",
	    init: function() {
		  this.on("addedfile", function(file) {
			  
			//file.fullPath
		    $('#complete_time').html('…');
			$('#act_active_upload').prop('disabled',false);
			$('#upload_dropzone').removeClass('dropzone_sign');
			
			/***-- 建立刪除按鈕 --***/
			// Create the remove button
			var removeButton = Dropzone.createElement("<i class='mark16 pic_photo_upload_delete option upl_delete' title='刪除'></i>");

			// Capture the Dropzone instance as closure.
			var _this = this;

			// Listen to the click event
			removeButton.addEventListener("click", function(e) {
			  // Make sure the button click doesn't submit the form:
			  e.preventDefault();
			  e.stopPropagation();

			  // Remove the file preview.
			  _this.removeFile(file);
			  // If you want to the delete the file on the server as well,
			  // you can do the AJAX request here.
			});

			// Add the button to the file preview element.
			file.previewElement.appendChild(removeButton);
		  });  
		},
		maxfilesreached: function(file){
		  system_message_alert("","到達上傳資料上限 100，若要增加檔案請清空後再重新加入");
		  //this.removeFile(file);
		},
		maxfilesexceeded: function(file){
		  this.removeFile(file);	
		},
	    sending: function(file, xhr, formData) {
		  // Will send the filesize along with the file as POST data.
		  formData.append("lastmdf", file.lastModified);
		  
		},
	    success: function(file, response){
		  result = JSON.parse(response);
		  if(result.action){
		    $(file.previewElement).addClass('dz-success');
		    $('#num_of_upload').html($('.dz-success').length);			
		  }else{
		    $(file.previewElement).addClass('dz-error');	
		    $(file.previewElement).find('.dz-error-message').children().html(result.info);
		  }
	    },
	    complete: function(file){
		  //-- maxfilesreached maxfilesexceeded 等超過檔案上限也會觸發
		  if( upload_process_fleg && this.getQueuedFiles().length){
		    this.processQueue();
		  }
		},
	    queuecomplete:function(){
		  
		  if(!upload_process_fleg){
			return false;  
		  }
		   
		  var now = new Date(Date.now());
		  var formatted = now.getFullYear()+"/"+(parseInt(now.getMonth())+1)+"/"+now.getDate()+' '+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds();   
		  $('#complete_time').html(formatted); 
		  
		  clearInterval(timer); 	// 關閉計時器
		  upload_button_freeze(0); 	// 打開上傳按鈕
		  upload = {};   			// 清空上傳暫存資料
		  upload_process_fleg = false 	// 關閉 fleg
		  
		  
		  reload_order_contract_list( $('._target').attr('no') );
		  
		}
	});
	
	
	//-- 啟動上傳
	var upload = {};
	$('#act_active_upload').click(function(){
	  
	  var button = $(this);
	  
	  if($(this).prop('disabled')){
		system_message_alert('','資料上傳中...');  
		return false;  
	  }	
	  
	  upload = {};
	  upload['list']      = [];
	  
	  $.each($dropZone[0].dropzone.getQueuedFiles(),function(i,file){
		var f={};
		f['name'] = file.name;
		f['type'] = file.type;
		f['size'] = file.size;
		f['lastmdf'] = file.lastModifiedDate.getTime();
		upload['list'][i] = f;
	  });
	  
	  // 待上傳檔案不可為空
	  if(!upload['list'].length){
		system_message_alert('','待上傳檔案不可為空');
	    return false;	
	  }
	  $('#num_of_queue').html(upload['list'].length);
	  
	  
	  upload_button_freeze(1); 
	  upload_process_fleg=true;
	  process_files_upload();
	
	});
	
	
	//-- 執行上傳檔案
	function process_files_upload(){
	  upload['list'] 	  = [];
	  $dropZone[0].dropzone.options.url="index.php?act=Products/objupl/"+$('._target').attr('no')+'/'+encodeURIComponent(Base64M.encode(JSON.stringify(upload)));
	  $dropZone[0].dropzone.processQueue();
	  upload_timer();
	}
	
	
	//-- 清空上傳清單
	$('#act_clean_upload').click(function(){
	  $dropZone[0].dropzone.removeAllFiles( true );
	  $("#num_of_upload,#num_of_queue").html('0');
	  $("#execute_timer").html('0');
	  $("#complete_time").html('…');
	  $("#upload_dropzone").addClass('dropzone_sign').empty();
	  $('#act_active_upload').prop('disabled',true);
	});
	
	
	//-- 上傳計時器
	var timer;
	var totalSeconds = 0;
	function upload_timer(){
	  totalSeconds = 0;
      timer = setInterval(setTime, 1000);
      function setTime(){
        ++totalSeconds;
        $('#execute_timer').html(pad(parseInt(totalSeconds/60))+':'+pad(totalSeconds%60));
      }
      function pad(val){
        var valString = val + "";
        if(valString.length < 2){
          return "0" + valString;
        }else{
          return valString;
        }
      }
	}
	
	//-- 上傳按鈕凍結
	function upload_button_freeze(option){
      if(option){
		$('#act_active_upload,#act_select_file').prop('disabled',true);  
	  }else{
		$('#act_active_upload,#act_select_file').prop('disabled',false);    
	  }
	}
	
	//-- 清空已上傳檔案
	$('#act_select_file' ).click(function(){
	  var dzObject = $dropZone[0].dropzone;
	  $.each(dzObject.getAcceptedFiles(),function(i,file){
		if(file.status == 'success'){
		  dzObject.removeFile(file);	  
		}
	  });
	});
	
	
	
	
	
	
	
	/*--------------------------------------------------------------------------------------------------------*/
	/*--------------------------------------------------------------------------------------------------------*/
  
  });  //-- end of initial --//
  
  
  
  
  
  
  
  
  
  
  
  
  


