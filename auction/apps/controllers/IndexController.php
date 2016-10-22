<?php
class IndexController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        $data["title"] = "Welcome To The Auction | Home";
        $this->view->render("templates/header", $data);
        $this->view->render("templates/main_page", $data);
        $this->view->render("index/index", $data);   
        $this->view->render("templates/footer", $data);
    }
}