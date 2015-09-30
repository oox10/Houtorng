<?php

  class Model_Index extends Model_Main{
    
	
	/***--  Initial  --***/
	public function __construct(){
	  $this->db_connect();
	  $this->ModelResult    = array('action'=>false,'data'=>array(),'message'=>array());
	}
	
	public function __destruct(){
      $this->DBLink 	= NULL;
	}
	
	
	/***--  Function Set --***/

	
	/*[ Admin Login Function Set ]*/ 
	
	
	//-- Admin Login & check 
	// [input] : login data  :  urlencode(base64encode(json_pass()))  = array('account'=>'' , 'password'=>'');
	public function ADLogin_Active_Login($LoginData=''){
	  
	  $login_data = json_decode(base64_decode(rawurldecode($LoginData)),true);
	  
	  try{
	    
		// 檢查登入參數
		if( !isset($login_data['account'])  ||  !isset($login_data['password'])  ){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
	    
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_LOGIN_GET_ACCOUNT_DATA());
		if(!$DB_OBJ->execute(array('user_id'=>$login_data['account']))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}
		
		// 取得帳戶資料
		$user_login = false;
		if( !$user_login = $DB_OBJ->fetch(PDO::FETCH_ASSOC ) ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_UNFOUND');  
		}
		
		// 帳戶檢查  DB:user_login.user_status  0=>stop  1=>register  2=>reviewed  3=>unactive 4=>repass  5=>active 
		if($user_login['user_status']<5){
          switch( (string)$user_login['user_status'] ){
		    case '0': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_DISABLED');   break;
		    case '1': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REVIEWING');  break;
			case '2': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REVIEWED');   break;
			case '3': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_UNACTIVE');   break;
			case '4': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REPASSWD');   break;
			default: throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_UNKNOW');    break;
		  }
		}
		
		// 檢查帳戶密碼
		$user_password = sha1(md5($login_data['password'].'#'._SYSTEM_NAME_SHORT).'&'.$login_data['account']);
		if( $user_login['user_pw'] !== $user_password   ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_PASSWORD_FAIL');
		}
		
		// 檢查帳戶存取日期
		$account_date_now   = strtotime('now');
		$account_date_start = strtotime($user_login['date_open']);
		$account_date_limit = strtotime($user_login['date_access']);

		if( $account_date_now < $account_date_start){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_DATE_STARTYET');
		}
		
		if( $account_date_now > $account_date_limit){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_DATE_EXPIRED');
		}
		
		
		/*--------------------------------------------------------------------------*/
		
		// 成功登入 - 註冊登入序號
		$key_zone  = rand(0,3)*8;
		$login_key = substr(md5($user_login['user_id'].'#'.time()),$key_zone,8).'-'.($key_zone/8);
		
		$ID_REG	= $this->DBLink->prepare($this->DBSql->ADMIN_LOGIN_REGIST_ACCOUNT_LOGIN());
		$ID_REG->bindParam(':acc_key'   , $login_key , PDO::PARAM_STR);	
		$ID_REG->bindParam(':acc_uno'   , $user_login['uno'] , PDO::PARAM_INT );	
		$ID_REG->bindValue(':acc_into'  , _SYSTEM_NAME_SHORT , PDO::PARAM_STR);
		$ID_REG->bindValue(':acc_ip'    , System_Tool::get_client_ip());
        $ID_REG->bindValue(':acc_from'  , isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'' );
				
		if(!$ID_REG->execute()){
		  throw new Exception('_LOGIN_INFO_LOGIN_REGISTER_FAIL');
		}		
	
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']   = $login_key;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
	
	//-- Admin Login & check 
	// [input] : login key  :  \w{8}-\d;
	
	public function ADLogin_Inter_Admin($LoginKey=''){
	
	  try{
	    
		// 檢查登入序號
	    if(!preg_match('/^[\w\d]{8}\-\d$/',$LoginKey)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 取得登入資訊
		$login_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->ADMIN_LOGIN_CHECK_LOGIN_KEY());
		$DB_CHK->bindParam(':acc_key'   , $LoginKey , PDO::PARAM_STR);	
		if( !$DB_CHK->execute() || !$login_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_LOGIN_KEY_FAIL');
		}
		
		// 檢查登入有效期限
		if( ( strtotime($login_data['acc_time'])+30 ) < strtotime("now") ){
		  throw new Exception('_LOGIN_INFO_LOGIN_KEY_EXPIRED');
		} 
		
		// 註銷登入序號
		$DB_UPTKEY	= $this->DBLink->prepare($this->DBSql->ADMIN_LOGIN_CANCEL_LOGIN_KEY());
		$DB_UPTKEY->bindParam(':acc_key'   , $LoginKey , PDO::PARAM_STR);	
		$DB_UPTKEY->bindValue(':acc_active', date('Y-m-d H:i:s'), PDO::PARAM_STR);	
		$DB_UPTKEY->execute();
		
		
		$this->ModelResult['data']['ADMIN_LOGIN_TOKEN'] = date('Y-m-d H:i:s');
		$this->ModelResult['data']['USER_NO'] = $login_data['acc_uno'];
		$this->ModelResult['data']['USER_ID'] = $login_data['user_id'];
		$this->ModelResult['action'] = true;
		    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	
	
	//-- Check Register Code To Initial Ad Account Repassword Page 
	// [input] : RegisterCode:  User Account Reset Password Code => from regist mail link ;
	public function Initial_ADAccount_RePassword( $RegisterCode='' ){
	  
	  try{
	    
		// 檢查登入驗證碼
		if( !preg_match('/^\w{8}\.\w{2}$/i',$RegisterCode)){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 檢查啟動碼是否有效
		$regist_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->STAFF_LOGIN_REGIST_CODE_CHECK());
		$DB_CHK->bindParam(':reg_code'   , $RegisterCode, PDO::PARAM_STR);	
		$DB_CHK->bindValue(':now'   , date('Y-m-d H:i:s'), PDO::PARAM_STR);	
		
		// 是否存在啟動碼
		if( !$DB_CHK->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// 查無啟動碼
		if( !$regist_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_REGISTER_RGCODE_FAIL');
		}
		
		// 啟動碼已經使用過 
		if( '_REGIST' != $regist_data['reg_state'] ){
		  throw new Exception('_LOGIN_INFO_REGISTER_RGCODE_USED');
		}
		
		$this->ModelResult['session']['uno'] 	  = $regist_data['uid'];
		$this->ModelResult['session']['account']  = $regist_data['user_id'];
		$this->ModelResult['session']['register_from'] = _SYSTEM_SERVER_ADDRESS;
		$this->ModelResult['session']['reg_code'] = $RegisterCode;
		$this->ModelResult['session']['request_from'] 	= _SYSTEM_SERVER_ADDRESS;
		$this->ModelResult['session']['account_type'] = '_staff';
		
		
		
		
		$this->ModelResult['data']['account'] = $regist_data['user_id'];
		$this->ModelResult['data']['regdate'] = $regist_data['date_register'];
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
	//-- Admin Account Password Reset 
	// [input] : SESSION  :  REGIST Code refer data => from $_SESSION
	// [input] : PassWord :  User Account Reset Password Code => urlencode(base64encode(json_pass()))  = array('regist_password01'=>'' , 'regist_password02'=>'');;
	public function Active_AdAccount_Reset_Password( $Session=array() , $PassWord='' ){
	  
	  $regist_pass = json_decode(base64_decode(rawurldecode($PassWord)),true);
	  
	  try{
	    
		// 檢查相關參數
		if(!$Session['uno'] || !$Session['account'] || !$Session['reg_code'] ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');	
		}
		
		// 檢查輸入的密碼
		if( !isset($regist_pass['regist_password01']) && !strlen($regist_pass['regist_password01']) && $regist_pass['regist_password01'] != $regist_pass['regist_password02'] ){
	      throw new Exception('_LOGIN_INFO_REGISTER_PASSWORD_FAIL');
	    }
		
		// 進行密碼加密
		$user_password = sha1(md5($regist_pass['regist_password01'].'#'._SYSTEM_NAME_SHORT).'&'.$Session['account']);
		
		// 更新資料庫
		$DB_UPD	= $this->DBLink->prepare($this->DBSql->STAFF_LOGIN_ACCOUNT_START());
		$DB_UPD->bindParam(':passwd'  	  , $user_password, PDO::PARAM_STR);	
		$DB_UPD->bindValue(':status'   	  , 5 , PDO::PARAM_INT);	
		$DB_UPD->bindValue(':reg_state'   , '_ACTIVE', PDO::PARAM_STR);	
		$DB_UPD->bindValue(':actie_time'  , date('Y-m-d H:i:s'));
        $DB_UPD->bindValue(':reg_code'    , $Session['reg_code']);
        $DB_UPD->bindValue(':uid'		  , $Session['uno']);
        $DB_UPD->bindValue(':now'   	  , date('Y-m-d H:i:s'));	
        		
		if( !$DB_UPD->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		$this->ModelResult['data']['account'] = $Session['account'];
		$this->ModelResult['data']['from']    = $Session['register_from'];
		$this->ModelResult['action'] = true;
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
	/*[ Client Login Function Set ]*/ 
	
	
	//-- Client Login Archive Initial 
	// [input] : Client Ip   :  User IP String ;
	// [input] : Archive ID  :  system archive name ;
	public function Archive_Login_Initial( $UserIp='' , $ArchiveID='' ){
	
	  try{
	    
		// 檢查IP
	    if(!preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/',$UserIp)){
		  throw new Exception('_LOGIN_INFO_CLIENT_IP_UNKNOW');
		}
		
		// 檢查資料庫是否開啟
		$archive_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_ARCHIVE_INUSE());
		$DB_CHK->bindParam(':archive_id'   , $ArchiveID , PDO::PARAM_STR);	
		if( !$DB_CHK->execute() || !$archive_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_LOGIN_ARCHIVE_UNUSE');
		}
		
		// 檢查是否存在  B2B 客戶 => 用來檢測是否要顯示帳號註冊
	    $customers_data = NULL;
		$DB_CUS	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_ARCHIVE_ORDER_B2B());
		$DB_CUS->bindValue(':a_no'  , $archive_data['ano'] );	
		$DB_CUS->bindValue(':today' , date('Y-m-d H:i:s') );
		if( $DB_CUS->execute() && $customers_data = $DB_CUS->fetchAll(PDO::FETCH_ASSOC)){
		  $ip_check_set = array();
		  foreach($customers_data as $tmp_cus){
            $limit_set = array_filter(preg_split('/(,|，|;|；|\n|\r|<\/?.*?>|\s+|　)/',$tmp_cus['limit_iprange']));
			foreach($limit_set as $iprange){
		      $iprange = preg_replace('/\s+/','',$iprange);
			  $iprange = preg_replace('/~|～|－|to/','-',$iprange);
			  if( self::check_ip_in_limit($UserIp,$iprange)){
				$this->ModelResult['data']['order'] = array( 'company'=>$tmp_cus['company_name'] );
				break;  
			  }
			}
		  }
		}else{
		  // 不存在B2B客戶  不開放帳號註冊
		}
	    $this->ModelResult['data']['user_ip'] = $UserIp;
		$this->ModelResult['data']['archive'] = $archive_data;
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	
	//-- IS IP in RANGE ?  
	// [input] : Client Ip  :  User IP String ;
	// [input] : IP RANGE   :  IP Range String ;
	protected function check_ip_in_limit( $TargetIp , $IPRange){
	  // 檢查受測IP	
	  if(!ip2long($TargetIp)){  return false; }
	  
	  //完整IP
	  if( preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$IPRange) && filter_var($IPRange, FILTER_VALIDATE_IP) ){
		return ($IPRange=='0.0.0.0' || ip2long($TargetIp)===ip2long($IPRange)) ? true : false;
	    exit(1);
	  }
	  
	  //完整區段IP
	  if( preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\-(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/',$IPRange,$ipmatch) && filter_var($ipmatch[1], FILTER_VALIDATE_IP) && filter_var($ipmatch[2], FILTER_VALIDATE_IP)){
		return  (max($ipmatch[1],$ipmatch[2]) >= $TargetIp && min($ipmatch[1],$ipmatch[2]) <= $TargetIp) ?  true : false;
	    exit(1);
	  }
	  
	  //底層區段 IP range
	  if( preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.)(\d{1,3}\-\d{1,3})$/',$IPRange,$ipmatch) ){  
		$range  = explode('-',$ipmatch[2]);
		$ipfrom = $ipmatch[1].$range[0];
		$ipto   = $ipmatch[1].$range[1];
 		if(filter_var($ipfrom, FILTER_VALIDATE_IP) && filter_var($ipto, FILTER_VALIDATE_IP)  ){
		  return  (max($ipfrom,$ipto) >= $TargetIp && min($ipfrom,$ipto) <= $TargetIp) ?  true : false;
		  exit(1);
		}
		return false;
	  }
	}
	
	
	//-- Client Login & check 
	// [input] : login data  :  urlencode(base64encode(json_pass()))  = array('archive'=>'' , 'account'=>'' , 'password'=>'' , 'company'=>'' );
	public function Active_Client_Sign_In_Archive( $UserIp='' ,  $LoginData=''){
	  
	  $login_data = json_decode(base64_decode(rawurldecode($LoginData)),true);
	  
	  try{
		
        // 檢查登入參數
		if( !isset($login_data['account'])  ||  !isset($login_data['password'])  ){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 查詢使用者帳戶
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_GET_ACCOUNT_DATA());
		if(!$DB_OBJ->execute(array('account'=>$login_data['account']))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}
		
		
		// 取得帳戶資料
		$user_login = false;
		if( !$user_login = $DB_OBJ->fetch(PDO::FETCH_ASSOC ) ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_UNFOUND');  
		}
		
		
		// 儲存用戶資料，做為跳轉判別
		$this->ModelResult['user'] = $user_login;
		
		
		// 帳戶狀態檢查
		if( !$user_login['active'] ){
          throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_DISABLED');
		}
		
		// 帳戶權限檢查  DB:user_login.user_status  0=>stop  1=>register  2=>reviewed  3=>unactive 4=>repass  5=>active 
		if($user_login['status']<5){
          switch( (string)$user_login['status'] ){
		    case '1': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REVIEWING');  break;
			case '2': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REVIEWED');   break;
			case '3': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_UNACTIVE');   break;
			case '4': throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_REPASSWD');   break;
			default: throw new Exception('_LOGIN_INFO_ACCOUNT_STATUS_UNKNOW');    break;
		  }
		}
		
		// 檢查帳戶密碼
		$user_password = sha1(md5($login_data['password'].'#'._SYSTEM_NAME_SHORT).'&'.$login_data['account']);
		if( $user_login['passwd'] !== $user_password   ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_PASSWORD_FAIL');
		}
		
		$archive_list = $login_data['company']=='airiti' ? 'archive_airiti' : 'list_archive';
		
		
		// 檢查資料庫是否開啟
		$archive_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_ARCHIVE_INUSE($archive_list));
		$DB_CHK->bindParam(':archive_id'   , $login_data['archive'] , PDO::PARAM_STR);	
		if( !$DB_CHK->execute() || !$archive_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_LOGIN_ARCHIVE_UNUSE');
		}
		
		
		if($user_login['ctype']=='B2B'){   // B2B 客戶需檢查適用IP
		  $customers_data = NULL;
		  $DB_CUS	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_ARCHIVE_ORDER_B2B());
		  $DB_CUS->bindValue(':a_no'  , $archive_data['ano'] );	
		  $DB_CUS->bindValue(':today' , date('Y-m-d H:i:s') );
		  if( $DB_CUS->execute() && $customers_data = $DB_CUS->fetchAll(PDO::FETCH_ASSOC)){
		    foreach($customers_data as $tmp_cus){
              
			  // 檢查帳號是否在禁止清單中
			  if(in_array($user_login['account'],array_filter(preg_split('/[,，]/',$tmp_cus['mask_client'])))){
				throw new Exception('_LOGIN_INFO_ACCOUNT_IS_MASK_FROM_ORDER');     
				continue;  
			  }
			  
			  // 檢查帳號是否通過IP範圍
			  $limit_set = array_filter(preg_split('/(,|，|;|；|\n|\r|<\/?.*?>|\s+|　)/',$tmp_cus['limit_iprange']));
			  foreach($limit_set as $iprange){
		        $iprange = preg_replace('/\s+/','',$iprange);
			    $iprange = preg_replace('/~|～|－|to/','-',$iprange);
			    if( self::check_ip_in_limit($UserIp,$iprange)){
				  $this->ModelResult['data']['order'][] = array( 'company'=>$tmp_cus['company_name'] );
				  break;  
			    }
			  }   
			}
			if(!isset( $this->ModelResult['data']['order'] )){
			  throw new Exception('_LOGIN_INFO_USER_IP_OUT_OF_B2B_LOGIN');   
			}
		  }else{
			throw new Exception('_LOGIN_INFO_USER_IP_OUT_OF_B2B_ORDER');    
		  }
		}
		
		
		if($user_login['ctype']=='B2C'){   // B2C 客戶需檢查適用資料庫 
		  
		  $cid  = $user_login['register_from'];
		  
		  $customers_data = NULL;
		  $DB_CUS	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_ARCHIVE_ORDER_B2C());
		  $DB_CUS->bindValue(':cid'   , $cid );	
		  $DB_CUS->bindValue(':a_no'  , $archive_data['ano'] );	
		  $DB_CUS->bindValue(':today' , date('Y-m-d H:i:s') );
		  if( $DB_CUS->execute() && $customers_data = $DB_CUS->fetchAll(PDO::FETCH_ASSOC)){
		    
			foreach($customers_data as $tmp_cus){  
			  // 檢查帳號是否通過IP範圍
			  $limit_set = array_filter(preg_split('/(,|，|;|；|\n|\r|<\/?.*?>|\s+|　)/',$tmp_cus['limit_iprange']));
			  foreach($limit_set as $iprange){
		        $iprange = preg_replace('/\s+/','',$iprange);
			    $iprange = preg_replace('/~|～|－|to/','-',$iprange);
			    if( self::check_ip_in_limit($UserIp,$iprange)){
				  // 檢查帳號是否在核可清單中
			      if(in_array($user_login['account'],array_filter(preg_split('/[,，]/',$tmp_cus['mask_client'])))){
				    $this->ModelResult['data']['order'][] = array( 'customer'=>$tmp_cus['contact_person'] );
				    break;     
			      }
			    }
			  }   
			}
			if(!isset( $this->ModelResult['data']['order'] )){
			  throw new Exception('_LOGIN_INFO_USER_IP_OUT_OF_B2C_LOGIN');   
			}
		  }else{
			throw new Exception('_LOGIN_INFO_USER_IP_OUT_OF_B2B_ORDER');    
		  }
		  
		}
		
		/*--------------------------------------------------------------------------*/
		
		// 成功登入 - 註冊登入序號
		$key_zone  = rand(0,3)*8;
		
		$usr_key   = substr(md5($user_login['account'].'#'.time()),$key_zone,8).'-'.($key_zone/8);
		$acc_key   = sha1(md5($user_login['account'].'#'.time()).'@'.$archive_data['archive_id']);
		$sign_time = date('Y-m-d H:i:s');
		
		$IN_REG	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_ACCESS_KEY_REGIST());
		$IN_REG->bindParam(':acc_key'     , $acc_key, PDO::PARAM_STR);	
		$IN_REG->bindParam(':acc_archive' , $archive_data['archive_id'] , PDO::PARAM_STR);	
		$IN_REG->bindParam(':acc_ip'      , $archive_data['archive_ip'] , PDO::PARAM_STR);	
		$IN_REG->bindParam(':usr_key'     , $usr_key , PDO::PARAM_STR);	
		$IN_REG->bindParam(':usr_no'      , $user_login['cano'] , PDO::PARAM_STR);	
		$IN_REG->bindParam(':usr_ip'      , $UserIp , PDO::PARAM_STR);	
		$IN_REG->bindValue(':usr_from'    , isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' );
		$IN_REG->bindValue(':sign_time'   , $sign_time);	
		$IN_REG->bindValue(':ukey_life'   , date('Y-m-d H:i:s',strtotime('+30 seconds')));
		
		if(!$IN_REG->execute()){
		  throw new Exception('_LOGIN_INFO_LOGIN_REGISTER_FAIL');
		}		
	    
		$this->ModelResult['data']   = $archive_data['archive_address'].'?refer='.$usr_key;	
		$this->ModelResult['action'] = true;		
			
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
	
	
	//-- Client Regist Archive Account 
	// [input] : Client Ip   :  User IP String ;
	// [input] : Verification:  $_SESSION['turing_string'] ;
	// [input] : RegistData  :  array(regist_email , user key verification);
	public function Active_Client_Account_Register( $UserIp='' , $VerificationCode='' , $RegistData='' ){
	  
	  $regist_data = json_decode(base64_decode(rawurldecode($RegistData)),true);
	  
	  try{
	    
		// 檢查登入參數
		if( !isset($regist_data['regist_email'])  ||  !isset($regist_data['verification'])  ){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 檢查登入驗證碼
		if( $regist_data['verification'] != $VerificationCode ){
	      throw new Exception('_LOGIN_INFO_VERIFICATION_FALSE');
	    }
		
		// 檢查電子郵件
		if( !filter_var($regist_data['regist_email'], FILTER_VALIDATE_EMAIL) ){
	      throw new Exception('_LOGIN_INFO_REGISTER_MAIL_FALSE');
	    }
		
		// 檢查信箱是否已被註冊
		$account_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_REGISTER_MAIL());
		$DB_CHK->bindParam(':email'   , $regist_data['regist_email'] , PDO::PARAM_STR);	
		if( !$DB_CHK->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		if($account_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  $this->ModelResult['data']['account'] = $account_data;
		  throw new Exception('_LOGIN_INFO_REGISTER_MAIL_USED');
		}
		
		
		// 註冊帳號
        $DB_REG	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_REGISTER_USER_ACCOUNT());
		$DB_REG->bindValue(':account'  , '' );	
		$DB_REG->bindValue(':email'    , '' );
		$DB_REG->bindValue(':register_date' , date('Y-m-d H:i:s') );
		$DB_REG->bindValue(':register_from' , $_SERVER['HTTP_REFERER'] );
		$DB_REG->bindValue(':status' , 1 );
		$DB_REG->bindValue(':active' , 1 );
		if( !$DB_REG->execute()){
		  throw new Exception('_LOGIN_INFO_REGISTER_ACCOUNT_FAIL');
		}
		
		$new_client_no  = $this->DBLink->lastInsertId('client_account');
		$process_repassword = self::Process_Account_Password_Setting($new_client_no,$regist_data['regist_email'],$regist_data['regist_email']);
		
		if(!$process_repassword['action']){
		  throw new Exception($process_repassword['message']);
		}
		
		// 變更使用者狀態
		$DB_UPD= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_REGISTER_USER_SET_REPASSWORD());
		$DB_UPD->bindParam(':cano'   ,$new_client_no,PDO::PARAM_INT);	
		$DB_UPD->bindParam(':account',$regist_data['regist_email'],PDO::PARAM_STR);	
		$DB_UPD->bindParam(':email'  ,$regist_data['regist_email'],PDO::PARAM_STR);	
		$DB_UPD->execute();
		
		$this->ModelResult['data']['user_account'] = $regist_data['regist_email'];
		$this->ModelResult['data']['user_ip']   = $UserIp;
		$this->ModelResult['data']['account']   = array('register_date'=>date('Y-m-d H:i:s') , 'register_from'=> $_SERVER['HTTP_REFERER'] , 'status'=>0 , 'active'=>1);
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	
	
	
	//-- Client Forgot Account Password 
	// [input] : Verification:  $_SESSION['turing_reset'] ;
	// [input] : RegistData  :  array(regist_email , user key verification);
	public function Archive_Client_Account_Forgot_Password(  $VerificationCode='' , $RegistData='' ){
	  
	  $regist_data = json_decode(base64_decode(rawurldecode($RegistData)),true);
	  
	  try{
	    
		// 檢查登入參數
		if( !isset($regist_data['regist_email'])  ||  !isset($regist_data['verification'])  ){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 檢查登入驗證碼
		if( $regist_data['verification'] != $VerificationCode ){
	      throw new Exception('_LOGIN_INFO_VERIFICATION_FALSE');
	    }
		
		// 檢查電子郵件
		if( !filter_var($regist_data['regist_email'], FILTER_VALIDATE_EMAIL) ){
	      throw new Exception('_LOGIN_INFO_REGISTER_MAIL_FALSE');
	    }
		
		// 檢查信箱是否存在
		$account_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_CHECK_REGISTER_MAIL());
		$DB_CHK->bindParam(':email'   , $regist_data['regist_email'] , PDO::PARAM_STR);	
		if( !$DB_CHK->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		if(!$account_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_REGISTER_MAIL_UNFOUND');
		}
		
		$process_repassword = self::Process_Account_Password_Setting($account_data['cano'],$account_data['account'],$account_data['email']);
		
		if(!$process_repassword['action']){
		  throw new Exception($process_repassword['message']);
		}
		
		// 變更使用者狀態
		$DB_UPD= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_SET_ACCOUNT_REPASSWORD());
		$DB_UPD->bindParam(':cano'   ,$new_client_no,PDO::PARAM_INT);	
		$DB_UPD->execute();
		$this->ModelResult['data']['user_account'] = $account_data['account'];
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	//-- Client Forgot Account Password 
	// [input] : UserIp:  ;
	// [input] : UserData  :  array();
	public function Active_NTU_Client_Repassword(  $UserIp='' , $UserData=array() ){
	  
	  
	  
	  try{
	    
		// 檢查使用者資料 : from client account signin
		if( !count($UserData)  ){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		$account_data = $UserData;
	
		// 建立註冊序號
	    $reg_code = substr(md5($account_data['account'].'#'.time()),(rand(0,3)*8),8).'.'.System_Tool::generator_password(2);  
		
		// 註冊帳號開通連結
		$DB_REG= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_REGISTER_REPASSWORD_CODE());
		$DB_REG->bindParam(':uno',$account_data['cano'],PDO::PARAM_INT);	
		$DB_REG->bindParam(':reg_code',$reg_code ,PDO::PARAM_STR);	
		$DB_REG->bindValue(':reg_state','_REGIST');
		$DB_REG->bindValue(':effect_time',date('Y-m-d H:i:s',strtotime("+1 day")));  
		
        if(! $DB_REG->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
        
		// 設定連結內容
        $user_reglink = _SYSTEM_SERVER_ADDRESS."account.php?act=repassw&refer=".$reg_code;
		
		$this->ModelResult['data']   = $user_reglink;
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	//-- Client Regist ReSet Password Process
	// [input] : AccountNo:  :  client_account.cano
    // [input] : UserAccount:  :  client_account.account 	
	// [input] : UserMail    :  client_account.mail 
	protected function Process_Account_Password_Setting( $AccountNo=0 , $UserAccount='' , $UserMail='' ){
	  
	  $func_result = array('action'=>false,'message'=>'','data'=>'');
	  
	  try{
		// 建立註冊序號
	    $reg_code = substr(md5($UserMail.'#'.time()),(rand(0,3)*8),8).'.'.System_Tool::generator_password(2);  
		
		// 註冊帳號開通連結
		$DB_REG= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_REGISTER_REPASSWORD_CODE());
		$DB_REG->bindParam(':uno',$AccountNo,PDO::PARAM_INT);	
		$DB_REG->bindParam(':reg_code',$reg_code ,PDO::PARAM_STR);	
		$DB_REG->bindValue(':reg_state','_REGIST');
		$DB_REG->bindValue(':effect_time',date('Y-m-d H:i:s',strtotime("+1 day")));  
		
        if(! $DB_REG->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
        
		// 設定信件內容
        $to_sent = $UserMail;
        $user_reglink = _SYSTEM_SERVER_ADDRESS."account.php?act=repassw&refer=".$reg_code;
		  
        $mail_content  = "<div>漢學資料庫使用者帳號開通</div>";
        $mail_content .= "<div>帳號：".$UserAccount."</div>";
        $mail_content .= "<div>啟動：<a href='".$user_reglink."' target=_blank>".$user_reglink."</a></div>";
        $mail_content .= "<div>（請利用以上連結開通帳號並設定密碼，連結將於24小時後失效）</div>";
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
          
		  $mail_to_sent = (preg_match('/.*?\s*<(.*?)>$/',$UserMail,$mail_paser)) ? trim($mail_paser[1]) : trim($UserMail);
		  if(!filter_var($mail_to_sent, FILTER_VALIDATE_EMAIL)){
		    throw new Exception('_LOGIN_INFO_REGISTER_MAIL_FALSE');
		  }
		  
		  $mail->AddAddress($mail_to_sent,'');
		  $mail->SetFrom(_SYSTEM_MAIL_ACCOUNT_USER.'@'._SYSTEM_MAIL_ACCOUNT_HOST, _SYSTEM_MAIL_FROM_NAME);
		  $mail->AddReplyTo(_SYSTEM_MAIL_ACCOUNT_USER.'@'._SYSTEM_MAIL_ACCOUNT_HOST, _SYSTEM_MAIL_FROM_NAME); // 回信位址
		  $mail->Subject = "["._SYSTEM_HTML_TITLE."]-密碼設定信件";
		  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		  $mail->MsgHTML($mail_content);
		  
		  //$mail->AddCC(); 
		  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
	      
		  if(!$mail->Send()) {
			throw new Exception($mail->ErrorInfo);  
		  } 
		  
		  $func_result['action'] = true;
		  
		} catch (phpmailerException $e) {
		    $func_result['message'] = $e->errorMessage();  //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		    $func_result['message'] = $e->errorMessage();  //echo $e->getMessage(); //Boring error messages from anything else!
		}
        
	  } catch (Exception $e) {
        $func_result['message'] = $e->getMessage();
      }
	  
	  return $func_result; 
	}
	
	
	//-- Check Account To Initial Set Password Page  // 使用者變更密碼頁面  
	// [input] : account : user account from archive server ;
	public function Initial_Client_Account_Change_Password( $Account=''){
	  
	  try{
	    // 檢查帳號
		if( !preg_match('/^[\w\d\.\@]+$/i',$Account)){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 查詢使用者帳戶
		$client_account = array();
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_GET_ACCOUNT_DATA());
		if(!$DB_OBJ->execute(array('account'=>$Account)) || !$client_account = $DB_OBJ->fetch(PDO::FETCH_ASSOC) ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_UNFOUND');  
		}
		
		$this->ModelResult['session']['cano']			= $client_account['cano'];
		$this->ModelResult['session']['account']  		= $client_account['account'];
		$this->ModelResult['session']['register_from'] 	= $client_account['register_from'];
		$this->ModelResult['session']['reg_code'] 		= $client_account['passwd'];
		$this->ModelResult['session']['request_from'] 	= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $client_account['register_from'];
		$this->ModelResult['session']['account_type']   = '_client';
		
		
		$this->ModelResult['data']['account'] 			= $client_account['account'];
		$this->ModelResult['data']['regdate']			= $client_account['register_date'];
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	//-- Archive Account Password Change 
	// [input] : SESSION  :  REGIST Code refer data => from $_SESSION
	// [input] : PassWord :  User Account Reset Password Code => urlencode(base64encode(json_pass()))  = array('change_password_old'=>'' , 'change_password_new'=>'', 'change_password_chk'=>'');;
	public function Archive_Client_Account_Change_Password( $Session=array() , $PassWord='' ){
	  
	  $change_pass = json_decode(base64_decode(rawurldecode($PassWord)),true);
	  
	  try{
	    
		
		
		// 檢查相關參數
		if(!$Session['cano'] || !$Session['account'] || !$Session['request_from'] ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');	
		}
		
		// 檢查登入密碼
		if( !isset($change_pass['change_password_old']) && !strlen($change_pass['change_password_new']) && $change_pass['change_password_new'] != $change_pass['change_password_chk'] ){
	      throw new Exception('_LOGIN_INFO_REGISTER_PASSWORD_FAIL');
	    }
		
		// 檢查帳戶密碼
		$user_password = sha1(md5($change_pass['change_password_old'].'#'._SYSTEM_NAME_SHORT).'&'.$Session['account']);
		if( $Session['reg_code'] !== $user_password   ){
		  throw new Exception('_LOGIN_INFO_ACCOUNT_PASSWORD_FAIL');
		}
		
		// 進行密碼加密
		$user_password = sha1(md5($change_pass['change_password_new'].'#'._SYSTEM_NAME_SHORT).'&'.$Session['account']);
		
		// 更新資料庫
		$DB_UPD	= $this->DBLink->prepare($this->DBSql->CLIENT_DATA_UPDATE_USER_PASSWORD());
		$DB_UPD->bindParam(':passwd'  	  , $user_password, PDO::PARAM_STR);	
		$DB_UPD->bindParam(':cano'  	  , $Session['cano'], PDO::PARAM_STR);	
		
		if( !$DB_UPD->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		$this->ModelResult['data']['from']    = $Session['request_from'];
		$this->ModelResult['data']['account'] = $Session['account'];
		$this->ModelResult['action'] = true;
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	//-- Check Register Code To Initial Repassword Page 
	// [input] : RegisterCode:  User Account Reset Password Code => from regist mail link ;
	public function Initial_Client_Account_RePassword( $RegisterCode='' ){
	  
	  try{
	    
		// 檢查登入驗證碼
		if( !preg_match('/^\w{8}\.\w{2}$/i',$RegisterCode)){
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }
		
		// 檢查啟動碼是否有效
		$regist_data = NULL;
		$DB_CHK	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_REGIST_CODE_CHECK());
		$DB_CHK->bindParam(':reg_code'   , $RegisterCode, PDO::PARAM_STR);	
		$DB_CHK->bindValue(':now'   , date('Y-m-d H:i:s'), PDO::PARAM_STR);	
		
		// 是否存在啟動碼
		if( !$DB_CHK->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// 查無啟動碼
		if( !$regist_data = $DB_CHK->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_LOGIN_INFO_REGISTER_RGCODE_FAIL');
		}
		
		// 啟動碼已經使用過 
		if( '_REGIST' != $regist_data['reg_state'] ){
		  throw new Exception('_LOGIN_INFO_REGISTER_RGCODE_USED');
		}
		
		$this->ModelResult['session']['cano'] 	  = $regist_data['uid'];
		$this->ModelResult['session']['account']  = $regist_data['account'];
		$this->ModelResult['session']['register_from'] = $regist_data['register_from'];
		$this->ModelResult['session']['reg_code'] = $RegisterCode;
		$this->ModelResult['session']['account_type']   = '_client';
		
		
		$this->ModelResult['data']['account'] = $regist_data['account'];
		$this->ModelResult['data']['regdate'] = $regist_data['register_date'];
		$this->ModelResult['action'] = true;
		
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;  
	}
	
	
	//-- Archive Account Password Reset 
	// [input] : SESSION  :  REGIST Code refer data => from $_SESSION
	// [input] : PassWord :  User Account Reset Password Code => urlencode(base64encode(json_pass()))  = array('regist_password01'=>'' , 'regist_password02'=>'');;
	public function Archive_Client_Account_Reset_Password( $Session=array() , $PassWord='' ){
	  
	  $regist_pass = json_decode(base64_decode(rawurldecode($PassWord)),true);
	  
	  try{
	    
		// 檢查相關參數
		if(!$Session['cano'] || !$Session['account'] || !$Session['reg_code'] ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');	
		}
		
		// 檢查輸入的密碼
		if( !isset($regist_pass['regist_password01']) && !strlen($regist_pass['regist_password01']) && $regist_pass['regist_password01'] != $regist_pass['regist_password02'] ){
	      throw new Exception('_LOGIN_INFO_REGISTER_PASSWORD_FAIL');
	    }
		
		// 進行密碼加密
		$user_password = sha1(md5($regist_pass['regist_password01'].'#'._SYSTEM_NAME_SHORT).'&'.$Session['account']);
		
		// 更新資料庫
		$DB_UPD	= $this->DBLink->prepare($this->DBSql->CLIENT_LOGIN_ACCOUNT_START());
		$DB_UPD->bindParam(':passwd'  	  , $user_password, PDO::PARAM_STR);	
		$DB_UPD->bindValue(':status'   	  , 5 , PDO::PARAM_INT);	
		$DB_UPD->bindValue(':reg_state'   , '_ACTIVE', PDO::PARAM_STR);	
		$DB_UPD->bindValue(':actie_time'  , date('Y-m-d H:i:s'));
        $DB_UPD->bindValue(':reg_code'    , $Session['reg_code']);
        $DB_UPD->bindValue(':uid'		  , $Session['cano']);
        $DB_UPD->bindValue(':now'   	  , date('Y-m-d H:i:s'));	
        		
		if( !$DB_UPD->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		$this->ModelResult['data']['from']    = $Session['register_from'];
		$this->ModelResult['data']['account'] = $Session['account'];
		$this->ModelResult['action'] = true;
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
  }
?>