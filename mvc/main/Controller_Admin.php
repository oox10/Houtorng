<?php
  
  class Controller_Admin extends Controller{
  
    //-- 共用物件
	private $Model     = NULL;
 
	
	//--  Class Initial
	public function __construct(){
	  // destruct class when php chutdown
	  register_shutdown_function(array($this, '__destruct'));
	}
	
	
	//--  Class Destruct
	public function __destruct(){
	  // logs used info
	  if(!$this->Model){
		$this->Model = new Model_Main;
	  }
	  $this->Model->System_Logs_Used_Action($this->action);
	}
	
	/********************************************
	*******  Default Action Control Func  *******
	********************************************/
	
	// FUNC: 資料匯出
	protected function data_output($IOType='' , $IOData = array() , $Theme='' ){
	  
	  switch( strtolower($IOType) ){
	    
		case 'html':
		  $view = new Result_HTML;
	      $view->setVar('system_data',$IOData);
		  if(isset($view->system_data['action']) && !$view->system_data['action'] ){
	        $view->addVar('system_data','info',$this->Model->Get_Action_Message());
	      }
		  $view->render($Theme);
		  break;
		  
		case 'json':  
		  $view = new Result_JSON;
		  $view->setVar('system_data',$IOData);
		  if(isset($view->system_data['action']) && !$view->system_data['action'] ){
	        $view->addVar('system_data','info',$this->Model->Get_Action_Message());
	      }
		  $view->render('system_data');  
	      break;  
        
		case 'file':
		  
		  if($IOData['action']){
			$view = new Result_FILE;    
			$view->setVar('system_data',$IOData);
		    $view->render();   
		  }else{
			$view = new Result_HTML;  
			$view->setVar('system_data',$IOData);
		    if(isset($view->system_data['action']) && !$view->system_data['action'] ){
	          $view->addVar('system_data','info',$this->Model->Get_Action_Message());
	        }   
			$view->render('wrong');  
		  }
		  
		  break;
		
		default:
		  echo "OUTPUT TYPE : error ";
		  exit(1);
		  //session_unset();
		  //$this->redirectTo('index.php');
		  //header('HTTP/1.0 400 Bad Request', true, 400);
		  break;
	  }
	}
	
	
	// PAGE: 管理系統首頁
	protected function index(){
	  self::data_output('html',array(),'admin_main');
	}
	
	// PAGE: 錯誤頁面 
	protected function wrong(){
	  $this->redirectTo('index.php');
	}
	
	// AJAX: 錯誤動作 
	protected function denial(){
	  $this->redirectTo('index.php');
	}
	
	protected function logout(){ 
	  session_destroy();
	  $this->redirectTo('index.php');
	}
    
	//protected function act_relogin(){ }
	
	
	
	/******************************************
	*******  Admin Staff Control Set  *********
	******************************************/
	
	
	// PAGE: 員工管理介面
	protected function adstaff(){
	  $this->Model = new Model_AdStaff;
	  $active_module = $this->Model->ADStaff_Get_Staff_List(); 
	  self::data_output('html',$active_module,'admin_staff');
	}
	
	
	// AJAX: 取得員工資料
	protected function act_staff_read(){
	  $this->Model = new Model_AdStaff;
	  $staff_no = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADStaff_Get_Staff_Data($staff_no),'');
	}
	
	
	// AJAX: 儲存員工資料
	protected function act_staff_save(){
	  $this->Model = new Model_AdStaff;
	  $staff_no   = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  $staff_data = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
	    
	  if($staff_no=='_addnew'){
	    $act_result = $this->Model->ADStaff_Newa_Staff_Data($staff_data);
	  }else{
	    $act_result = $this->Model->ADStaff_Save_Staff_Data($staff_no,$staff_data);
	  }
	  
	  if($act_result['action']){
	    self::data_output('json',$this->Model->ADStaff_Get_Staff_Data($act_result['data']),'');
	  }else{
	    self::data_output('json',$act_result,''); 
	  }
	}
	
    // AJAX: 刪除員工帳號
	protected function act_staff_del(){
	  $this->Model = new Model_AdStaff;
	  $staff_no = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADStaff_Del_Staff_Data($staff_no),'');
	}
    
	// AJAX: 寄發帳號開通通知信
	protected function act_staff_mail_accept(){
	  $this->Model = new Model_AdStaff;
	  $staff_no = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADStaff_Staff_Account_Accept_Mail($staff_no),'');
	}
	
	// AJAX: 發送員工密碼設定信
	protected function act_staff_mail_repw(){
	  $this->Model = new Model_AdStaff;
	  $staff_no = isset($_REQUEST['target']) ? $_REQUEST['target'] : '';
	  self::data_output('json',$this->Model->ADStaff_Account_Reset_Pass($staff_no),'');
	}
	
	
    
	
	/******************************************
	*******  Admin Producted Control Set  *********
	******************************************/
	 
	// PAGE: 產品管理
	protected function product(){
	  $this->Model = new Model_AdProduct;
	  
	  $result = array('action'=>true,'data'=>array());
	  $result['data']['lang']   = $this->Model->ADSell_Get_Product_Language_Set()['data'];
	  $result['data']['record'] = $this->Model->ADSell_Get_Product_List()['data'];
	  $_SESSION['lang'] = array();
	  foreach($result['data']['lang'] as $lang){
		$_SESSION['lang'][] =  $lang['Name']; 
	  }

	  self::data_output('html',$result,'admin_product');
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
	
	
	// AJAX: 刪除附件檔案
	protected function act_reobj_sort(){
	  $this->Model = new Model_AdProduct;
	  $data_no  = isset($_REQUEST['target']) ? intval($_REQUEST['target']) : 0;
	  $obj_sort = isset($_REQUEST['refer'])  ? $_REQUEST['refer'] : '';
	  self::data_output('json',$this->Model->ADProduct_ReSort_Relate_Object( $data_no ,$obj_sort,$_SESSION['USER_ID']));
	}
	
	/********************************************
	*******  Admin Business Control Set  *********
	******************************************/
	 
	// PAGE: 產品管理
	protected function business(){
	  $this->Model = new Model_AdProduct;
	  $result = array('action'=>true,'data'=>array());
	  $result['data']['record'] = $this->Model->ADProduct_Get_Business_List()['data'];
	  self::data_output('html',$result,'admin_business');
	}
	
	
	
	
	
  }
  
?>