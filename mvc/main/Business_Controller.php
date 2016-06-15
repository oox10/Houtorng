<?php
  
  
  /********************************************* 
  ** Hontrong Admin Products Control Set **
  *********************************************/
	
  class Business_Controller extends Admin_Controller{
    
	public function __construct(){
	  parent::__construct();	
      $this->Model = new Business_Model;
	}
	
	/********************************************
	*******  Admin Business Control Set  *********
	******************************************/
	 
	// PAGE: 客戶實績
	public function index(){
	  $this->Model->GetUserInfo();
	  $this->Model->ADProduct_Get_Business_List();
	  self::data_output('html','admin_business',$this->Model->ModelResult);
	}
	
  }
  
  
  
  
  
?>