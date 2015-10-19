<?php
  /*******************************************
    RCDH 10 RCDH System Config File
    
	定義各項系統變數
	
  ********************************************/
  
  
  //-- 載入伺服器變數
  require_once "server_config.php";
  
  
  /***--  HTML 設定檔  --***/
  define('_SYSTEM_SERVER_ADDRESS','http://140.112.114.183/Houtorng/webroot/');      // 系統網址
  define('_SYSTEM_HTML_TITLE','Houtorng');
  define('_SYSTEM_NAME_SHORT','HAMAD');
  
  
  
  
  /***--  PHP 設定檔  --***/
  date_default_timezone_set('Asia/Taipei');
  mb_internal_encoding('UTF-8');
  mb_regex_encoding('UTF-8');
  define('PATH_SEPARATOR',';');
  
  
 
  /***-- FILE LOCATION 設定檔  --***/
  define('SSYS_REAL_PATH','.');
  
  //-- 相關檔案預設路徑
  define("_SYSTEM_ROOT_PATH",dirname(dirname(__FILE__)).'/');
  define("_SYSTEM_FILE_PATH",dirname(dirname(__FILE__)).'/docs/');
  define("_SYSTEM_IMAGE_PATH",dirname(dirname(__FILE__)).'/webroot/');
  define("_SYSTEM_ADIMAGE_PATH",dirname(dirname(__FILE__)).'/webroot-admin/');
  define("_SYSTEM_IP_BEN_LIST_LOGS",_SYSTEM_ROOT_PATH.'logs/IPBanList.log');
  define("_SYSTEM_UPLOAD_TEMP_FOLDER",_SYSTEM_ROOT_PATH.'webroot-admin/tool/jQuery-File-Upload-9.3.0/server/php/files/');   // 資源暫存區域 
   
  
  
  
  /***-- DATA 設定檔  --***/
  
  //-- 定議服務伺服器 IP
  define('_SYSTEM_SERVICES_IP_LIST' , json_encode(
    array(
	  '127.0.0.1' 		=> '本機電腦',
	  '140.112.114.183' => 'Developer' 
	)
  ));
  
  //------------------------------------------------- ReCaptcha Settings -------------------------------------------------
  define('ENABLE_CAPTCHA', false);
  //to generate the public and the private keys go here: https://www.google.com/recaptcha/admin/list
  $captcha_public_key = "your_public_key";
  $captcha_private_key = "your_private_key";
  
  
  
?>