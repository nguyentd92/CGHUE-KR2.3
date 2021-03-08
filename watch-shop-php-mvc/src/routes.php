<?php

// Get Controller & Action From URL Query Params
$controller = $_GET["controller"] ?? null;
$action = $_GET["action"] ?? null;

// Declare Controller Instance and then call Action Method
require_once("controllers/".$controller."_controller.php");

$controllerClassName = ucwords($controller)."Controller";

$controllerInstance = new $controllerClassName;

$controllerInstance->$action();