<?php

// Get Controller & Action From URL Query Params
$controller = $_GET["controller"] ?? null;
$action = $_GET["action"] ?? null;

// Try to Declare Controller Instance and then call Action Method, if wrong then header to error 404 page
try {
    $controllerPath = "controllers/".$controller."_controller.php";

    if(!file_exists($controllerPath)) {
        throw new Exception("Controller File Path is not exist");
    }

    require_once($controllerPath);

    $controllerClassName = ucwords($controller)."Controller";
    
    $controllerInstance = new $controllerClassName;

    if(!method_exists($controllerInstance, $action)) {
        throw new Exception("Action Method is not exist");
    }
    
    $controllerInstance->$action();
} catch(Exception $e) {
    header("Location:?controller=error&action=error404");
}
