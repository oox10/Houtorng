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
	
	
	
	
  }
  
?>