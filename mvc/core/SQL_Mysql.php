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
	  $SQL_String = "SELECT * FROM products LEFT JOIN ".$lang." ON pid=pno WHERE products._keep=1 AND products._view=1 ORDER BY view_order ASC,pid ASC;";
	  return $SQL_String;
	}
	
	
	//-- Web Site Index : Get Product Image
	public static function WEBSITE_GET_PRODUCT_OBJECT(){
	  $SQL_String = "SELECT * FROM product_obj WHERE pno=:pid AND file_keep=1 ORDER BY display_order ASC ,att_no ASC;";
	  return $SQL_String;
	}
	
	//-- Web Site Contact : Save Contact Message
	public static function WEBSITE_SAVE_CONTACT_MESSAGE(){
	  $SQL_String = "INSERT INTO message VALUES(NULL,NULL,:user_ip,:user_mail,:content,'',0,0,1,'');";
	  return $SQL_String;
	}
	
	
	//-- Web Site Contact : Get Business List
	public static function WEBSITE_BUSINESS_GET_BUSINESS_LIST(){
	  $SQL_String = "SELECT * FROM business WHERE _keep=1 AND _show=1 ORDER BY showOrder ASC,bid ASC; ";
	  return $SQL_String;
	}
	
	
	
	
	
  }

?>