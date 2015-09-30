<?php
  class DBModule{
   
	private $DB_Name	 = _SYSTME_DB_NAME;
	private $DB_User	 = _SYSTEM_DB_USER;
    private $DB_Password = _SYSTEM_DB_PASS;
	private $DB_Host	 = _SYSTEM_DB_LOCA;
	
	public $DBLink;
	public $DBSql;
	
    public function db_connect($DBMode='MySql'){
	  switch($DBMode){
	    case 'MySql':
	      try {
            
			$this->DBLink = new PDO("mysql:host=".$this->DB_Host.";dbname=".$this->DB_Name.';charset=utf8', $this->DB_User, $this->DB_Password);
			$sql = "SET NAMES 'utf8'";  // The SQL SELECT statement
            $stmt = $this->DBLink->query($sql); // fetch into an PDOStatement object
            
			//偵錯模式
			$this->DBLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//取得 SQL 群組
			$this->DBSql = new SQL_Mysql; 
          
		  }
          
		  catch(PDOException $e){
            echo $e->getMessage();
          }
	      break;	  
	  }
	}
  
  
  }
  
?>