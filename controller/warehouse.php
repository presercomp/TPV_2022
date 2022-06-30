<?php
class Warehouse extends Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->view->render('warehouse', 'index');
    }
}