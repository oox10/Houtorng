<?php

  class Products_Model extends Admin_Model{
    
	/***--  Function Set --***/
    public function __construct(){
	  parent::__construct();
	}
	
	/*[ Product Function Set ]*/ 
	

	//-- Admin Product Page Initial -1  
	public function ADProduct_Get_Product_Language_Set(){
	  $result_key = parent::Initial_Result('lang');
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SELECT_META_LANG_SET());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得語言資料欄位
		$result['action'] = true;		
		$result['data'] = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	  
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;
	}
	
	
	//-- Admin Product Page Initial -2
	// [input] : NULL;
	public function ADProduct_Get_Product_List(){
	  
	  $result_key = parent::Initial_Result('products');
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{
		// 查詢資料庫
		$DB_OBJ = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SELECT_ALL_PRODUCTS());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}

		// 取得客戶資料
		$products_list = array();
		$products_list = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);		
	    
		$result['action'] = true;		
		$result['data']   = $products_list;		
	  
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;
	}
	
	
	//-- Admin Product Get Target Data
	// [input] : jobcode  :  md5 string;
	public function ADProduct_Get_Product_Data($TargetId=''){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{
		// 檢查工作序號
	    if( !intval($TargetId) ){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
		
		// 查詢產品資料
		$DB_OBJ = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SELECT_ONE_PRODUCT());
		if(!$DB_OBJ->execute(array('pno'=>$TargetId))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}
		
		if(!$data = $DB_OBJ->fetch(PDO::FETCH_ASSOC)){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
		$result['data']['products'] = $data;
		
		// 取得各項語言產品資料
		$DB_OBJ = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SELECT_META_LANG_SET());
		if(!$DB_OBJ->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');  
		}
		
		$lang_set = $DB_OBJ->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($lang_set as $lang){
		  // 查詢產品各語言詮釋資料
		  $DB_OBJ = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SELECT_PRODUCT_META($lang['Name']));	 
		  if($DB_OBJ->execute(array('pno'=>$data['pid']))){
			$result['data'][$lang['Name']]  = $DB_OBJ->fetch(PDO::FETCH_ASSOC);
		  }	
		}
		$result['action'] = true;
		
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;
	}
	
	
	
	//-- Admin Product Get Display Files (image or video or ..) 
	// [input] : product_id  :  \d+;
	public function ADProduct_Get_Product_Relative_FL($Pid=''){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  try{  
		// 檢查訂單序號
	    if(!preg_match('/^\d+$/',$Pid)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 取得檔案列表
		$DB_GET	= $this->DBLink->prepare( SQL_AdProduct::ADMIN_PRODUCT_SELECT_PRODUCT_DISPLAY() );
		$DB_GET->bindValue(':pno',$Pid);	
		
		if( !$DB_GET->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_RESULT_NULL');
		}
		
	    $object_list = $DB_GET->fetchAll(PDO::FETCH_ASSOC);
		$result['data']   = $object_list;
		$result['action'] = true;
  
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	
	//-- Admin Product Create New Product 
	// [input] : DataCreate  :   urlencode(base64encode(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	public function ADProduct_Newa_Product_Data($DataCreate=''){
	    
	  $data_newa = json_decode(base64_decode(str_replace('*','/',rawurldecode($DataCreate))),true);
	  
	  $result_key = parent::Initial_Result('newa');
	  $result  = &$this->ModelResult[$result_key];
	  
	  
	  try{  
		
		// 檢查必備資料
		if( count($data_newa) < 1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
		
		$DB_INSERT  = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_CREATC_NEW_PRODUCT());
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
			$DB_INSERT	= $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_INSERT_PRODUCT_META_BY_LANG($table));    
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
		$result['data'] = $new_data_no;
		$result['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
		
    //-- Admin Product Save Product Data 
	// [input] : DataNo      :  \d+  = DB.tasks_plan.pno;
	// [input] : DataModify  :  urlencode(base64encodeM(json_pass()))  = array( 'field_name'=>new value , ......   ) ;  // 修改之欄位 - 變動
	
	public function ADProduct_Save_Product_Data($DataNo=0 , $DataModify=''){
	  $result_key = parent::Initial_Result('save');
	  $result  = &$this->ModelResult[$result_key];
	  
	  $data_modify = json_decode(base64_decode(str_replace('*','/',rawurldecode($DataModify))),true);
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
		    $DB_SAVE	= $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_UPDATE_PRODUCT_DATA($table,array_keys($mdata)));
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
		$result['data'] = $DataNo;
		$result['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	//-- Admin Product Delete  Data 
	// [input] : uno  :  \d+;
	public function ADProduct_Del_Product_Data($ProductNo=0){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{  
		
		// 檢查使用者序號
	    if(!preg_match('/^\d+$/',$ProductNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 變更user_info pri => 0
		$DB_DELE	= $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_DELETE_PRODUCT());
		$DB_DELE->bindParam(':pid'      , $ProductNo , PDO::PARAM_INT);
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
	
	//-- Admin Product Re Sort Product Display Order 
	// [input] : ProductOrder   :  attnolist - \d+,\d+,\d+,...
	public function ADProduct_ReSort_Products( $ProductNoOrder = '' ){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  try{
		
		$pdo_list = explode(',',$ProductNoOrder);
		
		// 檢查
	    if( count($pdo_list)<=1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_SET_PRODUCTS_ORDER());
		
		foreach($pdo_list as $key=>$pid){
		  $DB_SAVE->bindValue(':order'	, ($key+1));
		  $DB_SAVE->bindValue(':pid'	, $pid);
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  }
		}
		// final 
		$result['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	
	
	
	
	
	
	//-- Admin Product Re Sort Product Relate Object Display Order 
	// [input] : ProductNo     	:  pno   - \d+
	// [input] : AttachNoOrder    :  attnolist - \d+,\d+,\d+,...
	public function ADProduct_ReSort_Relate_Object($ProductNo, $AttachNoOrder = ''  ){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  
	  try{
		
		$att_list = explode(',',$AttachNoOrder);
		
		// 檢查附檔序號
	    if(  !$ProductNo || count($att_list)<=1){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_RESORT_ATTACHMENT());
		
		foreach($att_list as $key=>$attno){
		  $DB_SAVE->bindValue(':order'	, ($key+1));
		  $DB_SAVE->bindValue(':att_no'	, $attno);
		  $DB_SAVE->bindValue(':pno'	, $ProductNo);
		  if( !$DB_SAVE->execute()){
		    throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		  }
		}
		// final 
		$result ['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result ;  
	}
	
	
	//-- Admin Product Delete Relate Object // table  product_obj
	// [input] : AttachNo     	:  order_num-\d{5}
	public function ADProduct_Delete_Relate_Object( $AttachNo){
	  $result_key = parent::Initial_Result();
	  $result  = &$this->ModelResult[$result_key];
	  try{
		// 檢查附檔序號
	    if(!preg_match('/^\d+$/',$AttachNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
	    
		// 執行更新
		$DB_SAVE = $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_DELETE_ATTACHMENT());
		$DB_SAVE->bindValue(':att_no'  , $AttachNo);
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		// final 
		$result['action'] = true;
    	
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;  
	}
	
	
	
	//-- Upload Catalog Excel 
	// [input] : ProductNo   : ProductNo;
	// [input] : UploadMeta : accnum:urlencode(base64encode(json_pass()))  = array(F=>V);
	// [input] : FILES : [array] - System _FILES Array;
	public function ADProduct_Upload_Object( $ProductNo='' , $UploadMeta='' , $FILES = array()){
	  
	  $result_key = parent::Initial_Result('upload');
	  $result  = &$this->ModelResult[$result_key];
	  
      // [name] => MyFile.jpg  / [type] => image/jpeg  /  [tmp_name] => /tmp/php/php6hst32 / [error] => UPLOAD_ERR_OK / [size] => 98174
	  // Allowed extentions.
      $allowedExts = array("jpg","png","gif");
      
      // Get filename.
      $temp = explode(".", $FILES["file"]["name"]);
      
      // Get extension.
      $extension = end($temp);
      
	  // Validate uploaded files.
	  // Do not use $_FILES["file"]["type"] as it can be easily forged.
	  $finfo = finfo_open(FILEINFO_MIME_TYPE);
	  $mime  = finfo_file($finfo, $FILES["file"]["tmp_name"]);
	  $upload_data = json_decode(base64_decode(str_replace('*','/',$UploadMeta)),true);   
	  
	  try{
		
		// 檢查參數
		if(!preg_match('/^\d+$/',$ProductNo)){
		  throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
		}
     	
		if (!in_array(strtolower($extension), $allowedExts)) {
	      throw new Exception('_SYSTEM_ERROR_PARAMETER_FAILS');
	    }	
		
        if( $FILES["file"]["error"] ){
          throw new Exception('UPLOAD ERROR:'.$FILES["file"]["error"]);  
        }
		
		
		// 建立檔案紀錄		
		$DB_SAVE= $this->DBLink->prepare(SQL_AdProduct::ADMIN_PRODUCT_INSERT_RELATE_OBJECT());
		$DB_SAVE->bindValue(':pno'     	 , $ProductNo );
		$DB_SAVE->bindValue(':file_name' , $FILES["file"]['name'] );
		$DB_SAVE->bindValue(':file_type' , $FILES["file"]['type']);
		$DB_SAVE->bindValue(':file_size' , $FILES["file"]['size']);
		$DB_SAVE->bindValue(':handler'   , $this->USER->UserID);
		if( !$DB_SAVE->execute()){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		// 移動檔案並開啟開啟記錄
		$new_upfile_no   = $this->DBLink->lastInsertId('product_obj');
		$new_upfile_name = 'HT'.str_pad($ProductNo,3,'0',STR_PAD_LEFT).'-'.str_pad($new_upfile_no,2,'0',STR_PAD_LEFT).'.'.$extension;
		
		move_uploaded_file($FILES["file"]['tmp_name'], _SYSTEM_ADIMAGE_PATH.'product/'.$new_upfile_name);
		// copy to webroot
		copy(_SYSTEM_ADIMAGE_PATH.'product/'.$new_upfile_name, _SYSTEM_IMAGE_PATH.'product/'.$new_upfile_name);
		
		
		$DB_RENEW = $this->DBLink->prepare("UPDATE product_obj SET acc_name=:acc_name,file_keep=1 WHERE att_no=:att_no;");
		if( !$DB_RENEW->execute(array('acc_name'=>'product/'.$new_upfile_name,'att_no'=>$new_upfile_no))){
		  throw new Exception('_SYSTEM_ERROR_DB_ACCESS_FAIL');
		}
		
		$result['action'] = true;
		
	  } catch (Exception $e) {
        $result['message'][] = $e->getMessage();
      }
	  return $result;
	}
	
	
	
  }
?>