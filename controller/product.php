<?php
class Product extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->view->products = $this->model->getProducts();
        $this->view->render('product', 'index');
    }

    public function add(){
        if($this->model->setProduct($_POST)){
            header('location: '.URL.'product');
        }
    }

    public function new(){
        $this->view->categories = $this->model->getCategories();
        $this->view->render('product', 'new');
    }

    public function edit(){
        $this->view->categories = $this->model->getCategories();
        $this->view->product = $this->model->getProduct($_GET['id']);
        $this->view->render('product', 'edit');
    }

    public function update(){
        if($this->model->updateProduct($_POST)){
            header('location: '.URL.'product');
        }
    }

    public function delete(){        
        if($this->model->delProduct($_GET['id'])){
            header('location: '.URL.'product');
        }
    }

}