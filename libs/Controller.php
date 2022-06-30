<?php

class Controller {

    public $model;
    public $view;

    public function __construct(){
        $this->view = new View();
    }

    /**
     * Carga un modelo determinado
     *
     * @param string $name      Nombre del modelo
     * @param string $modelPath Carpeta de ubicación del modelo
     * @return void
     */
    public function loadModel(string $name, string $modelPath = 'models/'){
        //reemplazamos los - por _ en el nombre del modelo
        $name = str_replace("-", "_", $name);
        //asignamos el nombre del modelo
        $modelName =  ucfirst($name) . '_model';        
        //creamos el nombre del archivo del modelo
        $path = $modelPath .$modelName.'.php';
        //si el archivo existe..
        if(file_exists($path)){            
            //.. cargamos el modelo
            require $path;            
            //y creamos una instancia del modelo en la propiedad model 
            $this->model = new $modelName();            
        }
    }
}