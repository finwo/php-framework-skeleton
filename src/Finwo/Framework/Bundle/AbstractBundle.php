<?php

namespace Finwo\Framework\Bundle;

use Klein\Klein;

abstract class AbstractBundle
{
  public function __construct( Klein $router )
  {
    // Fetch info
    $class_info     = new \ReflectionClass($this);
    $path           = dirname($class_info->getFileName());
    $controllerPath = $path . DS . 'Controller';
    
    // Fetch controllers
    $controllers = array();
    foreach( glob($controllerPath.DS.'*.php') as $file ) {
      $class = explode("\\", get_class($this));
      array_pop($class);
      $class = implode("\\", $class) . "\\Controller\\" . @array_shift(explode('.',array_pop(explode(DS,$file))));
      if(!class_exists($class)) continue;
      die('Registering controller: '.$class);
    }
  }
}
