<?php 
  
  class Error_Controller extends Admin_Controller{
	
    public function index($message = "no information about this error"){
	  echo '<pre>'.print_r($message).'<pre>';
	}
	
    public function error($message = "no information about this error"){
	  self::data_output('error','',array(array('action'=>false,'message'=>$message)));
	  //echo '<pre>'.print_r($message).'<pre>';
	}	
	
  } 
  
?>