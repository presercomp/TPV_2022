<?php
class Salepoint extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->view->products = $this->model->getProducts();
        $this->view->render('salepoint', 'index');
    }
}