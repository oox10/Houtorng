<?php

  class Model_AdStaff extends Model_Main{
    
	
	/***--  Function Set --***/
    
	
	/*[ Staff Function Set ]*/ 
	
	//-- Admin Staff Page Initial 
	// [input] : NULL;
	public function ADStaff_Get_Staff_List(){
	  
	  try{
	  
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_SELECT_ALL_STAFF());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得帳戶資料
		$staff_list = array();
		$staff_list = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	    
		foreach($staff_list as &$staff){
		  
		  $status_info = ''; 
          
		  // 檢查帳戶狀態
		  if($staff['user_status']<5){
            switch( (string)$staff['user_status'] ){
		      case '0': $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_DISABLED';   break;
		      case '1': $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_REVIEWING';   break;
			  case '2': $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_REVIEWED';   break;
			  case '3': $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_UNACTIVE';   break;
			  case '4': $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_REPASSWD';   break;
			  default: $status_info = '_LOGIN_INFO_ACCOUNT_STATUS_UNKNOW';   break;
		    }
		  }
		  
		  // 檢查帳戶存取日期
		  $account_date_now   = strtotime('now');
		  $account_date_start = strtotime($staff['date_open']);
		  $account_date_limit = strtotime($staff['date_access']);
		  if( $account_date_now < $account_date_start){
		    $status_info = '_LOGIN_INFO_ACCOUNT_DATE_STARTYET';
		  }
		
		  if( $account_date_now > $account_date_limit){
		    $status_info = '_LOGIN_INFO_ACCOUNT_DATE_EXPIRED';
		  } 
		  
		  $staff['account_start'] = $status_info ? false : true ;
		  $staff['account_info']  = $staff['account_start'] ? '' : self::Message_Translate($status_info) ;
		}
		
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']   = $staff_list;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
	
	//-- Admin Staff Get Staff Data 
	// [input] : uno  :  \d+;
	
	public function ADStaff_Get_Staff_Data($StaffNo=0){
	
	  try{  
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$StaffNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 取得使用者資料
		$staff_data = NULL;
		$DB_GET	= $this->DBLink->prepare( $this->DBSql->ADMIN_STAFF_SELECT_ONE_STAFF() );
		$DB_GET->bindParam(':uno'   , $StaffNo , PDO::PARAM_INT);	
		if( !$DB_GET->execute() || !$staff_data = $DB_GET->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
		$this->ModelResult['data']   = $staff_data;
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	//-- Admin Staff Save Staff Data 
	// [input] : StaffNo    :  \d+  = DB.user_info.uid;
	// [input] : StaffModify  :   urlencode(base64encode(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	
	public function ADStaff_Save_Staff_Data($StaffNo=0 , $StaffModify=''){
	  
	  
	  $staff_modify = json_decode(base64_decode(rawurldecode($StaffModify)),true);
	  
	  try{  
		
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$StaffNo)  || !is_array($staff_modify)  ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 檢查更新內容
		if( !count($staff_modify) ){
		  throw new Exception('_SYSTEM_ERROR_DB_UPDATE_NULL');
		}
		
		
		// 取得使用者資料
		$staff_data = NULL;
		$DB_GET	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_SELECT_ONE_STAFF());
		$DB_GET->bindParam(':uno'   , $StaffNo , PDO::PARAM_INT);	
		if( !$DB_GET->execute() || !$staff_data = $DB_GET->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
		// 檢查更新欄位是否合法
		foreach($staff_modify as $mf => $mv){
		  if(!isset($staff_data[$mf])){
		    throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		  }
		}
		
		// 執行更新
		$DB_SAVE	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_UPDATE_STAFF_DATA(array_keys($staff_modify)));
		$DB_SAVE->bindValue(':uno' , $StaffNo);
		foreach($staff_modify as $mf => $mv){
		  $DB_SAVE->bindValue(':'.$mf , $mv);
		}
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// final 
		$this->ModelResult['data'] = $StaffNo;
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
	//-- Admin Staff Create Staff Data 
	// [input] : StaffModify  :   urlencode(base64encode(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	public function ADStaff_Newa_Staff_Data($StaffCreate=''){
	    
	  $staff_newa = json_decode(base64_decode(rawurldecode($StaffCreate)),true);
	  
	  try{  
		
		// 新增帳號
		if(  !isset($staff_newa['user_id']) ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
		
		$date_open   = isset($staff_newa['date_open']) && strtotime($staff_newa['date_open'])   ? date('Y-m-d H:i:s',strtotime($staff_newa['date_open'])) : date('Y-m-d H:i:s');
		$date_access = isset($staff_newa['date_open']) && strtotime($staff_newa['date_access']) ? date('Y-m-d H:i:s',strtotime($staff_newa['date_access'])) : date('Y-m-d').' 23:59:59';
		$DB_NEW	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_INSERT_USER_LOGIN());
		$DB_NEW->bindParam(':user_id'    ,$staff_newa['user_id']);
		$DB_NEW->bindParam(':date_open'  ,$date_open);
		$DB_NEW->bindParam(':date_access',$date_access);
	    if( !$DB_NEW->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_UPDATE_FAIL');
		}
		
		$new_user_no  = $this->DBLink->lastInsertId('user_login');
		
		$DB_INFO	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_INSERT_USER_INFO());
		$DB_INFO->bindParam(':uid'    	  , $new_user_no);
		$DB_INFO->bindValue(':user_name'  , isset($staff_newa['user_name']) ? $staff_newa['user_name'] : '' );
		$DB_INFO->bindValue(':user_idno'  , isset($staff_newa['user_idno']) ? $staff_newa['user_idno'] : '');
		$DB_INFO->bindValue(':user_staff' , isset($staff_newa['user_staff']) ? $staff_newa['user_staff'] : '');
		$DB_INFO->bindValue(':user_organ' , isset($staff_newa['user_organ']) ? $staff_newa['user_organ'] : '');
		$DB_INFO->bindValue(':user_tel'   , isset($staff_newa['user_tel']) ? $staff_newa['user_tel'] : '');
		$DB_INFO->bindValue(':user_mail'   , isset($staff_newa['user_mail']) ? $staff_newa['user_mail'] : '');
		$DB_INFO->bindValue(':user_address',isset($staff_newa['user_address']) ? $staff_newa['user_address'] : '');
		$DB_INFO->bindValue(':user_info'  , isset($staff_newa['user_info']) ? $staff_newa['user_info'] : '');
		$DB_INFO->bindValue(':user_note'  , isset($staff_newa['user_note']) ? $staff_newa['user_note'] : '');
		if( !$DB_INFO->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_UPDATE_FAIL');
		}
		
		// final 
		$this->ModelResult['data'] = $new_user_no;
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	//-- Admin Staff Account Accept & Sent Repass Mail 
	// [input] : uno  :  \d+;
	
	public function ADStaff_Staff_Account_Accept_Mail($StaffNo=0){
	  try{  
		
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$StaffNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 取得使用者資料
		$staff_data = NULL;
		$DB_GET	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_SELECT_ONE_STAFF());
		$DB_GET->bindParam(':uno'   , $StaffNo , PDO::PARAM_INT);	
		if( !$DB_GET->execute() || !$staff_data = $DB_GET->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
		// 建立註冊序號
	    $reg_code = substr(md5($staff_data['user_id'].'#'.time()),(rand(0,3)*8),8).'.'.System_Tool::generator_password(2);  
		
		// 註冊帳號開通連結
		$DB_REG= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_LOGIN_REGISTER_REPASSWORD_CODE());
		$DB_REG->bindParam(':uno', $StaffNo ,PDO::PARAM_INT);	
		$DB_REG->bindParam(':reg_code',$reg_code ,PDO::PARAM_STR);	
		$DB_REG->bindValue(':reg_state','_REGIST');
		$DB_REG->bindValue(':effect_time',date('Y-m-d H:i:s',strtotime("+7 day")));  
		
		
        if(! $DB_REG->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
        
		// 設定信件內容
        $to_sent = $staff_data['user_mail'];
        $user_reglink = _SYSTEM_SERVER_ADDRESS."account.php?act=adrepass&refer=".$reg_code;
		  
        $mail_content  = "<div>漢學管理系統帳號開通</div>";
        $mail_content .= "<div>帳號：".$staff_data['user_id']."</div>";
        $mail_content .= "<div>啟動：<a href='".$user_reglink."' target=_blank>".$user_reglink."</a></div>";
        $mail_content .= "<div>（請利用以上連結開通帳號並設定密碼，連結將於一週後(".date('Y-m-d H:i:s',strtotime("+7 day")).")失效）</div>";
        $mail_content .= "<div>有任何問題請洽：</div>";
        $mail_content .= "<div>EMAIL：<a href='mailto:"._SYSTEM_MAIL_CONTACT."'>"._SYSTEM_MAIL_CONTACT."</a></div>";
        $mail_content .= "<div> </div>";
        $mail_content .= "<div>本信由系統發出，請勿直接回覆</div>";
		      
			  
        $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->IsSMTP(); // telling the class to use SMTP 
		
		try {  
		        
		  if(_SYSTEM_MAIL_SSL_ACTIVE){
		    $mail->SMTPAuth   = true;                  // enable SMTP authentication
	        $mail->SMTPSecure = _SYSTEM_MAIL_SECURE;                 // sets the prefix to the servier
	        $mail->Port       = _SYSTEM_MAIL_PORT;     // set the SMTP port for the GMAIL server
		  }
				
		  $mail->Host       = _SYSTEM_MAIL_HOST; 	   // SMTP server
		  $mail->SMTPDebug  = 0;                       // enables SMTP debug information (for testing)
		  $mail->CharSet 	= "utf-8";
		  $mail->Username   = _SYSTEM_MAIL_ACCOUNT_USER.'@'._SYSTEM_MAIL_ACCOUNT_HOST;  // MAIL username
		  $mail->Password   = _SYSTEM_MAIL_ACCOUNT_PASS;  // MAIL password
		  //$mail->AddAddress('','');
          
		  $mail_to_sent = (preg_match('/.*?\s*<(.*?)>$/',$to_sent,$mail_paser)) ? trim($mail_paser[1]) : trim($to_sent);
		  if(!filter_var($mail_to_sent, FILTER_VALIDATE_EMAIL)){
		    throw new Exception('_LOGIN_INFO_REGISTER_MAIL_FALSE');
		  }
		  
		  $mail->AddAddress($mail_to_sent,'');
		  $mail->SetFrom(_SYSTEM_MAIL_ACCOUNT_USER.'@'._SYSTEM_MAIL_ACCOUNT_HOST, _SYSTEM_MAIL_FROM_NAME);
		  $mail->AddReplyTo(_SYSTEM_MAIL_ACCOUNT_USER.'@'._SYSTEM_MAIL_ACCOUNT_HOST, _SYSTEM_MAIL_FROM_NAME); // 回信位址
		  $mail->Subject = "["._SYSTEM_HTML_TITLE."]-帳號開通信件";
		  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		  $mail->MsgHTML($mail_content);
		  
		  //$mail->AddCC(); 
		  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
	      
		  if(!$mail->Send()) {
			throw new Exception($mail->ErrorInfo);  
		  } 
		  
          // 變更user_info pri => 0
		  $DB_SAVE	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_UPDATE_STAFF_DATA(array('user_status')));
		  $DB_SAVE->bindParam(':uno'      , $StaffNo , PDO::PARAM_INT);
		  $DB_SAVE->bindValue(':user_status' , 3 );
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  } 
		
		} catch (phpmailerException $e) {
		    $func_result['message'] = $e->errorMessage();  //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		    $func_result['message'] = $e->errorMessage();  //echo $e->getMessage(); //Boring error messages from anything else!
		}
        
		// final 
		$this->ModelResult['data']   = $staff_data;
		$this->ModelResult['action'] = true;
		
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	
	
	//-- Admin Staff Delete Staff Data 
	// [input] : uno  :  \d+;
	
	public function ADStaff_Del_Staff_Data($StaffNo=0){
	  try{  
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$StaffNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 變更user_info pri => 0
		$DB_SAVE	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_UPDATE_STAFF_DATA(array('user_pri')));
		$DB_SAVE->bindParam(':uno'      , $StaffNo , PDO::PARAM_INT);
		$DB_SAVE->bindValue(':user_pri' , 0 );
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// 移除user_login record
		$DB_SAVE	= $this->DBLink->prepare($this->DBSql->ADMIN_STAFF_DELETE_STAFF_LOGIN());
		$DB_SAVE->bindParam(':uno'      , $StaffNo );
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// final 
		$this->ModelResult['data']   = $StaffNo;
		$this->ModelResult['action'] = true;
		sleep(2);
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
    
	
	//-- Admin Staff Delete Staff Data 
	// [input] : uno  :  \d+;
	public function ADStaff_Account_Reset_Pass($StaffNo=0){
	  
	  
	  
		
	}
	
	
	
	
	
  }
?>