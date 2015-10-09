<?php
 
  // 載入設定
  session_start();
  require_once "../conf/system_config.php";
  
  
  $include_path = array (); 
  $include_path[] = get_include_path();

  // 目前專案所需要的 include_path
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\core';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\main';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\lib';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\lang';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\templates';
  
  set_include_path(join(PATH_SEPARATOR, $include_path));
  
  // 自動載入類別
  function __autoload($class_name){
    require_once $class_name . '.php';
  }
 
  // 執行對應的動作
  $controller = new Controller_WebSite();
  $controller->setRouter(new Router,'_SITE');
  $controller->run();

  
?>