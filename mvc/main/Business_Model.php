<?php

  class Business_Model extends Admin_Model{
    
	/***--  Function Set --***/
    public function __construct(){
	  parent::__construct();
	}
	
	
	/*[ Business Function Set ]*/ 
	
	//-- Admin Business Page Initial
	// [input] : NULL;
	public function ADProduct_Get_Business_List(){
	  $result_key = parent::Initial_Result('business');
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare(SQL_AdBusiness::ADMIN_BUSINESS_SELECT_ALL_BUSINESS());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// GET資料
		$business_list = array();
		
		while($tmp = $DB_OBJ->fetch(PDO::FETCH_ASSOC)){
		  if(!isset($business_list[$tmp['pdgroup']])){
		    $business_list[$tmp['pdgroup']] = array();
		  }
		  $business_list[$tmp['pdgroup']][] = $tmp; 
		}
	    
		$result['action'] = true;		
		$result['data']   = $business_list;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $result;
	}
  
  }	
  
?>