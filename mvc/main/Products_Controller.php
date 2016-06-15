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
	
	// AJAX: 取得員工資料 O
	public function read($staff_no){
	  $this->Model->ADStaff_Get_Staff_Data($staff_no);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 儲存員工資料 
	public function save($StaffNo , $DataJson,$UserRoles){
	  if($StaffNo=='_addnew'){
	    $action = $this->Model->ADStaff_Newa_Staff_Data($DataJson,$UserRoles);
	  }else{
	    $action = $this->Model->ADStaff_Save_Staff_Data($StaffNo,$DataJson,$UserRoles);
	  }
	  if($action['action']){
		$this->Model->ADStaff_Get_Staff_Data($action['data']);
	  }
	  self::data_output('json','',$this->Model->ModelResult); 
	}
	
    // AJAX: 刪除員工帳號 O
	public function dele($StaffNo){
	  $this->Model->ADStaff_Del_Staff_Data($StaffNo);
	  self::data_output('json','',$this->Model->ModelResult);
	}
    
	// AJAX: 寄發帳號開通通知信
	public function startmail($StaffNo){
	  $this->Model->ADStaff_Staff_Account_Accept_Mail($StaffNo);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 取得群組成員清單(包含非主要群組)
	public function gmember(){
	  $this->Model->ADStaff_Get_Group_Memners();
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 加入群組成員
	public function gpadd($user,$roles=''){
	  $this->Model->ADStaff_Add_Group_Memner($user,$roles);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	// AJAX: 移出群組成員
	public function gpdef($user){
	  $this->Model->ADStaff_Del_Group_Memner($user);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	
	
	/*
	// PAGE: 產品管理
	protected function product(){
	  $this->Model = new Model_AdProduct;
	  
	  $result = array('action'=>true,'data'=>array());
	  
	}
	
	// AJAX: 排序產品檔案
	protected function act_product_sort(){
	  $this->Model = new Model_AdProduct;
	  $obj_sort  = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADProduct_ReSort_Products( $obj_sort,$_SESSION['USER_ID']));
	}
	

	// AJAX: 取得產品資料
	protected function act_product_read(){
	  $this->Model = new Model_AdProduct;
	  $record_no = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';  
	  self::data_output('json',$this->Model->ADProduct_Get_Target_Product($record_no,$_SESSION['lang']),'');
	}
	
	
	
	
	
	// AJAX: 儲存產品資料
	protected function act_product_save(){
	  $this->Model = new Model_AdProduct;
	  $product_no   = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  $product_data = isset($_REQUEST['data'])   ? $_REQUEST['data'] : '';	  
	  
	  if($product_no=='_addnew'){
	    $act_result = $this->Model->ADProduct_Newa_Product_Data($product_data);
	  }else{
	    $act_result = $this->Model->ADProduct_Save_Product_Data($product_no,$product_data);
	  }
	  
	  if($act_result['action']){
	    self::data_output('json',$this->Model->ADProduct_Get_Target_Product($act_result['data'],$_SESSION['lang']),'');
	  }else{
	    self::data_output('json',$act_result,''); 
	  }
	}
	
	
	// AJAX: 取得附件列表
	protected function act_get_pjobj(){
	  $this->Model = new Model_AdProduct;
	  $product_no= isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADProduct_Get_Product_Relative_FL( $product_no ));
	}
	
	
	// AJAX: 上傳合約附件檔案
	protected function act_upload_pdobj(){
	  $this->Model = new Model_AdProduct;
	  $upfile   = isset($_FILES['upl']) ? $_FILES['upl']: array(); 
	  $record_no= isset($_REQUEST['record_num']) ? $_REQUEST['record_num'] : '';
	  self::data_output('json',$this->Model->ADSell_Upload_Order_Relate_Docs( $record_no , $upfile , $_SESSION['USER_ID']));
	}
	
	// AJAX: 刪除附件檔案
	protected function act_reobj_del(){
	  $this->Model = new Model_AdProduct;
	  $att_no= isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADProduct_Delete_Relate_Object( $att_no , $_SESSION['USER_ID']));
	}
	
	
	// AJAX: 排序附件檔案
	protected function act_reobj_sort(){
	  $this->Model = new Model_AdProduct;
	  $data_no  = isset($_REQUEST['target']) ? intval($_REQUEST['target']) : 0;
	  $obj_sort = isset($_REQUEST['refer'])  ? $_REQUEST['refer'] : '';
	  self::data_output('json',$this->Model->ADProduct_ReSort_Relate_Object( $data_no ,$obj_sort,$_SESSION['USER_ID']));
	}
	
	
	*/
	
  }
  
  
  
  
  
?>