<?php
 
  // 載入設定
  session_start();
  require_once "../conf/system_config.php";
  require_once('../mvc/lib/PHPMailer_5.2.4/class.phpmailer.php');
  
  
  $include_path = array (); 
  $include_path[] = get_include_path();

  // 目前專案所需要的 include_path
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/core';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/main';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/templates';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/lib';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/dbsql';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc/helper';
 
  set_include_path(join(PATH_SEPARATOR, $include_path));
  
  spl_autoload_register(function($className) {
    require_once $className . '.php';  
  });
  
  try{
	$router = new ADRouter();
	$router->route(new Request_url);
  }catch(Exception $e){
	$controller = new Error_Controller();
	$controller->error($e->getMessage());
  } 
  
?>