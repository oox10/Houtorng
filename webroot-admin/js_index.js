/*    
  
  javascrip use jquery 
  rcdh 10 javascript pattenr rules v1
  
*/
    /***************************************
	  System Type Function SET Name  e:AHDAS Admin System  
	***************************************/
	
	/*--  Set  function --*/
	
	//-- function name 
	
	/*
	// bind event
	$(document).on('click','.doc_act_save',function(){ });
	
	// ajax function
	    $.ajax({
          url: 'index.php',
	      type:'POST',
	      dataType:'json',
	      data: {act:'bw_meta_get',target:meta_id},
		  beforeSend: 	function(){ system_loading(); },
          error: 		function(xhr, ajaxOptions, thrownError) {  console.log( ajaxOptions+" / "+thrownError);},
	      success: 		function(response) {
			if(response.action){
			  $('#target_data').html(meta_id);
			  $("tr.row_initial[no='"+meta_id+"']").addClass('target_line');
			  meta_orl = response.data;
			  //$.each(response.data,function(field,meta){
			  //	if($('#meta_'+field).length){
			  //	  $('#meta_'+field).val(meta);
			  //	}
			  //});
			}else{
			  alert(response.info);
			}
	      },
		  complete:		function(){ system_loading();  }
		}).done(function() {  
		  $('.system_edit_area').css({'z-index':20, 'box-shadow':'0 0 10px rgba(0,0,0,0.43)'}).prev().css({'z-index':10,'box-shadow':'0 0 0 rgba(0,0,0,0)'});
		});
	*/
  
  
  /**************************************   
	    HAN-Archive Admin System     
  **************************************/
	
  $(window).load(function () {   //  || $(document).ready(function() {	
	
	
	/*  Admin SignIn Function Set */
	
	//-- page initial alert
	if($('.msg_info').html()){
	  system_message_alert('','');
	}
	

	//-- admin login 
	$('#act_admin_login').click(function(){
	  
	  // initial
	  $('#dt_aduacct,#dt_adupass').removeClass('form_error');
	  
	  
	  // check input 
	  if(!$('#dt_aduacct').val()){
	    $('#dt_aduacct').addClass('form_error').focus();
		return false;
	  }
	  
	  if(!$('#dt_adupass').val()){
	    $('#dt_adupass').addClass('form_error').focus();
		return false;
	  }
	  
	  var login_info = {};
	  login_info['account']  = $('#dt_aduacct').val();
	  login_info['password'] = $('#dt_adupass').val();
	  
	  var login_data = encodeURIComponent(Base64.encode(JSON.stringify(login_info)));
	 
	  $.ajax({
        url: 'index.php',
		type:'POST',
	    dataType:'json',
	    data: {act:'act_adlogin',data:login_data},
	    beforeSend: function(){ /*system_loading();*/},
        error: function(xhr, ajaxOptions, thrownError){ console.log( ajaxOptions+" / "+thrownError); },
	    success: function(response) { 
		  if(response.action){
			if(response.data.length){
			  location.href='./?act=act_adinter&refer='+response.data;
			  return 1;
			}else{
			  alert('login error');  
			}
		  }else{
		    system_message_alert('error',response.info);
		    $('#dt_adupass').val('').focus();
		  }
		},
		complete:		function(){ }
	  }).done(function() { /*system_loading(); */ });
	});
	
  });

  
  

  /* [ System Work Function Set ] */
	
  //-- error message alert 
  function system_message_alert(type,messg){
    
	if($('#message_container').length){
	  if(messg){
	    $('#message_container').children('.msg_title').html(messg);
	    $('#message_container').children('.msg_info').html('');
	  }
	}
	
    $('.system_message_area').show().delay(2000).animate({opacity:'0'},2000,function(){ 
	  $(this).hide().css('opacity','0.8');
	  $('#message_container').children('.msg_title').html('');
	  $('#message_container').children('.msg_info').html('');
	});
	
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  


