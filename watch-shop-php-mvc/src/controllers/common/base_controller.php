<?php

abstract class BaseController {
    protected $folderName;
    protected $layoutName;

    public function __construct()
    {
        $this->folderName = $this->getFolder();
    }

    abstract protected function getFolder();

    protected function render($fileName, $viewData = [], $layoutName = null) {
        // Extract $viewData to variables that will be used in view file
        extract($viewData);

        // Make view file path
        $viewFilePath = "views/".$this->folderName."/".$fileName.".php";

        // Check if $layoutName param and defaultLayoutName is both null, then load contentView
        if(!isset($layoutName) && !isset($this->layoutName)) {
            include_once($viewFilePath);
            return;
        }

        // Check if viewFile is exist then assign viewContent in $content variable that should be echo in layout
        ob_start();
        include_once($viewFilePath);
        $content = ob_get_clean();

        // Make layout file path & load layout
        $layoutFilePath = "views/layouts/".($layoutName ?? $this->layoutName)."_layout.php";

        include($layoutFilePath);
    }
}