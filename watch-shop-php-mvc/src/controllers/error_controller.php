<?php
require_once("controllers/common/base_controller.php");

class ErrorController extends BaseController {
    protected function getFolder()
    {
        return "error_pages";
    }
}