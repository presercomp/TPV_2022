<?php

class Model {
    public $mysql;
    
    function __construct(){
       try{
        $this->mysql = new MySQL(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);        
       } catch (Exception $e) {
           echo 'Excepción al cargar modelo: ', $e->getMessage(), "\n";
       }
    }
}