<?php 
  
  class Request_url{
	
    protected $_controller;
	protected $_action;
	protected $_args;
	
	public function __construct(){
	  
      $refer = explode('/', isset($_REQUEST['act'] )? $_REQUEST['act'] :'Account/index');
	  
	  $this->_controller = ($c = array_shift($refer)) ? $c : 'Error';;
	  $this->_action     = ($a = array_shift($refer)) ? $a : 'index';;
	  $this->_args	     = isset($refer[0]) ? $refer : array();
	}
	
	public function getController(){   
	  return  $this->_controller;
	}
	
	public function getAction(){   
	  return  $this->_action;  
	}
	
	public function getArgs(){   
	  return  $this->_args;
	}
	
  }
  

?>