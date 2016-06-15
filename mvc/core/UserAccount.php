<?php
  
  /*  TLCDA Account Class 
  *
  *
  */

  
  class UserAccount{
	
    public $UserNO;
	public $UserID;
	public $UserIP;
	public $UserTask;
	public $UserInfo = array();
	
	
    public $PermissionQue  = array();
	public $PermissionNow  = array();
	public $PermissionCheck  = array();
	
	public function __construct($UserNo=0,$UserAccount=NULL){
	  $this->UserNO = intval($UserNo);
	  $this->UserID = $UserAccount;
	  $this->UserIP = System_Helper::get_client_ip();
	  self::initialAccount();
	}   
	
	
	protected function initialAccount(){	
       
	  $Model = new Account_Model;
	   
	  // get user information
	  $DB_OBJ = $Model->DBLink->prepare(SQL_Account::GET_ACCOUNT_INFO_DATA());
	  $DB_OBJ->execute(array('uid'=>$this->UserNO));
	  $this->UserInfo = $DB_OBJ->fetch(PDO::FETCH_ASSOC);
	  
	  
	  // get user group & action limit
	  $permission = array();
	  
      $DB_GPS = $Model->DBLink->prepare(SQL_Account::GET_ACCOUNT_GROUPS());
	  if($DB_GPS->execute(array('uid'=>$this->UserNO))){
		while($tmp = $DB_GPS->fetch(PDO::FETCH_ASSOC)){
		  
		  $permission[$tmp['gid']] = array();
		  $permission[$tmp['gid']]['group_code'] = $tmp['gid'];
		  $permission[$tmp['gid']]['group_no']   = $tmp['ug_no'];
		  $permission[$tmp['gid']]['group_name'] = $tmp['ug_name'];
		  $permission[$tmp['gid']]['group_info'] = $tmp['ug_info'];
		  $permission[$tmp['gid']]['group_pri']  = $tmp['ug_pri'];
		  
		  $permission[$tmp['gid']]['master'] 	 = $tmp['master'];
		    
		  // get permission filter
		  $permission[$tmp['gid']]['group_filter'] = array();
		  $DB_FL = $Model->DBLink->prepare(SQL_Account::GET_GROUPS_ACCESS_RULES());
		  if($DB_FL->execute(array('gid'=>$tmp['gid']))){
			
			$rules =  $DB_FL->fetchAll(PDO::FETCH_ASSOC);  
			foreach($rules as $ru){
			  switch($ru['operator']){
				case 'IN'	: $condition = $ru['field']." IN('".join("','",array_filter(explode(',',$ru['contents'])))."')"; break;
                case '='	:  
                default		: $condition = $ru['field']." = '".$ru['contents']."'";	break;			
			  }
			  if( !isset($permission[$tmp['gid']]['group_filter'][$ru['table']]) ) $permission[$tmp['gid']]['group_filter'][$ru['table']] = array();

              $permission[$tmp['gid']]['group_filter'][$ru['table']][] = $condition;
			
			}
		  }
		   




		   
		  // get action map
		  $group_roles = array_keys(array_filter(json_decode($tmp['roles'],true)));
		  $permission[$tmp['gid']]['group_roles'] = $group_roles;
		  
		  
		  // get permission filter
		  $permission[$tmp['gid']]['group_action'] = array(); 
		  $role_action_map = array();
		  //if(in_array('R00',$group_roles)){
			$DB_AC = $Model->DBLink->prepare(SQL_Account::GET_GROUPS_ROLE_ACTION($group_roles));
	        if($DB_AC->execute()){
			  $actions =  $DB_AC->fetchAll(PDO::FETCH_ASSOC);  
		      foreach($actions as $act){
			    
				//$act['table'];  //controller name
				//$act['contents']//method list 
				
				if(!isset($role_action_map[$act['table']])) $role_action_map[$act['table']] = array();
				
				if($act['contents']!=''){
				  $role_action_map[$act['table']] = array_merge($role_action_map[$act['table']],array_filter(explode(',',$act['contents'])));
				  $role_action_map[$act['table']] = array_unique($role_action_map[$act['table']]);
				}
			    
			  }
		    }
		  //}
		  $permission[$tmp['gid']]['group_action'] = $role_action_map;
		  
		  if($tmp['master']){  
			$this->PermissionNow   = $permission[$tmp['gid']];
			$this->PermissionCheck = $priaction;
		  }
		
		} 
        $this->PermissionQue    = $permission;
	  }
	  unset($Model);
	}
	
	
	//-- check account profile folder & work tmp file
	protected function AccountProfile(){
	  if(!is_dir(_SYSTEM_MEMBER_PROFILE_PATH.$this->UserID)){
	    mkdir(_SYSTEM_MEMBER_PROFILE_PATH.$this->UserID,0777);
	  }
			
	  if(!is_file(_SYSTEM_MEMBER_PROFILE_PATH.$this->UserID.'\\task_work.tmp')){
		$work = array('user'=>array(),'task'=>array('wno'=>'','bid'=>'','mno'=>'','time'=>'','field'=>array(),'chk'=>'','save'=>''));
		file_put_contents( _SYSTEM_MEMBER_PROFILE_PATH.$this->UserID.'\\task_work.tmp' , json_encode($work) );
	  }
	}
	
	
	//-- 變換身份 
	public function AccountFaceOff(){
	  
	  // 變身
      if($this->UserID == 'admin'){
		/*  
		$this->ModelResult['data']['SYSTEM_AD_USER_NAME'] = 'oos0.0y@gmail.com';
	    $this->ModelResult['data']['User_Name'] = 'oos0.0y@gmail.com';
		$this->ModelResult['data']['User_No']   = 8;
		$this->ModelResult['data']['User_Pri']  = '5';
		      
		$this->ModelResult['data']['SYSTEM_AD_USER_NAME'] = ' sty0088@gmail.com';
	    $this->ModelResult['data']['User_Name'] = ' sty0088@gmail.com';
		$this->ModelResult['data']['User_No']   = 172;
		$this->ModelResult['data']['User_Pri']  = '5';	 
	    */
	  }
	  
	}
	
  }
  
  
?>