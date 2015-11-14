<?php
  /*******************************************
    RCDH 10 RCDH Server Config File
    
	定義個別伺服器參數
	
  ********************************************/
  
  
  /***--  DB 設定檔  --***/
  
  //-- MySQL 設定檔
  define('_SYSTME_DB_NAME','houtorng_db');
  define('_SYSTEM_DB_USER','root');
  define('_SYSTEM_DB_PASS','root');
  define('_SYSTEM_DB_LOCA','localhost');
  
  
  
  /***--  Mail 信件發送伺服器設定  --***/
  
  //-- NTU Mail Server
  define('_SYSTEM_MAIL_CONTACT','houtrung@ms58.hinet.net');
  define('_SYSTEM_MAIL_SSL_ACTIVE',true);
  define('_SYSTEM_MAIL_HOST','smtp.gmail.com');
  define('_SYSTEM_MAIL_SECURE','ssl');    // tls: drnh tpa  |  ssl : google / ntu
  define('_SYSTEM_MAIL_PORT',465);        // 465  : google or ntu  587 : tpa drnh
  define('_SYSTEM_MAIL_ACCOUNT_USER','houtorng.tw@gmail.com');
  define('_SYSTEM_MAIL_ACCOUNT_PASS','houtorng_j;3504@site');
  define('_SYSTEM_MAIL_ACCOUNT_HOST','');
  define('_SYSTEM_MAIL_FROM_NAME','厚彤有限公司');
  
  
  
?>  