<?php

class View {

    public $js;
    public $css;

    public function __construct(){

    }

    /**
     * Dibuja los archivos HTML para la estructura base del programa
     *
     * @param string $view Nombre de la vista
     * @param string $name Nombre del archivo a dibujar
     * @return void
     */
    public function render(string $view, string $name){
        require TEMPLATES. "header.php";
        require 'view/'.$view."/".$name.".php";
        require TEMPLATES. "footer.php";
    }
}