<?php
  
  
  /********************************************* 
  ** Hontrong Admin Products Control Set **
  *********************************************/
	
  class Products_Controller extends Admin_Controller{
    
	public function __construct(){
	  parent::__construct();	
      $this->Model = new Products_Model;
	}
	
	// PAGE: 產品列表介面 O
	public function index(){
	  
	  $this->Model->GetUserInfo(); 	  
	  $this->Model->ADProduct_Get_Product_Language_Set();
	  $this->Model->ADProduct_Get_Product_List();
	  self::data_output('html','admin_product',$this->Model->ModelResult);
	  
	}
	
	// AJAX: 取得產品資料
	public function read($ProductID){
      $this->Model->ADProduct_Get_Product_Data($ProductID);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	
	// AJAX: 取得附件列表
	public function pjobj($ProductID){
	  $this->Model->ADProduct_Get_Product_Relative_FL( $ProductID );
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 儲存產品資料
	public function save($ProductNo , $DataJson){
	  
	  if($ProductNo=='_addnew'){
	    $action = $this->Model->ADProduct_Newa_Product_Data($DataJson);
	  }else{
	    $action = $this->Model->ADProduct_Save_Product_Data($ProductNo,$DataJson);
	  }
	  
	  if($action['action']){
		$this->Model->ADProduct_Get_Product_Data($action['data']);
	  }
	  
	  self::data_output('json','',$this->Model->ModelResult); 
	}
	
	// AJAX: 刪除產品
	public function pdel($ProductID){
	  $this->Model->ADProduct_Del_Product_Data($ProductID);
	  self::data_output('json','',$this->Model->ModelResult);
	}
    
	
	// AJAX: 排序產品
	public function psort($OrderList){
	  $this->Model->ADProduct_ReSort_Products( $OrderList);
	  self::data_output('json','',$this->Model->ModelResult); 
	}
	
	
	/* [ 附件部分 ] */
	
	// AJAX: 排序附件檔案
	public function objsort($ProductID,$ObjectSort){
	  $this->Model->ADProduct_ReSort_Relate_Object($ProductID,$ObjectSort);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 刪除附件檔案
	public function objdel($ProductID){
	  $this->Model->ADProduct_Delete_Relate_Object($ProductID);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	
	// AJAX: 上傳附件檔案
	public function objupl( $fno , $data ){
      $_FILES['file']['lastmdf'] = $_REQUEST['lastmdf'];
	  $this->Model->ADProduct_Upload_Object($fno , $data , $_FILES); 
	  self::data_output('upload','',$this->Model->ModelResult);
	}
	
	
	/*
	
	// AJAX: 上傳合約附件檔案
	protected function act_upload_pdobj(){
	  $this->Model = new Model_AdProduct;
	  $upfile   = isset($_FILES['upl']) ? $_FILES['upl']: array(); 
	  $record_no= isset($_REQUEST['record_num']) ? $_REQUEST['record_num'] : '';
	  self::data_output('json',$this->Model->ADSell_Upload_Order_Relate_Docs( $record_no , $upfile , $_SESSION['USER_ID']));
	}
	
	
	
	
	
	
	
	
	*/
	
  }
  
  
  
  
  
?>