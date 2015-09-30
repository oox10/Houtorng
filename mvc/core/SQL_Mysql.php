<?php

  class SQL_Mysql{
  
	/**************************
	   MySQL String
	**************************/
	
    
    
	/* [ System Execute function Set ] */ 	
	
	/***-- System Work Sqls --***/
	
	//-- 系統紀錄 
	public static function SYSTEM_LOGS_USED_ACTION(){
	  $SQL_String = "INSERT INTO system_logs VALUES(NULL,NULL,:acc_ip,:acc_act,:acc_url,:request,:acc_from,:result,:agent);";
	  return $SQL_String;
	}
	
	
	
	
	/* [ Web Site function Set ] */ 	
	
	//-- Web Site Index : Get Product Data
	public static function WEBSITE_INDEX_GET_PRODUCT_LISR($lang = 'meta_cht'){
	  $SQL_String = "SELECT * FROM products LEFT JOIN ".$lang." ON pid=pno WHERE products._keep=1 ORDER BY view_order ASC , pid ASC;";
	  return $SQL_String;
	}
	
	
	//-- Web Site Index : Get Product Image
	public static function WEBSITE_GET_PRODUCT_OBJECT(){
	  $SQL_String = "SELECT * FROM product_obj WHERE pno=:pid AND file_keep=1 ORDER BY display_order ASC ,att_no ASC;";
	  return $SQL_String;
	}
	
	
	/* [ Admin System function Set ] */ 	
	
    /***-- Admin Login Function --***/
	
	//-- Admin Login : Get Account Data
	public static function ADMIN_LOGIN_GET_ACCOUNT_DATA(){
	  $SQL_String = "SELECT * FROM user_login WHERE user_id=:user_id;";
	  return $SQL_String;
	}
	
	//-- Admin Login : Get Account Data
	public static function ADMIN_LOGIN_REGIST_ACCOUNT_LOGIN(){
	  $SQL_String = "INSERT INTO user_access VALUES(NULL,:acc_key,:acc_uno,:acc_into,:acc_ip,:acc_from,NULL,'');";
	  return $SQL_String;
	}
	
	//-- Admin Login : Check Login Key
	public static function ADMIN_LOGIN_CHECK_LOGIN_KEY(){
	  $SQL_String = "SELECT acc_uno,acc_into,acc_ip,acc_from,acc_time,user_id,user_status FROM user_access LEFT JOIN user_login ON acc_uno=uno WHERE acc_key=:acc_key AND acc_active='';";
	  return $SQL_String;
	}
	
	//-- Admin Login : Cancle Login Key
	public static function ADMIN_LOGIN_CANCEL_LOGIN_KEY(){
	  $SQL_String = "UPDATE user_access SET acc_active=:acc_active WHERE acc_key=:acc_key;";
	  return $SQL_String;
	}
	
	
	
	/***-- Admin Staff Function --***/
	
	//-- Admin Staff : Get Staff List
	public static function ADMIN_STAFF_SELECT_ALL_STAFF(){
	  $SQL_String = "SELECT uno,user_id,user_status,date_open,date_access,user_name,user_idno,user_mail,user_staff,user_organ,user_tel FROM  user_info LEFT JOIN user_login ON uid=uno WHERE user_pri >= 1;";
	  return $SQL_String;
	}
	
	
	//-- Admin Staff : Get Staff Data
	public static function ADMIN_STAFF_SELECT_ONE_STAFF(){
	  $SQL_String = "SELECT uno,user_id,user_status,date_open,date_access,user_name,user_idno,user_mail,user_staff,user_organ,user_tel,user_address,user_note FROM  user_info LEFT JOIN user_login ON uid=uno WHERE uno=:uno AND user_pri >= 1;";
	  return $SQL_String;
	}
	
	//-- Admin Staff : Modify Staff Data
	public static function ADMIN_STAFF_UPDATE_STAFF_DATA( $MmodifyFields = array(1) ){
	  $condition = array();
	  foreach($MmodifyFields as $field){
	    $condition[] = $field.'=:'.$field;
	  }
	  $SQL_String = "UPDATE user_info LEFT JOIN user_login ON uid=uno SET ".join(',',$condition)." WHERE uno=:uno AND user_pri >= 1;";
	  return $SQL_String;
	}
	
	//-- Admin Staff : New Staff Login Data
	public static function ADMIN_STAFF_INSERT_USER_LOGIN(){
	  $SQL_String = "INSERT INTO user_login VALUES( NULL , :user_id , '' , '".date('Y-m-d H:i:s')."' , :date_open , :date_access , 4 ,NULL );";
	  return $SQL_String;
	}
	
	//-- Admin Staff : Insert Staff Information Data
	public static function ADMIN_STAFF_INSERT_USER_INFO(){
	  $SQL_String = "INSERT INTO user_info VALUES( :uid , :user_name , :user_idno , :user_staff , :user_organ , :user_tel , :user_mail, :user_address , :user_info ,:user_note , 1 );";
	  return $SQL_String;
	}
	
	
	//-- Admin Staff : Delete Staff Login Data
	public static function ADMIN_STAFF_DELETE_STAFF_LOGIN(){
	  $SQL_String = "DELETE FROM user_login WHERE uno = :uno;";
	  return $SQL_String;
	}
	
	//-- Admin Staff : 註冊帳號啟動碼
	public static function ADMIN_STAFF_LOGIN_REGISTER_REPASSWORD_CODE(){
	  $SQL_String = "INSERT INTO user_regist VALUES(NULL,:uno,:reg_code,:reg_state,:effect_time,'0000-00-00 00:00:00');";
	  return $SQL_String;
	}	
	
	
	//-- Admin Staff RePass Initial : 查詢 user_regist 確認 reg_code 是否合法
	public static function STAFF_LOGIN_REGIST_CODE_CHECK(){
	  $SQL_String = "SELECT uid,user_id,date_register,user_status,reg_state,effect_time FROM user_regist LEFT JOIN user_login ON uid = uno WHERE reg_code=:reg_code AND effect_time > :now;";
	  return $SQL_String;
	}
	
	//-- Client Login : 執行密碼設定以及帳號開通
	public static function STAFF_LOGIN_ACCOUNT_START(){
	  $SQL_String = "UPDATE user_regist LEFT JOIN user_login ON uid=uno SET user_pw=:passwd,user_status=:status,reg_state=:reg_state,active_time=:actie_time WHERE reg_code=:reg_code AND uid=:uid AND effect_time > :now;";
	  return $SQL_String;
	}
	
	
	/***-- Admin Product Function --***/
	
	//-- Admin Product : Get Product List
	public static function ADMIN_SELL_SELECT_PRODUCT_LANG_SET(){
	  $SQL_String = "SHOW table STATUS WHERE Name LIKE 'meta%'";
	  return $SQL_String;
	}
	
	
	//-- Admin Product : Get Product List
	public static function ADMIN_PRODUCT_SELECT_ALL_PRODUCTS(){
	  $SQL_String = "SELECT * FROM products LEFT JOIN meta_cht ON pid=pno WHERE products._keep=1 ORDER BY view_order ASC , pid DESC; ";
	  return $SQL_String;
	}
	
	//-- Admin Product : Get Product Data
	public static function ADMIN_PRODUCT_SELECT_ONE_PRODUCT(){
	  $SQL_String = "SELECT * FROM products WHERE pid=:pno AND products._keep=1; ";
	  return $SQL_String;
	}
	
	//-- Admin Product : Get Product Lang Meta
	public static function ADMIN_PRODUCT_SELECT_PRODUCT_META($Table=NULL){
	  $SQL_String = "SELECT * FROM ".$Table." WHERE pno=:pno;";
	  return $SQL_String;
	}
	
	
	//-- Admin Product : Insert Products Table
	public static function ADMIN_PRODUCT_CREATC_NEW_PRODUCT(){
	  $SQL_String = "INSERT INTO products VALUES(NULL,'',:client,:view_order,:temp,NULL,:_mask,1); ";
	  return $SQL_String;
	}
	
	//-- Admin Product : Insert Products Meta For Lang Table
	public static function ADMIN_PRODUCT_INSERT_PRODUCT_META_BY_LANG($Table=NULL){
	  $SQL_String = "INSERT INTO ".$Table." VALUES(:pno,:title_type,:title_product,:design,:useto,:specification,:page_url,NULL,:editer); ";
	  return $SQL_String;
	}
	
	
	
	//-- Admin Product : Modify Product Data
	public static function ADMIN_PRODUCT_UPDATE_PRODUCT_DATA( $Table,$MmodifyFields = array(1) ){
	  $condition = array();
	  foreach($MmodifyFields as $field){
	    $condition[] = $field.'=:'.$field;
	  }
	  $SQL_String = "UPDATE ".$Table." SET ".join(',',$condition)." WHERE ".( $Table=='products' ? 'pid':'pno')."=:pno;";
	  return $SQL_String;
	}
	
	
	//-- Admin Product : Get Product Relate Files
	public static function ADMIN_PRODUCT_SELECT_PRODUCT_DISPLAY(){
	  $SQL_String = "SELECT att_no,acc_name,file_size,time_upload FROM product_obj WHERE pno =:pno AND file_keep=1 ORDER BY att_no ASC";
	  return $SQL_String;
	}
	
	//-- Admin Product : Insert Order attachment data
	public static function ADMIN_PRODUCT_INSERT_RELATE_OBJECT(){
	  $SQL_String = "INSERT INTO product_obj VALUES( NULL , :pno , '' , :file_name ,:file_type , :file_size ,'',9, :handler , NULL , 0 , 0 );";
	  return $SQL_String;
	}
	
	
	//-- Admin Product : Delete Product attachment data
	public static function ADMIN_PRODUCT_DELETE_ATTACHMENT(){
	  $SQL_String = "UPDATE product_obj SET file_keep=0 WHERE att_no=:att_no AND handler=:handler;";
	  return $SQL_String;
	}
	

	
	/* [ Client System function Set ] */ 	
	
	
    /***-- Client Login Function --***/
	
	//-- Client Login : Get Archive Data
	public static function CLIENT_LOGIN_CHECK_ARCHIVE_INUSE($table='list_archive'){
	  $SQL_String = "SELECT * FROM ".$table." WHERE archive_id=:archive_id AND archive_keep=1;";
	  return $SQL_String;
	}
	
	//-- Client Login : Get B2B Archive Order Data
	public static function CLIENT_LOGIN_CHECK_ARCHIVE_ORDER_B2B(){
	  $SQL_String = "SELECT company_name,limit_online,limit_iprange,mask_client,date_start,date_end FROM map_order2archive LEFT JOIN customers_order ON o_no = ono LEFT JOIN customers ON cid=system_cid WHERE customer_type='B2B' AND a_no=:a_no AND order_status=1 AND order_keep=1 AND ( :today BETWEEN date_start AND date_end ) AND data_keep=1 AND oa_keep=1; ";
	  return $SQL_String;
	}
	
	
	//-- Client Login : Get B2C Archive Order Data
	public static function CLIENT_LOGIN_CHECK_ARCHIVE_ORDER_B2C(){
	  $SQL_String = "SELECT contact_person,limit_online,limit_iprange,mask_client,date_start,date_end FROM map_order2archive LEFT JOIN customers_order ON o_no = ono LEFT JOIN customers ON cid=system_cid WHERE a_no=:a_no AND cid=:cid AND order_status=1 AND order_keep=1 AND ( :today BETWEEN date_start AND date_end ) AND data_keep=1 AND oa_keep=1; ";
	  return $SQL_String;
	}
	
	//-- Client Login : Check email if in use
	public static function CLIENT_LOGIN_CHECK_REGISTER_MAIL(){
	  $SQL_String = "SELECT cano,account,email,register_date,register_from,status,active FROM client_account WHERE account=:email OR email=:email; ";
	  return $SQL_String;
	}
	
	//-- Client Login : Check email if in use
	public static function CLIENT_LOGIN_GET_ACCOUNT_DATA(){
	  $SQL_String = "SELECT * FROM client_account WHERE account=:account; ";
	  return $SQL_String;
	}
	
	
	//-- Client Login : Register User Account
	public static function CLIENT_LOGIN_REGISTER_USER_ACCOUNT(){
	  $SQL_String = "INSERT INTO client_account VALUES(NULL,'B2B',:account,'',:email,:register_date,:register_from,:status,:active,'0000-00-00 00:00:00'); ";
	  return $SQL_String;
	}
    	
	//-- Client Login : 註冊帳號啟動碼
	public static function CLIENT_LOGIN_REGISTER_REPASSWORD_CODE(){
	  $SQL_String = "INSERT INTO client_regist VALUES(NULL,:uno,:reg_code,:reg_state,:effect_time,'0000-00-00 00:00:00');";
	  return $SQL_String;
	}	
		
	//-- Client Login : 變更使用者狀態為可重設
	public static function CLIENT_LOGIN_REGISTER_USER_SET_REPASSWORD(){
	  $SQL_String = "UPDATE client_account SET account=:account,email=:email,status=3 WHERE cano=:cano;";
	  return $SQL_String;
	}	
	
	//-- Client Login : 變更使用者狀態為重設密碼
	public static function CLIENT_LOGIN_SET_ACCOUNT_REPASSWORD(){
	  $SQL_String = "UPDATE client_account SET passwd='',status=4 WHERE cano=:cano;";
	  return $SQL_String;
	}
	
	
	//-- Client Login : 查詢 user_regist 確認 reg_code 是否合法
	public static function CLIENT_LOGIN_REGIST_CODE_CHECK(){
	  $SQL_String = "SELECT uid,account,register_date,register_from,active,reg_state,effect_time FROM client_regist LEFT JOIN client_account ON uid = cano WHERE reg_code=:reg_code AND effect_time > :now;";
	  return $SQL_String;
	}
	
	//-- Client Login : 執行密碼設定以及帳號開通
	public static function CLIENT_LOGIN_ACCOUNT_START(){
	  $SQL_String = "UPDATE client_regist LEFT JOIN client_account ON uid=cano SET passwd=:passwd,status=:status,reg_state=:reg_state,active_time=:actie_time WHERE reg_code=:reg_code AND uid=:uid AND effect_time > :now;";
	  return $SQL_String;
	}
	
	//-- Client Login : 註冊登入序號
	public static function CLIENT_LOGIN_ACCESS_KEY_REGIST(){
	  $SQL_String = "INSERT INTO client_signin VALUES(NULL,:acc_key,:acc_archive,:acc_ip,'0000-00-00 00:00:00','0000-00-00 00:00:00',:usr_key,:usr_no,:usr_ip,:usr_from,:sign_time,:ukey_life);";
	  return $SQL_String;
	}
	
	
	//-- Client Login : 變更使用者密碼
	public static function CLIENT_DATA_UPDATE_USER_PASSWORD(){
	  $SQL_String = "UPDATE client_account SET passwd=:passwd WHERE cano=:cano";
	  return $SQL_String;
	}
	
	
	
	/***-- Server Resource Function --***/
	
	//-- Client Login : 查詢登入序號
	public static function SERVER_INITIAL_CLIENT_SIGNIN(){
	  $SQL_String = "SELECT * FROM client_signin LEFT JOIN client_account ON cano=usr_no WHERE usr_key=:usr_key;";
	  return $SQL_String;
	}
	
	
	//-- Client Login : 取得登入紀錄
	public static function SERVER_INITIAL_GET_CLIENT_SIGNIN_DATA(){
	  $SQL_String = "SELECT usr_ip,sign_time,archive_id,archive_name FROM client_signin LEFT JOIN list_archive ON acc_archive=archive_id WHERE usr_no=:usr_no;";
	  return $SQL_String;
	}
	
	//-- Client Login : 註銷登入序號
	public static function SERVER_INITIAL_CANCEL_SIGNKEY(){
	  $SQL_String = "UPDATE client_signin SET acc_time=:acc_time , acc_life=:acc_life WHERE csno=:csno;";
	  return $SQL_String;
	}
	
	
	//-- Client Login : 取得帳號資源
	public static function SERVER_ACCESS_CLIENT_RESOURCE(){
	  $SQL_String = "SELECT * FROM client_signin LEFT JOIN client_account ON cano=usr_no WHERE acc_key=:acc_key;";
	  return $SQL_String;
	}
	
	
	
  }

?>