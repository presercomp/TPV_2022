<?php
class Login extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['user']) && isset($_POST['pass'])){
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            try {                
                if(boolval($this->model->login($user, $pass))){                    
                    $_SESSION['user'] = $user;
                    header('Location: '.URL.'dashboard');
                } else {
                    echo "noxapama";
                    header("Location: ".URL."index&error=login_fail");    
                }
            }catch (Exception $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
            }
        } else {            
            header("Location: index&error=require_login");
        }
    }
}
