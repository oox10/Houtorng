<?php
  class ADRouter{
	  
	
	protected $objController;
	public $nowController;
	public $nowAction;
	public $nowArgs;
	
	public function route(Request_url $request){
	  
	  $controller     = $request->getController();
	  $action         = $request->getAction();
      $this->nowArgs  = $request->getArgs();
	  
	  try{
		echo "12";
		self::priority($controller,$action);  // 檢查權限			
		
	    $this->nowController = $this->nowController.'_Controller';  
	    
		// check class exist
		if(!class_exists($this->nowController, true)){   // false : 確認前先不執行 autoload
		  throw new Exception('404 Controller "'.$request->getController().'" not found');
		}
		
		// check class::method exist
		$this->nowAction	    = method_exists($this->nowController,$this->nowAction) ? $this->nowAction : 'index';
		
		// map args to object method 
		$c = new ReflectionClass($this->nowController);
        $m = $this->nowAction;
        $f = $c->getMethod($m);
        $p = $f->getParameters();            
        $params_new = array();
        $params_old = $this->nowArgs;
        
		// re-map the parameters
        for($i = 0; $i<count($p);$i++){
          $key = $p[$i]->getName();
          if(array_key_exists($key,$params_old)){
            $params_new[$i] = $params_old[$key];
            unset($params_old[$key]);
          }
        }
        
		// after reorder, merge the leftovers
        $params_new = array_merge($params_new, $params_old);// 將多出的參數移到最後面
        
	  }catch (Exception $e){
        $params_new = array($e->getMessage());
	    $this->nowController = 'Error_Controller';
	    $this->nowAction = 'index';
	  }
	  
	  
	  $this->objController 	= new $this->nowController;
	  // call the action method
	  call_user_func_array(array($this->objController , $this->nowAction), $params_new);  
	  
	  return 1;
	  exit(1);
	}
	
	// check action priority
	protected  function priority(  $controller , $action ){
	  
	  switch($controller){
		
		// unfilter
		case 'Account': break;
		case 'Work':  break;
		
		// login filter
		case 'Main':
		case 'Staff':
		case 'Classify':
		case 'Record':
		case 'Report':
		case 'Task':  
		case 'Archive':  
		default:
		  
		  try{
			
			// 檢查登入
			if(!isset($_SESSION[_SYSTEM_NAME_SHORT])){
			  throw new Exception('Account/unlogin');
			}
			
            // 檢查權限			
			if(isset($_SESSION[_SYSTEM_NAME_SHORT]['PERMISSION'][strtolower($controller)]) && intval($_SESSION[_SYSTEM_NAME_SHORT]['PERMISSION'][strtolower($controller)])==0 ){
			  throw new Exception('Main/denial');
			}
			
		  }catch(Exception $e){
			list($controller,$action) = explode('/',$e->getMessage());
		  }
		  break;
	  }
	  
	  $this->nowController = $controller;
	  $this->nowAction	   = $action;
	  return 1;
	}
	
  }

?>