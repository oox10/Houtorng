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
	
	
  }	
  
?>  