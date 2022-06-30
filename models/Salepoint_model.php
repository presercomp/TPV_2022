<?php
class Salepoint_model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function getProducts(){                   
        try {     
            $query = "SELECT * FROM productos";
            $select = $this->mysql->execute($query);                             
            return $select['data'];            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            return [];
            exit;
        }
    }
    
   
}