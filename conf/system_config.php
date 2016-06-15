<?php
  /*******************************************
    RCDH 10 RCDH System Config File
    
	定義各項系統變數
	
  ********************************************/
  
  
  //-- 載入伺服器變數
  require_once "server_config.php";
  
  
  /***--  HTML 設定檔  --***/
  define('_SYSTEM_SERVER_ADDRESS','http://admin.houtorng.oo10.co/');      // 系統網址
  define('_SYSTEM_HTML_TITLE','厚彤官網管理系統');
  define('_SYSTEM_NAME_SHORT','Houtorng');
  define('_SYSTEM_PUBLISH_VERSION','v2.0.160615');
  
  /***--  PHP 設定檔  --***/
  date_default_timezone_set('Asia/Taipei');
  mb_internal_encoding('UTF-8');
  mb_regex_encoding('UTF-8');
  //define('PATH_SEPARATOR',';');
  

  /***-- FILE LOCATION 設定檔  --***/
  define('SSYS_REAL_PATH','.');
  
  //-- 相關檔案預設路徑
  define("_SYSTEM_ROOT_PATH",dirname(dirname(__FILE__)).'/');
  define("_SYSTEM_FILE_PATH",dirname(dirname(__FILE__)).'/docs/');
  define("_SYSTEM_IMAGE_PATH",dirname(dirname(__FILE__)).'/webroot/');
  define("_SYSTEM_ADIMAGE_PATH",dirname(dirname(__FILE__)).'/webroot-admin/');
  define("_SYSTEM_UPLD_PATH",dirname(dirname(__FILE__)).'/systemUpload/'); 
  
  
  
  
  
  define("_SYSTEM_IP_BEN_LIST_LOGS",_SYSTEM_ROOT_PATH.'logs/IPBanList.log');
   
  
  /***-- FTP Server 設定檔  --***/
  define("_SYSTEM_FTPS_MODEL",'proftpd');
  define("_SYSTEM_FTPS_PATH",'/var/FTP/');
  
  
  
  /***-- CONCAT 設定檔  --***/
  define("_SYSTEM_CONTACT_ORGAN",'君璞實業');
  define("_SYSTEM_CONTACT_USER" ,'10');
  define("_SYSTEM_CONTACT_MAIL" ,'oos0.0y@gmail.com');
  define("_SYSTEM_CONTACT_TEL"  ,'0919');
  
  
  /***-- DATA 設定檔  --***/
  
  //-- 定議服務伺服器 IP
  define('_SYSTEM_SERVICES_IP_LIST' , json_encode(
    array(
	  '127.0.0.1' 		=> '本機電腦',
	  '140.112.114.183' => 'Developer' 
	)
  ));
  
  define('_SYSTEM_LOGIN_PW_SEED','@hout');
  
  //------------------------------------------------- ReCaptcha Settings -------------------------------------------------
  define('ENABLE_CAPTCHA', false);
  
  
  
  
  //to generate the public and the private keys go here: https://www.google.com/recaptcha/admin/list
  $captcha_public_key = "your_public_key";
  $captcha_private_key = "your_private_key";
  
  
   /***-- ACCOUNT 設定檔 --***/
  
  define("_SYSTEM_MEMBER_PROFILE_PATH"	, _SYSTEM_ROOT_PATH.'userProfile/Member/');
  define("_SYSTEM_GUEST_PROFILE_PATH"	, _SYSTEM_ROOT_PATH.'userProfile/Guesr/');
  
  
  define('_SYSTEM_LOGIN_ID_HEADER','HOU');
  define('_SYSTEM_LOGIN_ID_LENGTH',7);
  
  
  
  
  
?>