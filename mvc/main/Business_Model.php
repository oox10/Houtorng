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
        $result['message'][] = $e->getMessage();
      }
	  return $result;
	}
	
	
	
	//-- Admin Product Save Product Data 
	// [input] : DataRecord  :  urlencode(base64encodeM(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	
	public function ADBusiness_Save_Record_Data($DataRecord=''){
	  
	  $result_key = parent::Initial_Result('save');
	  $result  = &$this->ModelResult[$result_key];
	  
	  $data_record = json_decode(base64_decode(str_replace('*','/',rawurldecode($DataRecord))),true);
	  try{  
		
		// 檢查資料序號
	    if(!preg_match('/^\d+$/',$data_record['bid']) && $data_record['bid']!='_addnew'  ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		if($data_record['bid']=='_addnew'){
		  $DB_NEWA	= $this->DBLink->prepare(SQL_AdBusiness::ADMIN_BUSINESS_INSERT_NEW_BUSINESS());
		  $DB_NEWA->BindValue(':pdgroup'	, $data_record['pdgroup'] );
		  $DB_NEWA->BindValue(':company'	, $data_record['company'] );
		  $DB_NEWA->BindValue(':location'	, $data_record['location'] );
		  $DB_NEWA->BindValue(':product_type',$data_record['product_type'] );
		  $DB_NEWA->BindValue(':output'		, $data_record['output'] );
		  $DB_NEWA->BindValue(':sellCount'	, $data_record['sellCount'] );
		  $DB_NEWA->BindValue(':useTo'		, $data_record['useTo'] );
		  if( !$DB_NEWA->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  } 
		  $bid   = $this->DBLink->lastInsertId('business');
		  
		}else{
		  $DB_SAVE	= $this->DBLink->prepare(SQL_AdBusiness::ADMIN_BUSINESS_SAVE_RECORD_BUSINESS());
		  $DB_SAVE->BindValue(':company'	, $data_record['company'] );
		  $DB_SAVE->BindValue(':location'	, $data_record['location'] );
		  $DB_SAVE->BindValue(':product_type',$data_record['product_type'] );
		  $DB_SAVE->BindValue(':output'		, $data_record['output'] );
		  $DB_SAVE->BindValue(':sellCount'	, $data_record['sellCount'] );
		  $DB_SAVE->BindValue(':useTo'		, $data_record['useTo'] );
		  $DB_SAVE->BindValue(':bid'		, $data_record['bid'] );
		  
		  $bid   = $data_record['bid'];
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  }
		}
		
		// final 
		$result['data'] = $bid;
		$result['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	
	//-- Admin Product Delete  Data 
	// [input] : DataNo  :  \d+;
	public function ADBusiness_Delete_Record_Data($DataNo=0){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{  
		
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$DataNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		$DB_DELE	= $this->DBLink->prepare(SQL_AdBusiness::ADMIN_BUSINESS_DELETE_RECORD_BUSINESS());
		$DB_DELE->bindParam(':bid'      , $DataNo , PDO::PARAM_INT);
		if( !$DB_DELE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		$result['action'] = true;
		sleep(1);
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	
	
	
  
  }	
  
?>