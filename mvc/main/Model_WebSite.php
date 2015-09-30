<?php

  class Model_WebSite extends Model_Main{
    
	
	/***--  Function Set --***/
    
	
	/*[ Web Site Function Set ]*/ 
	
	//-- WebSite Page Initial 
	// [input] : NULL;
	public function WebSite_Get_Product_List($Lang='meta_cht',$TargetProduct=''){
	  
	  $product_search = strlen(trim($TargetProduct)) > 3 ? rawurldecode(trim($TargetProduct)) : false; 
	  
	  try{
	  
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->WEBSITE_INDEX_GET_PRODUCT_LISR($Lang));
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得產品資料
		$product_list = array();
		$product_list = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	   
	    // 取得產品類別&資料
		$product_class = array(); 
		$product_target= ''; 
	    $product_result = array();
		foreach($product_list as &$product){
		  // Get Product Images
		  $product['images'] = array();
		  $DB_OBJ = $this->DBLink->prepare($this->DBSql->WEBSITE_GET_PRODUCT_OBJECT());
		  if($DB_OBJ->execute(array('pid'=>$product['pid']))){
		    $product['images'] = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);
		  }
		
		  $ptype = $product['title_type'] ? $product['title_type'] : $product['title_product'];
		  if(!isset($product_class[$ptype])){
			$product_class[$ptype] = array();  
		  }
		  $product_class[$ptype][] = $product['title_product'];
		  
		  if($product_search){
		    if(in_array($product_search,$product)){
			  $product_target = $product['title_product'];
			  $product_result = &$product;
		    }   
		  }
		}
		
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']['product']   = array_slice($product_list,0,10);		
	    $this->ModelResult['data']['classlv']   = $product_class;	
        $this->ModelResult['data']['target']    = $product_target;
		$this->ModelResult['data']['result']    = $product_result;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  
	  return $this->ModelResult;
	  
	}
	
  }
?>