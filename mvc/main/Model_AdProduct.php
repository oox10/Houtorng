<?php

  class Model_AdProduct extends Model_Main{
    
	/***--  Function Set --***/
    
	
	/*[ Product Function Set ]*/ 
	

	//-- Admin Product Page Initial -1  
	public function ADSell_Get_Product_Language_Set(){
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_SELL_SELECT_PRODUCT_LANG_SET());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得語言資料欄位
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']   = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;
	}
	
	
	
	
	//-- Admin Product Page Initial -2
	// [input] : NULL;
	public function ADSell_Get_Product_List(){
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_SELECT_ALL_PRODUCTS());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得客戶資料
		$customers_list = array();
		$customers_list = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	    
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']   = $customers_list;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;
	}
	
	
	
	//-- Admin Product Re Sort Product Display Order 
	// [input] : ProductOrder   :  attnolist - \d+,\d+,\d+,...
	// [input] : UserID         :  user login no from SESSION 
	public function ADProduct_ReSort_Products( $ProductNoOrder = '' , $UserID=0 ){
	  
	  try{
		
		$pdo_list = explode(',',$ProductNoOrder);
		
		// 檢查
	    if( count($pdo_list)<=1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_SET_PRODUCTS_ORDER());
		
		foreach($pdo_list as $key=>$pid){
		  $DB_SAVE->bindValue(':order'	, ($key+1));
		  $DB_SAVE->bindValue(':pid'	, $pid);
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  }
		}
		// final 
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
	//-- Admin Product Get Target Data
	// [input] : jobcode  :  md5 string;
	public function ADProduct_Get_Target_Product($TargetId='',$LangSet=array('meta_cht')){
	  $this->ModelResult['data'] = array();	
	  try{
		// 檢查工作序號
	    if( !intval($TargetId) ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
		
		// 查詢產品資料
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_SELECT_ONE_PRODUCT());
		if(!$DB_OBJ->execute(array('pno'=>$TargetId))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}
		
		if(!$data = $DB_OBJ->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
		$this->ModelResult['data']['products'] = $data;
		
		// 查詢產品各語言詮釋資料
		foreach($LangSet as $lang){
		  $DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_SELECT_PRODUCT_META($lang));	 
		  if($DB_OBJ->execute(array('pno'=>$data['pid']))){
			$this->ModelResult['data'][$lang]  = $DB_OBJ->fetch(PDO::FETCH_ASSOC);
		  }
		}
		$this->ModelResult['action'] = true;
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;
	}
	
	
	//-- Admin Product Create New Product 
	// [input] : DataCreate  :   urlencode(base64encode(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	public function ADProduct_Newa_Product_Data($DataCreate=''){
	    
	  $data_newa = json_decode(base64_decode(rawurldecode($DataCreate)),true);
	  
	  try{  
		
		// 檢查必備資料
		if( count($DataCreate) > 1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
		
		$DB_INSERT  = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_CREATC_NEW_PRODUCT());
		$DB_INSERT->bindValue(':client'  	, isset($data_newa['products']['client']) ?  trim($data_newa['products']['client']) : '');
		$DB_INSERT->bindValue(':view_order'	, isset($data_newa['products']['view_order']) ?  intval($data_newa['products']['view_order']) : 99 );
		$DB_INSERT->bindValue(':view_index' , isset($data_newa['products']['view_index']) ?  intval($data_newa['products']['view_index'])  : 0 );
		$DB_INSERT->bindValue(':_view'		, isset($data_newa['products']['_view'])  ? intval($data_newa['products']['_view'])  : 1 );
		
		if( !$DB_INSERT->execute() ){
		  throw new Exception('_SYSTEM_ERROR_DB_UPDATE_FAIL');
		}
		
		$new_data_no  = $this->DBLink->lastInsertId('products');
		unset($data_newa['products']);
		
		if(count($data_newa)){
		  foreach($data_newa as $table => $data){
			$DB_INSERT	= $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_INSERT_PRODUCT_META_BY_LANG($table));    
			$DB_INSERT->bindValue(':pno' 		, $new_data_no);
		    $DB_INSERT->bindValue(':title_type'	, isset($data['title_type']) ?  strtolower($data['title_type']) : '');
		    $DB_INSERT->bindValue(':title_product', isset($data['title_product']) ?  strtolower($data['title_product'])  : '' );
		    $DB_INSERT->bindValue(':design'		, isset($data['design']) ? strtolower(preg_replace('/(\r\n)+/','',$data['design']))  : '' );
		    $DB_INSERT->bindValue(':useto'		, isset($data['useto']) ? strtolower(preg_replace('/(\r\n)+/','',$data['useto']))  : '' );
			$DB_INSERT->bindValue(':specification'	, isset($data['specification']) ? $data['specification'] : '' );
			$DB_INSERT->bindValue(':page_url'	, isset($data['page_url']) ? $data['page_url'] : '' );
			$DB_INSERT->bindValue(':editer'		, isset($_SESSION['USER_ID']) ?  $_SESSION['USER_ID']  : '' );
			$DB_INSERT->execute();
		  }
		}
		
		// final 
		$this->ModelResult['data'] = $new_data_no;
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
		
    //-- Admin Product Save Product Data 
	// [input] : DataNo      :  \d+  = DB.tasks_plan.pno;
	// [input] : DataModify  :  urlencode(base64encode(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	
	public function ADProduct_Save_Product_Data($DataNo=0 , $DataModify=''){
	  
	  $data_modify = json_decode(base64_decode(rawurldecode($DataModify)),true);
	  
	  try{  
		
		// 檢查資料序號
	    if(!preg_match('/^\d+$/',$DataNo)  || !is_array($data_modify)  ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 檢查更新內容
		if( !count($data_modify) ){
		  throw new Exception('_SYSTEM_ERROR_DB_UPDATE_NULL');
		}
		
		// 執行更新
		foreach($data_modify as $table => $mdata){  
		  if(count( $mdata)){
		    $DB_SAVE	= $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_UPDATE_PRODUCT_DATA($table,array_keys($mdata)));
		    $DB_SAVE->bindValue(':pno' , $DataNo);
		    foreach($mdata as $mf => $mv){
		      $DB_SAVE->bindValue(':'.$mf , $mv);
		    }
		    if( !$DB_SAVE->execute()){
		      throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		    }
		  }
		}
		
		// final 
		$this->ModelResult['data'] = $DataNo;
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	
	//-- Admin Product Get Display Files (image or video or ..) 
	// [input] : product_id  :  \d+;
	public function ADProduct_Get_Product_Relative_FL($Pid=''){
	  
	  try{  
		// 檢查訂單序號
	    if(!preg_match('/^\d+$/',$Pid)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 取得檔案列表
		$DB_GET	= $this->DBLink->prepare( $this->DBSql->ADMIN_PRODUCT_SELECT_PRODUCT_DISPLAY() );
		$DB_GET->bindValue(':pno',$Pid);	
		
		if( !$DB_GET->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
	    $object_list = $DB_GET->fetchAll(PDO::FETCH_ASSOC);
		$this->ModelResult['data']   = $object_list;
		$this->ModelResult['action'] = true;
  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	//-- Admin Product - Upload Product Relate Object 
	// [input] : ProductNo     :  \d+
	// [input] : UploadFile    :  array('name','type','tmp_name','error','size'); 
	// [input] : UserID        :  user login ID from SESSION 
	
	public function ADSell_Upload_Order_Relate_Docs( $ProductNo='' , $UploadFile = array() , $UserID=0 ){
	  $this->ModelResult['status'] = 'error';  //mine-form-upload 的回傳參數
	  $file_type= array('jpg','png','pdf');
	  try{  
		
		// 檢查訂單序號
	    if(!preg_match('/^\d+$/',$ProductNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	   
		// 檢查上傳檔案
	    if( $UploadFile['error'] != UPLOAD_ERR_OK ){
		  throw new Exception($UploadFile['error']);
		}
		
		// 檢查檔案格式
		if(!in_array(strtolower(pathinfo($UploadFile['name'],PATHINFO_EXTENSION)),$file_type)){
	      throw new Exception('_SYSTEM_ERROR_FILE_CHECK_FAIL');
		}
		
		// 檢查檔案資料夾
		if(!is_dir(_SYSTEM_IMAGE_PATH.'product\\')){
		  mkdir(_SYSTEM_IMAGE_PATH.'product\\',0777);	
		}
				
		// 建立檔案紀錄		
		$DB_SAVE= $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_INSERT_RELATE_OBJECT());
		$DB_SAVE->bindValue(':pno'     	 , $ProductNo );
		$DB_SAVE->bindValue(':file_name' , $UploadFile['name'] );
		$DB_SAVE->bindValue(':file_type' , $UploadFile['type']);
		$DB_SAVE->bindValue(':file_size' , $UploadFile['size']);
		$DB_SAVE->bindValue(':handler'   , $UserID);
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// 移動檔案並開啟開啟記錄
		$new_upfile_no   = $this->DBLink->lastInsertId('product_obj');
		$new_upfile_name = 'HT'.str_pad($ProductNo,3,'0',STR_PAD_LEFT).'-'.str_pad($new_upfile_no,2,'0',STR_PAD_LEFT).'.'.array_pop(explode('.',$UploadFile['name']));
		
		move_uploaded_file($UploadFile['tmp_name'], _SYSTEM_ADIMAGE_PATH.'product\\'.$new_upfile_name);
		// copy to webroot
		copy(_SYSTEM_ADIMAGE_PATH.'product\\'.$new_upfile_name, _SYSTEM_IMAGE_PATH.'product\\'.$new_upfile_name);
		
		
		$DB_RENEW = $this->DBLink->prepare("UPDATE product_obj SET acc_name=:acc_name,file_keep=1 WHERE att_no=:att_no;");
		if( !$DB_RENEW->execute(array('acc_name'=>'product/'.$new_upfile_name,'att_no'=>$new_upfile_no))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// final 
		$this->ModelResult['status'] = 'success';
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	
	//-- Admin Sell Save Order Archive Data 
	// [input] : AttachNo     	:  order_num-\d{5}
	// [input] : UserID         :  user login no from SESSION 
	public function ADProduct_Delete_Relate_Object( $AttachNo = '' , $UserID=0 ){
	  
	  try{
		// 檢查附檔序號
	    if(!preg_match('/^\d+$/',$AttachNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_DELETE_ATTACHMENT());
		$DB_SAVE->bindValue(':att_no'  , $AttachNo);
		$DB_SAVE->bindValue(':handler' , $UserID);
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		// final 
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	//-- Admin Product Re Sort Product Relate Object Display Order 
	// [input] : ProductNo     	:  pno   - \d+
	// [input] : AttachNoOrder    :  attnolist - \d+,\d+,\d+,...
	// [input] : UserID         :  user login no from SESSION 
	public function ADProduct_ReSort_Relate_Object($ProductNo, $AttachNoOrder = '' , $UserID=0 ){
	  
	  try{
		
		$att_list = explode(',',$AttachNoOrder);
		
		// 檢查附檔序號
	    if(  !$ProductNo || count($att_list)<=1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_RESORT_ATTACHMENT());
		
		foreach($att_list as $key=>$attno){
		  $DB_SAVE->bindValue(':order'	, ($key+1));
		  $DB_SAVE->bindValue(':att_no'	, $attno);
		  $DB_SAVE->bindValue(':pno'	, $ProductNo);
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  }
		}
		// final 
		$this->ModelResult['action'] = true;
    	
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;  
	}
	
	/*[ Business Function Set ]*/ 
	
	//-- Admin Business Page Initial
	// [input] : NULL;
	public function ADProduct_Get_Business_List(){
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare($this->DBSql->ADMIN_PRODUCT_SELECT_ALL_BUSINESS());
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
	    
		$this->ModelResult['action'] = true;		
		$this->ModelResult['data']   = $business_list;		
	  
	  } catch (Exception $e) {
        $this->ModelResult['message'][] = $e->getMessage();
      }
	  return $this->ModelResult;
	}
	
	
	
  }
?>