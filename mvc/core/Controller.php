<?php 

  /*******************************************
      MVC main controler class
	  
  ********************************************/
  
  abstract class Controller{
    
	protected $action   = '';      //動作名稱
    protected $addition = NULL;    //附加參數  各動作可自行回傳相關值
	protected $router 	= NULL;
    
	//-- 設定路由器
    public function setRouter(Router $router,$RouteMode){                     //輸入一個 Router 物件 當參數 
	  if(method_exists($this,($action = $router->getAction($RouteMode)))){    //確認從router取得之參數名 是否在物件內有定義  router 預設傳回 "index"
		$this->action   = $action;
	    $this->addition = $router->getAddition();
	  }else{
	    
		if(preg_match('/^act_/',$action)){
		  $this->action = "denial";
		  $this->addition = '';
		}else{
		  $this->action = "wrong";
		}
	  }
	}
	
	//-- 抽象：預設動作，繼承此物件之類別都需要定義 index() method
	protected abstract function index();
	
	//-- 執行選擇的動作
    public final function run(){
	   $this->{$this->action}($this->addition);
	}
	
	//-- 重新導向
    public function redirectTo($url){
      header('Location: ' . $url);
    }
  }
  
  
?>