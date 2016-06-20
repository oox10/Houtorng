<?php
 /*
  *   Admin Business SQL SET
  *  
  *
  */
  
  /* [ System Execute function Set ] */ 	
  
  class SQL_AdBusiness{

    /***-- Admin Business Function --***/
	
	//-- Admin Business : Get Business List
	public static function ADMIN_BUSINESS_SELECT_ALL_BUSINESS(){
	  $SQL_String = "SELECT * FROM business WHERE _keep=1 ORDER BY showOrder ASC,bid ASC; ";
	  return $SQL_String;
	}
	
	
	//-- Admin Business : New Business Record
	public static function ADMIN_BUSINESS_INSERT_NEW_BUSINESS(){
	  $SQL_String = "INSERT INTO business VALUES(NULL,:pdgroup,:company,:location,:product_type,:output,:sellCount,:useTo,10,NULL,1,1); ";
	  return $SQL_String;
	}
	
	//-- Admin Business : Save Business Record
	public static function ADMIN_BUSINESS_SAVE_RECORD_BUSINESS(){
	  $SQL_String = "UPDATE business SET company=:company , location=:location , product_type=:product_type , output=:output ,sellCount=:sellCount, useTo=:useTo  WHERE bid=:bid AND _keep=1; ";
	  return $SQL_String;
	}
	
	
	//-- Admin Business : Save Business Record
	public static function ADMIN_BUSINESS_DELETE_RECORD_BUSINESS(){
	  $SQL_String = "UPDATE business SET _keep=0  WHERE bid=:bid";
	  return $SQL_String;
	}
	
	
  }	
  
?>  