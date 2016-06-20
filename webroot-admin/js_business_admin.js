/*    
  
  javascrip use jquery 
  rcdh 10 javascript pattenr rules v1
  
*/
 
  /***************************************************   
	    Houtorng Admin System # business admin action     
  ***************************************************/
	
  $(window).load(function () {   //  || $(document).ready(function() {	
	
	/* [ Admin Business Function Set ] */
	
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
	        data: {act:'Business/psort/'+element_order},
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
	
	
	
	
	//-- add bussiness record
	$(document).on('click','.business_editer',function(){
     	  
      var master_dom = $(this).parents('tr').clone();
      var editer_dom = $('<tr/>').addClass('data_editer').attr('no',master_dom.attr('no'));
	  
	  if($("tr.data_editer[no='"+master_dom.attr('no')+"']").length){
		return false;  
	  }
	  
	  master_dom.find('td').each(function(i,td){
		var field = $(td);  
		var form = $("<input/>").attr('type','text').attr('name',field.attr('field')).val(field.text());		
        if(typeof field.attr('field') != 'undefined'){
		  field.empty().append(form);
		}else{
		  field.empty().append('<span class="record_dele option" title="刪除"><i class="fa fa-trash-o" aria-hidden="true"></i></span> <span class="record_save option" "儲存"><i class="fa fa-floppy-o" aria-hidden="true"></i></span>');	
		}
		field.appendTo(editer_dom);	
	  });
	  editer_dom.insertAfter($(this).parents('tr.data_record')); 
	});
	
	
	$(document).on('click','.act_business_new',function(){
      var master_dom = $(this).parents('table.record_list').find('tr.data_record:nth-child(1)').clone();
      var editer_dom = $('<tr/>').addClass('data_editer').attr('no','_addnew');
	  master_dom.find('td').each(function(i,td){
		var field = $(td);  
		var form = $("<input/>").attr('type','text').attr('name',field.attr('field')).val('');		
        if(typeof field.attr('field') != 'undefined'){
		  field.empty().append(form);
		}else{
		  field.empty().append('<span class="record_dele option" title="刪除"><i class="fa fa-trash-o" aria-hidden="true"></i></span> <span class="record_save option" "儲存"><i class="fa fa-floppy-o" aria-hidden="true"></i></span>');	
		}
		field.appendTo(editer_dom);	
	  });
	  editer_dom.insertBefore($(this).parents('table.record_list').find('tr.data_record:nth-child(1)'));
	});
	
	
	//-- save record or create new
	$(document).on('click','.record_save',function(){
	  
	  var main_dom = $(this).parents('tr.data_editer');
	  var record_data = {};   
	  
	  record_data['pdgroup'] = $(this).parents('table').find('tr.data_title').children().text();
	  record_data['bid'] = main_dom.attr('no');
	  
	  // get value
	  main_dom.find('input').each(function(){
		record_data[$(this).attr('name')] = $(this).val();
	  });
	  
	  // encode data
	  var passer_data = encodeURIComponent(Base64M.encode(JSON.stringify(record_data)));
	  
	  // active ajax
      $.ajax({
        url: 'index.php',
	    type:'POST',
	    dataType:'json',
	    data: {act:'Business/save/'+passer_data},
		beforeSend: function(){  system_loading() },
        error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	    success: 	function(response) {
		  
		  if(response.action){
			  
			if(record_data['bid'] =='_addnew' ){
			  location.reload();
			}else{
			  var master_dom = $("tr.data_record[no='"+record_data['bid']+"']");
			  master_dom.find('td').each(function(){
			    if(   typeof $(this).attr('field') != 'undefined' ){
				  $(this).text(record_data[$(this).attr('field')]); 
			    }
			  });
			  main_dom.remove();	
			}  
		  }else{
			system_message_alert('',response.info);
	      }
	    },
		complete:	function(){  }
      }).done(function(r) {  system_loading()  });
	  
	});
	
	
	//-- delete record or create new
	$(document).on('click','.record_dele',function(){
		
	   // confirm to admin
	  if(!confirm("確定要刪除紀錄 ?")){
	    return false;  
	  }	
	  var main_dom = $(this).parents('tr.data_editer');
	  var DataNo = main_dom.attr('no');
	  
	  if(DataNo =='_addnew' ){
		main_dom.remove();  
	  }else{  
		// active ajax
        $.ajax({
			url: 'index.php',
			type:'POST',
			dataType:'json',
			data: {act:'Business/dele/'+DataNo},
			beforeSend: function(){  system_loading() },
			error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
			success: 	function(response) {
			  if(response.action){
				main_dom.prev().remove().end().remove();
			  }else{
				system_message_alert('',response.info);
			  }
			},
			complete:	function(){  }
        }).done(function(r) {  system_loading()  });  
	  }
		
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
  });