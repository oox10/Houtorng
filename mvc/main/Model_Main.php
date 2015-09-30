<?php
  class Model_Main extends DBModule{
    
	
	/***--  Initial  --***/
	
	public	$ModelResult 	= array();  //save model result data 
	
	public function __construct(){
	  $this->db_connect();
	  $this->ModelResult    = array('action'=>false,'data'=>array(),'message'=>array());
	}
	
	public function __destruct(){
      $this->DBLink 	= NULL;
	}
	
	
	/******************************************
	  系統訊息輸出
	    參數   
		  1. $Message_Code  訊息代號
		  2. $Lang_Code     語言代號
	******************************************/

	public function Message_Translate($Message_Code=NULL,$Lang_Code='cht'){
	  
	  $INFO_MESSAGE_MAP = array();
	  $InfoSet = array();
	  if($Message_Code){
	    $ConfigFile = _SYSTEM_ROOT_PATH.'conf/info_'.$Lang_Code.'.conf'; 
	    if(is_file($ConfigFile)){
	     
		  //載入訊息設定檔
		  $conf_handle = @fopen($ConfigFile,'r');
	      if ($conf_handle) {
            while (($buffer = fgets($conf_handle)) !== false) {
			  
			  $Message_Map_String = trim($buffer);
			  
			  if(!preg_match('/^(#|\[)/',$Message_Map_String) && strlen($Message_Map_String)){

				list($mcode,$mlang) = explode('=',$Message_Map_String) ;
			    if(isset($mcode) && isset($mlang)){
				  $INFO_MESSAGE_MAP[trim($mcode)] = trim($mlang); 
				}
			  }
		    }
            if (!feof($conf_handle)) {
              return "WORRING: unexpected fgets() fail";
			}
            fclose($conf_handle);	  
		    return isset($INFO_MESSAGE_MAP[$Message_Code]) ? $INFO_MESSAGE_MAP[$Message_Code] : "WORRING:".$Message_Code." undefine.";
		  }
	    }else{
	      return "WORRING:Can not open info.".$Lang_Code.".conf.";
		}
	  }else{
	    return null;
	  }
	  
	}
	
	
	//-- 回傳系統訊息
	public function Get_Action_Message($message_code=''){
	  if($message_code){
	    return self::Message_Translate($message_code,$Lang_Code='cht');
	  }else{
	    $msg_return = array();
		if( isset($this->ModelResult['message']) && is_array($this->ModelResult['message']) ){
		  foreach($this->ModelResult['message'] as $message_code){
		    $msg_return[] = self::Message_Translate($message_code,$Lang_Code='cht');
		  }
		  return join(',',$msg_return);
		}else{
		  return null;
		}
	  } 
	}
	
	
	/******************************************
	  檢查傳送資料 $_POST $_GET $_SESSION $_SYSTEM ...
 	    
		參數   
		  1. $Page = index query result ap 等頁面
		  2. $Type = acc_code page_code obj_code .... 
		  3. $TargetString 
		回傳
		  true / false
		  
        提醒 
		  
	******************************************/
	public function Check_Pass_Data($Page , $Type , $TargetString=''){
	  
	  $check_info = array();
	  $check_pattern = '';
	  
	  
	  
	  switch($Page){
	    case 'system':
		  switch($Type){
		    case 'usr_id'  : $check_pattern="/^[\w\d_@\.\-]{2,}$/"; break;
			case 'usr_sysid'  : $check_pattern='/^'._SYSTEM_LOGIN_ID_HEADER.'\d{'._SYSTEM_LOGIN_ID_LENGTH.'}$/'; break;
			case 'guest_id': $check_pattern="/^"._SYSTEM_LOGIN_ID_HEADER."\d{"._SYSTEM_LOGIN_ID_LENGTH."}$/"; break;
		  }
		
		case 'index':  
		  switch($Type){
			case 'oakey'      : $check_pattern='/^[\w\d]{8,8}$/' ;break;
		  }
		  break; 
		
		case 'query':  
		  switch($Type){
			case 'level_id'   : $check_pattern='/^'._SYSTEM_LEVEL_CODE_HEAD.'[A-Z\d]+$/' ;break;
		  }
		  break;
		  
		case 'result': 
		  
		  switch($Type){
		    case 'obj_code':  $check_pattern='/^\d+[a-zA-Z\_\-0-9]{5,5}$/'; break;
		  }
		  break;
		
		case 'display':
		  switch($Type){
		    case 'meta_id'	  : $check_pattern='/^\d+$/' ;break;
			case 'book_id'	  : $check_pattern='/^[\d\w\-\/]{3,}$/' ;break;
		  }
		  break;
		  
		
		case 'application':  
		
		  switch($Type){
		    case 'usr_sysid'  : $check_pattern='/^'._SYSTEM_LOGIN_ID_HEADER.'\d{'._SYSTEM_LOGIN_ID_LENGTH.'}$/'; break;
		    case 'object_seed': $check_pattern='/^[\w\d_\-]{32,32}$/';break;
		    case 'object_id'  : $check_pattern=_SYSTEM_STORENO_ID_CHECKER;break;
			case 'level_id'   : $check_pattern='/^'._SYSTEM_LEVEL_CODE_HEAD.'[A-Z\d]+$/' ;break;
		    case 'store_no'	  : $check_pattern='/^[\d\-]+$/' ;break;
			case 'reg_code'	  : $check_pattern='/^[\w\d]{8}$/';break;
			case 'info_id'	  : $check_pattern='/^\d+$/';break;
			case 'book_id'	  : $check_pattern='/^[\d\w\-]{3,}$/' ;break;
		  }
		  break;
		case 'admin':
		  
		  switch($Type){
		    case 'usr_id'     : $check_pattern='/^[\w\d\.\_\@\-]+$/'; break;
			case 'usr_no'     : $check_pattern='/^\d+$/'; break;
		    case 'reg_code'   : $check_pattern='/^[\w\d]{10}$/'; break;
			case 'object_seed': $check_pattern='/^[\w\d_\-]{32,32}$/';break;
		    case 'object_id'  : $check_pattern=_SYSTEM_STORENO_ID_CHECKER;break;
			case 'level_id'   : $check_pattern='/^'._SYSTEM_LEVEL_CODE_HEAD.'[\w\d]+$/' ;break;
			case 'group_id'	  : $check_pattern='/^(\d+|new)$/'; break;
			case 'rule_id'	  : $check_pattern='/^(\d+|new)$/'; break;
			case 'login_key'  : $check_pattern='/^[\d\w]{8}\-\d$/'; break;
			case 'meta_id'    : $check_pattern=_SYSTEM_META_SYSTEM_ID_FORMAT; break;
			case 'report_id'  : $check_pattern='/^\d+$/'; break;
			case 'log_no' 	  : $check_pattern='/^\d+$/'; break;
			case 'mesg_type'  : $check_pattern='/^(now|old|all)$/'; break;
			case 'mesg_id'    : $check_pattern='/^(\d+|new)$/'; break;
			case 'upfile_id'  : $check_pattern='/^\d+$/'; break;
			case 'upfile_imgfolder'  : $check_pattern='/^\d{3}-\d{2}-\d{2}(IA|EA|OA)$/'; break;
			case 'cata_id' 	  : $check_pattern='/^\d{3}\w-\d{2}-\d{2}$/'; break;
			case 'cata_meta_id': $check_pattern='/^\d+$/'; break;
			case 'book_id' 	  : $check_pattern='/^[\d\w\-]{3,}$/'; break;
			case 'meta_no' 	  : $check_pattern='/^\d+$/'; break;
			case 'mark_id' 	  : $check_pattern='/^mark_\d+$/'; break;
			case 'page_ser'	  : $check_pattern='/^\d+\.(jpg|png|tiff)$/'; break;
			// ad post
			case 'post_no'	  : $check_pattern='/^\d+$/'; break;
			case 'post_list'  : $check_pattern='/#(all|post|overdue|delete)$/'; break;
			// ad feedback
			case 'feedback_no'	  : $check_pattern='/^\d+$/'; break;
			case 'feedback_list'  : $check_pattern='/#(all|post|overdue|delete)$/'; break;
			// ad work
			case 'work_id'	  : $check_pattern='/^\d+$/'; break;
			case 'work_status': $check_pattern='/^(complete|stop|queue)$/'; break;
			// ad fileserver
			case 'set_no'     : $check_pattern='/^\d\d\d\w$/'; break;
			
			
		  }
		  break;
	  }
	  return strlen($TargetString) && preg_match($check_pattern,$TargetString) ? true : false ;
	  
	}
	
	
	/******************************************
	  取得 metadata 設定
		參數   
		  1. $UiLanguage   顯示語言
		回傳
		  $MetaConfig
        提醒
          $this->MetaConf 定義於一開始
		  
	******************************************/
	public function Get_Meta_Setting($UiLanguage = 'cht'){
	  $MetaConfig = array();
	  if(defined('_SYSTEM_META_CONFIG')){
	  
	    $MetaConfig = json_decode(_SYSTEM_META_CONFIG,true);
	    foreach( $MetaConfig  as $MetaFieldCode => $MetaFieldSet){
		  $MetaConfig[$MetaFieldCode]['DisplayValue'] = self::Message_Translate('_SYSTEM_FIELD_'.$MetaFieldSet['FieldName'],$UiLanguage); 
	    }
	  }
	  return $MetaConfig;
	}
	
	//呈獻資料縮短
	public function Shorten_Text($term,$length){
	  $CleanTerm = preg_replace('@<.*?>@','',$term);
	  if(mb_strlen($CleanTerm)>$length){
	    $text1=mb_substr($CleanTerm,0,$length);
	    $printout="<ins title=\"".$CleanTerm."\" >".$text1."..</ins>";
	  }else{
	    $printout=$CleanTerm;
	  }
	  return $printout;
    }
	
	//呈獻訊息縮短
	public function Shorten_Info($term,$length){
	  $term = strip_tags($term);
	  $CleanTerm = preg_replace('@<.*?>@','',$term);
	  if(mb_strlen($CleanTerm)>$length){
	    $text1=mb_substr($CleanTerm,0,$length);
	    $printout=$text1."..";
	  }else{
	    $printout=$CleanTerm;
	  }
	  return $printout;
    }
	
	
	
	
	public function System_Logs($actionMessage='',$mode = 'w'){
	  
	  switch($mode){
	    case 'w':
		  $fp = fopen(_SYSTEM_ADMIN_LOGS, 'a');
	      if($actionMessage){
	        fwrite($fp, "\t".$actionMessage); 
	      }else{
	        fwrite($fp, "\n".date('Y-m-d H:i:s')."\t[".$this->UserIP."]"."\t".$this->UserID);
	      }
		  fclose($fp);
	    break;
	    
		case 'r':
		  $system_logs = array();
		  $fp = fopen(_SYSTEM_ADMIN_LOGS, 'r');
		  if ($fp) {
            while (($buffer = fgets($fp)) !== false) {
			  if(trim($buffer)){
			    $system_logs[] = trim($buffer);
			  }
            }
		  }
		  fclose($fp);
	      
		  return array_reverse($system_logs); 
		  break;
	  }  
	}
	
	
	
	
	//-- System Action Used Logs
	public function System_Logs_Used_Action($ControlerAction=''){
	  $DB_OBJ = $this->DBLink->prepare( $this->DBSql->SYSTEM_LOGS_USED_ACTION() );
	  $DB_OBJ->bindValue(':acc_ip' ,	System_Tool::get_client_ip());
	  $DB_OBJ->bindValue(':acc_act',	$ControlerAction);
	  $DB_OBJ->bindValue(':acc_url',	$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	  $DB_OBJ->bindValue(':request',	isset($_REQUEST) ? serialize($_REQUEST) : '');
	  $DB_OBJ->bindValue(':acc_from',	isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']:'' );
	  $DB_OBJ->bindValue(':result',		isset($this->ModelResult) ? serialize($this->ModelResult) : '');
	  $DB_OBJ->bindValue(':agent',	    isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']:'');
	  $DB_OBJ->execute();
	}
	
  }
  
?>