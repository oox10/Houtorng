<?php
  class Result_FILE extends View{
	public function fetch($file_address=''){
	  ob_clean();
      flush();	
	  readfile($file_address);
	}  
    
	public function render(){
	  $file_data = $this->vars['system_data']['data'];
	  header('Content-Description: File Transfer');
	  header("Content-type: ".$file_data['file_type']);
	  header('Content-Length: '.$file_data['file_size']);
      header('Content-Disposition: attachment; filename="'.$file_data['o_num'].'_'.date('Ymd').'.'.pathinfo($file_data['file_name'],PATHINFO_EXTENSION).'"');
	  header('Expires: 0');
	  header('Cache-Control: private');
	  header('Pragma: no-cache');  
      $this->fetch($file_data['file_locat']);
	  exit(1);
	}
  }
?>