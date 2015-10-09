<?php
 
  // ���J�]�w
  session_start();
  require_once "../conf/system_config.php";
  
  
  $include_path = array (); 
  $include_path[] = get_include_path();

  // �ثe�M�שһݭn�� include_path
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\core';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\main';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\lib';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\lang';
  $include_path[] = _SYSTEM_ROOT_PATH . 'mvc\templates';
  
  set_include_path(join(PATH_SEPARATOR, $include_path));
  
  // �۰ʸ��J���O
  function __autoload($class_name){
    require_once $class_name . '.php';
  }
 
  // ����������ʧ@
  $controller = new Controller_WebSite();
  $controller->setRouter(new Router,'_SITE');
  $controller->run();

  
?>