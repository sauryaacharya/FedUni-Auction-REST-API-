<?php
class ItemController extends Controller {
    
    public function __construct(Registry $registry, Model $model) {
        parent::__construct($registry, $model);
        
    }
    
    public function index()
    {
        header("Location:http://localhost/auction");
        exit;
    }
    
    public function view($id = NULL)
    {
        if($id == NULL)
        {
            $controller = new ErrorController($this->registry, new ErrorModel());
            $controller->index();
        }
        else if($id != NULL && is_numeric($id))
        {
            if(array_key_exists("errors", $this->model->getItemById($id)))
            {
                $controller = new ErrorController($this->registry, new ErrorModel());
                $controller->index();
                exit;
            }
            else
            {
                $all_item = array();
                foreach($this->model->getItemById($id) as $key=>$value)
                {
                    foreach($value as $item)
                    {
                        unset($item["biddings"]);
                        $all_item [] = $item;
                    }
                }
        $data["item_details"] = $all_item;
        $data["title"] = $all_item[0]["name"];
        $this->view->render("templates/header", $data);
        $this->view->render("templates/main_page", $data);
        $this->view->render("item/view", $data);   
        $this->view->render("templates/footer", $data);
            }
        }
        else
        {
          $controller = new ErrorController($this->registry, new ErrorModel());
          $controller->index();  
        }
    }
}