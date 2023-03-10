<?php
define('SP', DIRECTORY_SEPARATOR);
define('TEMPLATES', dirname(__DIR__) . SP . 'templates' . SP);

class View {
    public static function load($viewName, $data = []){
        $viewFile = TEMPLATES.$viewName.'.php';
        if (file_exists($viewFile)) {
            // ob_start();
            extract($data);
            require($viewFile);
            // ob_end_flush();
        }
        else{
            echo "this view does not exists";
        }
    }
}