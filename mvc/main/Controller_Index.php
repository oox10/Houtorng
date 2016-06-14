<?php
  
  class Controller_Index extends Controller{
  
    //-- 共用物件
	private $Model     = NULL;
 
	
	//--  Class Initial
	public function __construct(){
	  $this->Model = new Model_Index;
	  
	  // destruct class when php chutdown
	  register_shutdown_function(array($this, '__destruct'));
	}
	
	
	//--  Class Destruct
	public function __destruct(){
	  // logs used info
	  $this->Model->System_Logs_Used_Action($this->action);
	}
	
	/*******************************************
	*******  建立各種 act 動作之函數  *********
	*******************************************/
	
	
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

		default:
		  
		  echo "OUTPUT TYPE : error ";
		  exit(1);
		  //session_unset();
		  //$this->redirectTo('index.php');
		  //header('HTTP/1.0 400 Bad Request', true, 400);
		  break;
	  }
	}
	
	
	// PAGE: 系統資訊頁面
	protected function index(){
	  self::data_output('html',array(),'admin_index');
	}
	
	// PAGE: 系統資訊頁面
	protected function wrong($error_code=''){
	  self::data_output('html',array('info'=>$this->Model->Get_Action_Message($error_code)),'admin_index');
	}
	
	// PAGE: 系統資訊頁面
	protected function denial($error_code=''){
	  self::data_output('html',array('info'=>$this->Model->Get_Action_Message($error_code)),'admin_index');
	}
	
	
	// AJAX: 管理系統檢查登入
	protected function act_adlogin(){
	  $login_data = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
	  self::data_output('json',$this->Model->ADLogin_Active_Login($login_data),'');
	}
	
	// PAGE: 管理系統進入
	protected function act_adinter(){
	  $login_key = isset($_REQUEST['refer']) ? $_REQUEST['refer'] : '';
	  $login_active = $this->Model->ADLogin_Inter_Admin($login_key);
	  if($login_active['action']){
	    foreach($login_active['data'] as $sionkey => $sionvalue){
		  $_SESSION[$sionkey] = $sionvalue;
		}
		$this->redirectTo('admain.php?act=adStaff');
	  }else{
	    self::data_output('html',$login_active,'admin_index');
	  } 
	}
	
  }
  
?>