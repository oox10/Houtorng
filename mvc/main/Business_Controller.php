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
	
	// AJAX: 儲存實績資料
	public function save($DataJson){
	  $this->Model->ADBusiness_Save_Record_Data($DataJson);
	  self::data_output('json','',$this->Model->ModelResult); 
	}
	
	// AJAX: 刪除實績資料
	public function dele($DataID){
	  $this->Model->ADBusiness_Delete_Record_Data($DataID);
	  self::data_output('json','',$this->Model->ModelResult);
	}
	
	
	
	
  }
  
  
  
  
  
?>