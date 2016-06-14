<?php
  /*******************************************
      MVC controler class  Login Router
	  
      主要為判別接收動作後
	  應當對應到哪個 controler method
      
      預設導向  index() method
	   	  
      Router 還有另外一項任務  依據不同任務進行不同檢查
      任務參數
		Login    
		  檢查 User ip 是否在 ip Ben List 中
	      如果是 則導向  wait() method 
        SystemUse	  
	      檢查 User Connect 是否已註冊 
	      如果尚未註冊則導向  unlogin() method
	  
  ********************************************/
  class Router{
    
	//--預設動作
	protected $action = 'index'; 
    protected $second = 0; 
	
	//--建構函式  解析  $_GET 
	public function __construct(){
	  $paser  = isset($_REQUEST['act']) ? explode('/',$_REQUEST['act']):array('index');
	  $this->action = count($paser) ? strtolower(array_shift($paser)) : 'index' ;
	  $this->second = count($paser) ? array_shift($paser) : '' ; 
	}
    
	//-- 依據用途判別需要的條件
	public function getAction( $mode = '_LOGIN'){    //取得解析後的 動作名稱              
	  
	  switch($mode){  
		
		case '_SITE':
		  
		  // 強制設定語言
		  if(isset($_SERVER['HTTP_HOST'])){
			if(preg_match('/^eng\./',$_SERVER['HTTP_HOST'])){
			  $_SESSION['language'] = 'meta_eng';
			}else if(preg_match('/^tw\./',$_SERVER['HTTP_HOST'])){
			  $_SESSION['language'] = 'meta_cht';	
			}  
		  }
		  
		  if(!isset($_SESSION['language'])){
			$lang_detect = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2):'';  	
		    switch($lang_detect){
			  case 'zh':	$_SESSION['language'] = 'meta_cht'; break;
              default:	$_SESSION['language'] = 'meta_eng';	break;	
		    }  
		  }
		  
		  break;
		
		case '_LOGIN':
		  
		  break;
		
		case '_ADMIN':
		  
		  if(!isset($_SESSION['ADMIN_LOGIN_TOKEN'])){
		    $this->action = 'denial';
		    $this->second = '_LOGIN_INFO_ACCOUNT_UNLOGIN';
		  }
		  break;
		  
		case '_FILE':
		  break;
		
		case '_TEST':
		  break;
		
		case 'sample':
		  //$this->action = preg_match('/^act_/',$this->action) ? 'act_adlogin' : 'adlogin' ;
		  break;
	  }
	  
	  return $this->action;
	}
	
	//-- 取得附加參數
	public function getAddition(){
	   return $this->second;
	}
	
    public function __destruct(){
      $this->action = NULL;
	  $this->second = NULL;
    }
    
  }
?>