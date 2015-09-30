<?php
  class Result_IMAGE extends View{
    
	public function fetch(){
	  ini_set('memory_limit', '100M');
	  $args = func_get_args();
	  
	  /*
	  if(preg_match('/png/',$args[0])){
	    $image_p = imagecreatefrompng($args[0]);
	  }else{
	    $image_p = imagecreatefromjpeg($args[0]);
	  }
	  return imagejpeg($image_p,NULL,100);
	  */
	  
	  return file_get_contents($args[0]);
	  
	  
	}  
    
	public function render($ImageData = array()){
	 
	  $image_info = $ImageData;
	  
	  
	  header('Content-Type:'.$image_info['data']['type']);  //header('Content-Type: '.image_type_to_mime_type(exif_imagetype($image_info['data']['name'])));
	  print $image_info['data']['cont'];
	}
  }



?>