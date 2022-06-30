<?php
class Login_model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function login($user, $pass){                   
        try {     
            $query = "SELECT * FROM usuarios WHERE rut = '$user' AND clave = '$pass'";
            //$select = $this->mysql->select("usuarios", ['*'], "rut = '$user' AND clave = '$pass'");            
            $select = $this->mysql->execute($query);                 
            return $select['code'] == 200 && count($select['data']) > 0;            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            exit;
        }
    }
    
   
}