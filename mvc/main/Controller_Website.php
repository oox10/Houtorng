<?php
  
  class Controller_WebSite extends Controller{
  
    //-- 共用物件
	private $Model     = NULL;
    private $Language  = 'meta_eng';
	
	
	//--  Class Initial
	public function __construct(){
	  $this->Model = new Model_WebSite;
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
	
	
	// PAGE: 系統首頁
	protected function index(){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 
	  self::data_output('html', $this->Model->WebSite_Get_Product_List($this->Language),'index');
	}
	
	// AJAX: 設定語言
	protected function act_lang($lang_to){
	  switch($lang_to){
		case 'en': $this->Language = 'meta_eng'; break;
        case 'tw': $this->Language = 'meta_cht'; break;
        default: $this->Language = 'meta_eng'; break; 		
	  }
	  $_SESSION['language'] = $this->Language;
	  
	  self::data_output('json', array('action'=>true,'data'=>$this->Language),'');
	}
	
	
	
	// PAGE: 系統錯誤頁面
	protected function wrong($error_code=''){
	  self::data_output('html',array('info'=>$this->Model->Get_Action_Message($error_code)),'wrong');
	}
	
	// PAGE: 系統權限不足頁面
	protected function denial($error_code=''){
	  self::data_output('html',array('info'=>$this->Model->Get_Action_Message($error_code)),'index');
	}
	
	// PAGE: 產品資訊
	protected function product($targetProduct=''){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 	
	  $result = $this->Model->WebSite_Get_Product_List($this->Language,$targetProduct);	
	  self::data_output('html',$this->Model->WebSite_Get_Product_List($this->Language,$targetProduct) , $targetProduct&&$result['data']['result'] ?'website-product-item':'website-product');
	}
	
	// PAGE: 業務實績
	protected function business(){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 	
	  $this->Model->WebSite_Get_Product_List($this->Language);
	  self::data_output('html',$this->Model->WebSite_Get_Business_List(),'website-business');
	}
	
	
	// PAGE: 關於我們
	protected function aboutus($error_code=''){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 	
	  self::data_output('html',$this->Model->WebSite_Get_Product_List($this->Language),'website-about');
	}
	
	// PAGE: 聯繫我們
	protected function contact($error_code=''){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 	
	  self::data_output('html',$this->Model->WebSite_Get_Product_List($this->Language),'website-contact');
	}
	
	
	// PAGE: 網站地圖
	protected function sitemap($error_code=''){
	  $this->Language = isset($_SESSION['language']) ? $_SESSION['language'] : 'meta_eng'; 	
	  self::data_output('html',$this->Model->WebSite_Get_Product_List($this->Language),'website-sitemap');
	}
	
	
	// AJAX: 送出聯繫表單
	protected function message(){
	  $captcha_save = isset($_SESSION['turing_string']) ? $_SESSION['turing_string'] : false ;
	  $captcha_user = isset($_REQUEST['captcha']) ? $_REQUEST['captcha'] : '';
	  $message_data = isset($_REQUEST['message']) ? json_decode(rawurldecode($_REQUEST['message']),true) : array();
	  self::data_output('json', $this->Model->Contact_Message_Submit($captcha_save,$captcha_user,$message_data),'');
	}
	
  }
  
?>