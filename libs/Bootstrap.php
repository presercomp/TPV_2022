<?php

class Bootstrap
{
    private $_url             = null;
    private $_controller      = null;
    private $_controllerPath  = 'controller/';
    private $_modelPath       = 'model/';
    private $_defaultFile     = 'index.php';
    private $_errorFile       = 'fail.php';
    
    /**
     * Método de inicialización de la librería
     *
     * @return void
     */
    public function init(){
        $this->_getURL();
        //Si la URL está vacía...
        if(empty($this->_url[0])){
            //...cargamos el controlador por defecto
            $this->_loadDefaultController();
            //y salimos del método init()
            return false;
        }
        //Si la URL no está vacia, llamamos al controlador existente
        $this->_loadExistingController();
        //Cargamos lo métodos del controlador
        $this->_callControllerMethods();
    }

    /**
     * Obtiene y parsea la URL
     *
     * @return void
     */
    private function _getURL(){
        //Si tiene una URL invocada, la captura
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        //Reemplazamos todos los - por _ en la URL
        $url = str_replace("-", "_", $url);
        //Quitamos cualquier espacio que pudiera haber al inicio y final de la URL 
        $url = trim($url, "/");
        //Sanitizamos la URL
        $url = filter_var($url, FILTER_SANITIZE_URL);
        //y finalmente, dividimos la URL en trozos usando como separador el simbolo /
        $this->_url   = explode('/', $url);
    }

    /**
     * Carga el controlador por defecto.
     *
     * @return void
     */
    private function _loadDefaultController(){
        //require nos obliga a requerir un archivo especifico.
        require $this->_controllerPath.$this->_defaultFile; //controller/index.php
        //Creamos una instancia del modelo Index
        $this->_controller = new Index();
        //Invocamos al método loadModel presente en la herencia de la clase
        $this->_controller->loadModel('index');
        //Invocamos al método index
        $this->_controller->index();
    }

    /**
     * Carga un controlador existente
     *
     * @return void
     */
    private function _loadExistingController(){
        //Creamos el posible nombre del controlador a partir de la URL
        $controllerName = $this->_url[0];
        //Creamos el posible nombre de archivo del controlador
        $file = $this->_controllerPath.$controllerName.".php";
        //Si existe el archivo...
        if(file_exists($file)){
            //... lo cargamos
            require $file;
            //e invocamos al método del controlador
            $this->_controller = new $controllerName();
            $this->_controller->loadModel($this->_url[0]);
        } else {
            //Si no existe, invocamos al error 404 para desplegarlo
            $this->_error("404");
            //y salimos de la ejecución del código
            exit;
        }
    }

    /**
     * Invoca a los métodos del controlador
     *
     * @return void
     */
    private function _callControllerMethods(){
        //contamos la cantidad de parámetros invocados por URL
        $lenght = count($this->_url);
        //Si tengo más de 1 parametro
        if($lenght > 1){
            //verifico si existe el método, y si no existe
            if(!method_exists($this->_controller, $this->_url[1])){
                //invocamos el método para mostrar el error
                $this->_error("404");
                //y salimos de la aplicación
                exit;
            }
            //defino el nombre del método invocado
            $methodName = $this->_url[1];
                    
            //cargo el método con los parametros, dependiendo de la cantidad invocada.
            switch($lenght){
                case 5:
                    $this->_controller->{$methodName}($this->_url[2], $this->_url[3], $this->_url[4]);
                    break;
                case 4:
                    $this->_controller->{$methodName}($this->_url[2], $this->_url[3]);
                    break;
                case 3:
                    $this->_controller->{$methodName}($this->_url[2]);
                    break;
                case 2:
                    $this->_controller->{$methodName}();
                    break;
                default:
                    $this->_controller->index();
                    break;
            }
        } else {
            $this->_controller->index();
        }
        
    }

    /**
     * Despliega la página de errores
     *
     * @param string $type
     * @return void
     */
    private function _error(string $type){
        //requerimos el archivo de clase de errores
        require $this->_controllerPath.$this->_errorFile;
        //creamos instancia de la clase Error
        $this->_controller = new Fail();
        //invocamos al método index del objeto Error
        $this->_controller->index($type);
        exit;
    }

}