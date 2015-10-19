<?php

  class Result_HTML extends View{
    
	//取得檔案名稱參數   $template_filename = $args[0]
	//讀取對應 template 檔案 並輸出
	
	
	//呈獻資料縮短
	public function Shorten_Text($term,$length){
	  $CleanTerm = preg_replace('@<.*?>@','',$term);
	  if(mb_strlen($CleanTerm)>$length){
	    $text1=mb_substr($CleanTerm,0,$length);
	    $printout="<ins title=\"".$CleanTerm."\" >".$text1."..</ins>";
	  }else{
	    $printout=$CleanTerm;
	  }
	  return $printout;
    }
	
	public function fetch(){
	   $args = func_get_args();
       $template_filename = $args[0];
       //開啟緩衝  放入 $html 中 並傳回
       $html = '';
	   ob_start();
       
	   if(is_file(_SYSTEM_ROOT_PATH.'mvc/templates/'.$template_filename)){
	     include _SYSTEM_ROOT_PATH.'mvc/templates/'.$template_filename;
	   }else{
	     $this->vars['message'] = '找不到網頁，或瀏覽器版本不符'; 
	     include _SYSTEM_ROOT_PATH.'mvc/templates/wrong.html5tpl.php';
	   }
	   $html = ob_get_contents();
       ob_end_clean();
       
	    // 轉換翻譯
	    $lang_pattern = array();
	    $lang_conf = isset($_SESSION['language']) ? _SYSTEM_ROOT_PATH.'mvc/lang/'.$_SESSION['language'].'.conf' : _SYSTEM_ROOT_PATH.'mvc/lang/meta_eng.conf';
	   
	    if ($handle = fopen($lang_conf,'r')) {
		  while (($buffer = fgets($handle, 4096)) !== false) {
		    if(!preg_match('/^#/',$buffer) && trim($buffer)){
			  list($lpatt,$lstring) = explode('=',$buffer);
			  $lang_pattern['/'.preg_replace('/(\$|\{|\})/','\\\\\1',trim($lpatt)).'/'] = trim($lstring);
			} 
		  }
          fclose($handle);
		  
		  $html_source = $html;
	      if(count($lang_pattern)){
		    $html = preg_replace(array_keys($lang_pattern),array_values($lang_pattern),$html_source);
		  }else{
		    $html = $html_source;
		  }
	    }
		
	    return preg_replace('/\$\{(.*?)\}/','\\1',$html);
	}  
    
	public function render(){
	   // 因為 View 類別的 render 函式沒有參數
       // 所以 render 要自行取得
       $args = func_get_args();
       $template_filename = $args[0].'.html5tpl.php';
       
       header('Content-Type: text/html; charset=utf-8');
       
	   echo $this->fetch($template_filename);
	}
  }
?>