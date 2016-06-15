<?php
 /*
  *   Admin Products SQL SET
  *  
  *
  */
  
  /* [ System Execute function Set ] */ 	
  
  class SQL_AdProduct{

    /***-- Admin Product Function --***/
	
	//-- Admin Product : Get Product List
	public static function ADMIN_PRODUCT_SELECT_META_LANG_SET(){
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
	
	//-- Admin Product : Set Product Order
	public static function ADMIN_PRODUCT_SET_PRODUCTS_ORDER(){
	  $SQL_String = "UPDATE products SET view_order=:order WHERE pid=:pid; ";
	  return $SQL_String;
	}
	
	//-- Admin Product : Get Product Lang Meta
	public static function ADMIN_PRODUCT_SELECT_PRODUCT_META($Table=NULL){
	  $SQL_String = "SELECT * FROM ".$Table." WHERE pno=:pno;";
	  return $SQL_String;
	}
	
	
	//-- Admin Product : Insert Products Table
	public static function ADMIN_PRODUCT_CREATC_NEW_PRODUCT(){
	  $SQL_String = "INSERT INTO products VALUES(NULL,'',:client,:view_order,:view_index,NULL,:_view,1); ";
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
	  $SQL_String = "SELECT att_no,acc_name,file_size,time_upload FROM product_obj WHERE pno =:pno AND file_keep=1 ORDER BY display_order ASC,att_no ASC";
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
	
	//-- Admin Product : Update attachment data order
	public static function ADMIN_PRODUCT_RESORT_ATTACHMENT(){
	  $SQL_String = "UPDATE product_obj SET display_order=:order WHERE att_no=:att_no AND pno=:pno;";
	  return $SQL_String;
	}
	
  }	
  
?>  