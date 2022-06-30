<?php

class MySQL extends PDO
{
    public  $pdo; 
    public  $last_error;
    private $query;    
    private $errors;
    private $connected;
    private $num_rows;

    public function __construct(string $s, string $p, string $bd, string $u, string $c)
    {
        $param = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        );
        $strConn = "mysql:host=$s;port=$p;dbname=$bd;charset=utf8";        
        try
        {    
            $this->pdo = new PDO($strConn, $u, $c, $param);            
            $this->connected = true;
        } catch(\PDOException $e) {            
            $this->connected = false;
            $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
            throw new MySQLException($this->last_error, null, $e);
            exit;
        }
    } 

    /**
     * Return if database is connected
     *
     * @return boolean
     */
    public function is_connected():bool {
        return $this->connected;
    }

    public function select(string $table, array $fields = array(), string $filter = "", string $order = "")
    {
        $data = [];
        //print_r(array("table"=>$table, "fields"=>$fields, "filter"=>$filter, "order"=>$order));                
        if ($this->is_connected()) {        
            if (strrpos($table, " ") === false) {
                $this->query = $this->get_query_select($table, $fields, $filter, $order);
                $sth = $this->pdo->prepare($this->query);
                try
                {    
                    $sth->execute();                    
                } catch(\PDOException $e) {
                    $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                    throw new MySQLException($this->last_error, null, $e);
                }
                $this->errors     = $sth->errorInfo();
                $this->last_error = $this->errors[2];
                $this->num_rows   = $sth->rowCount();
                $data             = $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $sth = $this->pdo->prepare($table);
                foreach ($fields as $key => $value) {
                    $sth->bindValue("$key", $value);
                }
                try
                {    
                    $sth->execute();                    
                } catch(\PDOException $e) {                          
                    $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                    throw new MySQLException($this->last_error, null, $e);
                }
                $this->errors     = $sth->errorInfo();
                $this->last_error = $this->errors[2];
                $this->num_rows   = $sth->rowCount();
                $data             = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
        }        
        $code = $this->get_status_code("select");
        return $this->get_response($code, $data);
    }


    public function insert(string $table, array $data)
    {
        $autoID = 0;
        if ($this->is_connected()) {
            $this->query = $this->get_query_insert($table, $data);
            $sth = $this->pdo->prepare($this->query);
            try
            {    
                $sth->execute();                    
            } catch(\PDOException $e) {
                $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                throw new MySQLException($this->last_error, null, $e);
            }        
            $autoID           = $this->pdo->lastInsertId() > 0 ? $this->pdo->lastInsertId() : 0;
            $this->errors     = $sth->errorInfo();
            $this->last_error = $this->errors[2]; 
            $this->num_rows   = $sth->rowCount();                    
        }
        $code = $this->get_status_code('insert');
        return $this->get_response($code, array("autoid"=>$autoID));        
    }


    public function update(string $table, array $data, string $condition)
    {
        if ($this->is_connected()) {
            $this->query = $this->get_query_update($table, $data, $condition);
            $sth = $this->pdo->prepare($this->query);
            try
            {    
                $sth->execute();                    
            } catch(\PDOException $e) {
                $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                throw new MySQLException($this->last_error, null, $e);
            }
            $this->errors     = $sth->errorInfo();
            $this->last_error = $this->errors[2];
            $this->num_rows   = $sth->rowCount();          
        }
        $code = $this->get_status_code('update');
        return $this->get_response($code, $data);        
    }


    public function delete(string $table, string $condicion)
    {
        if ($this->is_connected()) {
            $this->query = $this->get_query_delete($table, $condicion);
            $sth = $this->pdo->prepare($this->query);
            try
            {    
                $sth->execute();                    
            } catch(\PDOException $e) {
                $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                throw new MySQLException($this->last_error, null, $e);
            }
            $this->errors     = $sth->errorInfo();
            $this->last_error = $this->errors[2];
            $this->num_rows   = $sth->rowCount();         
        }
        $code = $this->get_status_code('delete');
        return $this->get_response($code, []);        
    }

    public function execute($sql)
    {
        $resultado = array();
        if ($this->is_connected()) {
            $sth = $this->pdo->prepare($sql);
            try
            {    
                $sth->execute();                    
            } catch(\PDOException $e) {
                $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                throw new MySQLException($this->last_error, null, $e);
            }
            $this->errors = $sth->errorInfo();
            $this->last_error = $this->errors[2];
            $this->num_rows = $sth->rowCount();
            $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        $code = $this->get_status_code('execute');
        return $this->get_response($code, $resultado);
    }


    public function truncate(string $table, bool $checkFK = false)
    {
        if ($this->is_connected()) {
            $init = $checkFK ? "SET FOREIGN_KEY_CHECKS=0;": "";
            $endit = $checkFK ? "SET FOREIGN_KEY_CHECKS=1;": "";
            $this->query = $init."TRUNCATE TABLE $table;".$endit;
            $sth = $this->pdo->prepare($this->query);
            try
            {    
                $sth->execute();                    
            } catch(\PDOException $e) {
                $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
                throw new MySQLException($this->last_error, null, $e);
            }
            $this->errors     = $sth->errorInfo();
            $this->last_error = $this->errors[2];
            $this->num_rows   = $sth->rowCount();            
        }
        $code = $this->get_status_code('truncate');
        return $this->get_response($code, array());
    }

    /**
     * return last id by autonumeric field or MySQLException
     *
     * @return integer
     */
    public function get_last_id(): int
    {
        try
        {    
            return $this->pdo->lastInsertId();
        } catch(\PDOException $e) {
            $this->last_error = $this->get_error($e->getCode(), $e->getMessage());
            throw new MySQLException($this->last_error, null, $e);
        }
        
    }

    /**
     * Return last query executed
     *
     * @return string 
     */
    public function get_last_query()
    {
        return $this->query;
    }

    
    private function get_query_select(string $table, array $fields=array(), string $filters="", string $orders=""):string
    {
        $fields = count($fields)>0 ? implode(', ', $fields) : "*";
        $sql = "SELECT $fields FROM $table";
        $sql .= strlen($filters)>0?" WHERE $filters":"";
        $sql .= strlen($orders)>0?" ORDER BY $orders":"";
        return $sql;
    }


    private function get_query_insert(string $table, array $data): string
    {
        foreach ($data as $key=>$val) {
            $eval[] = $this->format_value_type($table, $key, $val);
        }
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', $eval);
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        return $sql;
    }


    private function get_query_update(string $table, array $values, string $filter=""): string
    {
        foreach ($values as $key => $val) {
            $valstr[] = $key . ' = ' . $this->format_value_type($table, $key, $val);
        }
        $sql = "UPDATE ".$table." SET ".implode(', ', $valstr);
        $sql .= (strlen($filter)>0) ? " WHERE ".$filter.";" : ';';
        return $sql;
    }

    
    private function get_query_delete(string $table, string $filter): string
    {
        $sql = "DELETE FROM $table WHERE $filter";
        return $sql;
    }

    private function get_status_code(string $mode): int
    {
        switch ($mode) {
        case 'select':
            if ($this->errors[0] === "00000") {
                if ($this->num_rows == 0) {
                    return 204;
                } else {
                    return 200;
                }
            }
        case 'insert':
            return $this->errors[0] === "00000" ? 201 : 400;
            break;
        default:
            return $this->errors[0] === "00000" ? 200 : 400;
            break;        
        }        
    }


    private function get_error(string $code, string $message = ""): string
    {     
        switch($code) {
        case '1045':
            $msj = '[SQL-1045] Credenciales de conexión a la base de data incorrectas.';
            break;
        case '42S22':
            $msj = '[SQL-42S22] La(s) columna(s) solicitada(s) para el orderamiento/filter de data no existe(n).';
            break;
        default:
            $msj = "[SQL-$code] $message";
        }
        return $msj;
        
    }

    public function get_response(int $code, array $data)
    {
        if(count($data) == 0 && strlen($this->last_error) == 0){
            $message = "Query OK. No data found";
        } else {
            if(strlen($this->last_error) == 0){
                $message = "OK";
            } else {
                $message = $this->last_error;
            }
        }
        return array(
            "code"    => $code, 
            "data"    => $data, 
            "message" => $message
        );
    }

    protected function get_type_name(string $type): string 
    {
        $find = strpos($type, "(");
        $_type = $find > 0 ? strtolower(substr($type, 0, strpos($type, "("))) : strtolower($type);
        return $_type;
    }

    
    protected function get_max_length(string $type): string 
    {
        $start = strpos($type, "(");
        $end = $start > 0 ? strpos($type, ")") : 0;
        $length = $start > 0 && $end > 0 ? substr($type, $start+1, ($end - ($start+1))) : 0;
        $typename = $this->get_max_length($type);
        if ($length === 0) {
            switch($typename) {
            case 'timestamp':
            case  'datetime':
                $length = 19;
                break;
            case 'double':
                $length = 3;
                break;
            default:
                $length = 1;
                break;
            }
        }
        return $length;
    }


    public function format_value_type(string $table, string $field, string $value) : string
    {
        $_type = null;        
        if($value === "NULL"){
            $_return = "NULL";
        } else {
            $type = "";
            $sql = "DESCRIBE $table";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $f = $sth->fetch(PDO::FETCH_BOTH);
            do {
                if (strtolower($f["Field"]) === strtolower($field)) {
                    $type = $f["Type"];
                    break;
                }
            } while ($f = $sth->fetch(PDO::FETCH_BOTH));
            $_type = $this->get_type_name($type);
            switch($_type)
            {
                case "date":
                case "datetime":
                case "timestamp":
                case "time":
                case "year":

                case "char":
                case "varchar":
                case "nchar":

                case "tinytext":
                case "text":
                case "mediumtext":
                case "longtext":

                case "binary":
                case "varbinary":

                case "tinyblob":
                case "blob":
                case "mediumblob":
                case "longblob":

                case "enum":
                case "set":
                    $_return = "'$value'";
                 break;
                default:
                    $_return = strlen($value) > 0 ? $value : 0;
                break;
            }
        }        
        return $_return;
    }

    public function validate_type(string $table, string $field, string $value) : string
    {
        $_type = null;
        if($value === "NULL"){
            $_return = "NULL";
        } else {
            $type = "";
            $sql = "DESCRIBE $table";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $f = $sth->fetch(PDO::FETCH_BOTH);
            do {
                if (strtolower($f["Field"]) === strtolower($field)) {
                    $type = $f["Type"];
                    break;
                }
            } while ($f = $sth->fetch(PDO::FETCH_BOTH));
            $_type = $this->get_type_name($type);
            switch($_type)
            {
                case "date":
                case "datetime":
                case "timestamp":
                case "time":
                case "year":

                case "char":
                case "varchar":
                case "nchar":

                case "tinytext":
                case "text":
                case "mediumtext":
                case "longtext":

                case "binary":
                case "varbinary":

                case "tinyblob":
                case "blob":
                case "mediumblob":
                case "longblob":

                case "enum":
                case "set":
                    $_return = "string";
                 break;
                default:
                    $_return = "numeric";
                break;
            }
        }
        $_isValid = (is_numeric($value) && $_return == "numeric") || (!is_numeric($value) && $_return == "string") || $_return === "NULL" ? "true" : "false";       
        return $_isValid;
    }
}
