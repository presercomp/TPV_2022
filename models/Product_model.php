<?php
class Product_model extends Model {
    public function __construct(){
        parent::__construct();
    }

    public function getProducts(){                   
        try {     
            $query = "SELECT p.codigo, p.nombre, c.nombre as 'nombre_categoria', 
            p.alerta_bajo, p.alerta_critico
            FROM productos p
            INNER JOIN categorias c ON p.id_categoria = c.id_categoria";
            $select = $this->mysql->execute($query);                             
            return $select['data'];            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            return [];
            exit;
        }
    }

    public function getProduct($id){                   
        try {     
            $query = "SELECT p.codigo, p.nombre, p.id_categoria, c.nombre as 'nombre_categoria', 
            p.alerta_bajo, p.alerta_critico
            FROM productos p
            INNER JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.codigo = $id";
            $select = $this->mysql->execute($query);                             
            return $select['data'];            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            return [];
            exit;
        }
    }

    public function setProduct($items){
        try {                             
            $result = $this->mysql->insert("productos", [
                "codigo" => $items['codigo'],
                "nombre" => $items['nombre'],
                "id_categoria" => $items['categoria'],
                "alerta_bajo" => $items['alerta_bajo'],
                "alerta_critico" => $items['alerta_critico']
            ]);
            
            return $result['code'] === 201;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            print_r($e);
            return false;
            exit;
        }
    }

    public function updateProduct($data){
        try {                             
            $result = $this->mysql->update("productos", [
                "codigo" => $data['codigo'],
                "nombre" => $data['nombre'],
                "id_categoria" => $data['categoria'],
                "alerta_bajo" => $data['alerta_bajo'],
                "alerta_critico" => $data['alerta_critico']
            ], "codigo = {$data['codigo']}");
            
            return $result['code'] === 200;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            print_r($e);
            return false;
            exit;
        }
    }

    public function delProduct($id){
        try{
            $result = $this->mysql->delete("productos", "codigo = $id");
            return $result['code'] === 200;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            print_r($e);
            return false;
            exit;
        }
    }

    public function getCategories(){                   
        try {     
            $query = "SELECT * FROM categorias";
            $select = $this->mysql->execute($query);                             
            return $select['data'];            
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
            return [];
            exit;
        }
    }
    
   
}