<?php
require_once 'Api.php';

class RestApi extends Api {
    
    private $db;
    
    public function __construct($request) {
        parent::__construct($request);
        $this->db = new MysqlDatabase();
    }
    
    public function items($arg, $verbs = "")
    {
       if($this->method == "GET")
       {
        if(empty($arg) && $verbs == "")
        {
            $get_items = "SELECT * FROM items";
        }
        else if(!empty($arg) && $verbs != "")
        {
            if($arg[0] == "name" && $verbs == "sorting")
            {
                $get_items = "SELECT * FROM items ORDER BY name ASC";
            }
            else if($arg[0] == "bidding" && $verbs == "sorting")
            {
                $get_items = "SELECT i.id, i.name, i.description, i.image_url, COUNT(b.item_id) AS 'num_of_bidding' FROM items AS i LEFT JOIN bids AS b ON i.id = b.item_id GROUP BY i.id ORDER BY num_of_bidding DESC";
            }
            else
            {
                return $this->jsonResponse(array("error"=>"Error occured"), 404);
            }
        }
        else if(!empty($arg) && is_numeric($arg[0]))
        {
            $get_bidding = "SELECT bid_id, bidder_name, details, bid_amount FROM bids WHERE item_id = {$this->db->sanitizeInput($arg[0])}";
            $get_items = "SELECT * FROM items WHERE id = {$this->db->sanitizeInput($arg[0])}";
            $this->db->executeQuery($get_bidding);
            $bidding_arr = $this->db->getRows();
            for($i = 0; $i < count($bidding_arr); $i++)
            {
                $bidding_arr[$i]["links"] = array("rel"=>"biddings", "href"=>"http://localhost/auction/rest/api/v1/biddings/".$bidding_arr[$i]["bid_id"]);
            }
            }
        else
        {
            return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource doesnot exists.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);
        }
        $this->db->executeQuery($get_items);
        if($this->db->getNumRows() > 0)
        {
        $items_arr = $this->db->getRows();
        //print_r($items_arr);
            for($i = 0; $i < count($items_arr); $i++)
            {
                if(array_key_exists("num_of_bidding", $items_arr[$i]))
                {
                    unset($items_arr[$i]["num_of_bidding"]);
                }
                $items_arr[$i]["links"] = array("rel"=>"self", "href"=>"http://localhost/auction/rest/api/v1/items/".$items_arr[$i]["id"]);
                if(!empty($arg) && is_numeric($arg[0]))
                {
                    if(!empty($bidding_arr))
                    {
                $items_arr[$i]["biddings"] = $bidding_arr; 
                    }
                    else
                    {
                        $items_arr[$i]["biddings"] = array("null");
                    }
                }
            }    
            return $this->jsonResponse(array("items"=>$items_arr));
        }
        else
        {
            return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource doesnot exists.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);
        }
            
      }
       
    }
    
    public function biddings($args, $verbs = "")
    {
        if($this->method == "POST")
        {
            if(empty($args) && $verbs == "")
            {
                $item_id = $this->db->sanitizeInput($this->request["item_id"]);
                $name = $this->db->sanitizeInput($this->request["name"]);
                $details = $this->db->sanitizeInput($this->request["details"]);
                $bid_amount = $this->db->sanitizeInput($this->request["bid_amount"]);
                $insert_query = "INSERT INTO bids(item_id, bidder_name, details, bid_amount) VALUES($item_id, '$name', '$details', $bid_amount)";
                $this->db->executeQuery($insert_query);
                return $this->jsonResponse(array("status"=>"success", "message"=>"Resource successfully created"));
            }
        }
        
        if($this->method == "DELETE")
        {
            
            if(!empty($args) && is_numeric($args[0]))
            {
                $bid_id = $this->db->sanitizeInput($args[0]);
                //$check_bid_exists_or_not = "SELECT * FROM bids WHERE bid_id = {$bid_id}";
                //$this->db->executeQuery($check_bid_exists_or_not);
                if($this->isBidExists($bid_id))
                {
                $delete_query = "DELETE FROM bids WHERE bid_id = {$bid_id}";
                $this->db->executeQuery($delete_query);
                return $this->jsonResponse(array("status"=>"success", "message"=>"Resource successfully deleted"));
                }
                else
                {
                    return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource could not be deleted.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);
                }
            }
            else if(empty($args) && $verbs == "")
            {
                $delete_all_query = "DELETE FROM bids";
                $this->db->executeQuery($delete_all_query);
                return $this->jsonResponse(array("status"=>"success", "message"=>"Resource successfully deleted"));
            }
            else
            {
                return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource could not be deleted.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);
            }
        }
        
        if($this->method == "PUT")
        {
            if(!empty($args) && is_numeric($args[0]))
            {
            $bid_id = $this->db->sanitizeInput($args[0]);
            $details = $this->db->sanitizeInput($this->request["details"]);
            $bid_amount = $this->db->sanitizeInput($this->request["bid_amount"]);
            if($this->isBidExists($bid_id))
            {
            $update_query = "UPDATE bids SET details = '{$details}', bid_amount = {$bid_amount} WHERE bid_id = {$bid_id}";
            $this->db->executeQuery($update_query);
            return $this->jsonResponse(array("status"=>"success", "message"=>"Resource successfully updated"));  
            }
            else
            {
               return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource could not be updated.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404); 
            }
            }
            else
            {
                return $this->jsonResponse(array("error"=>"Bad Request"), 400);
            }
        }
        
        if($this->method == "GET")
        {
            if(empty($args) && $verbs == "")
            {
                $get_bid = "SELECT bid_id, bidder_name, details, bid_amount, item_id FROM bids";
                $this->db->executeQuery($get_bid);
                $bids = $this->db->getRows();
                $item_arr = array();
                foreach($bids as $bid)
                {
                    $this->db->executeQuery("SELECT * FROM items WHERE id = {$bid['item_id']}");
                    foreach($this->db->getRows() as $cont)
                    {
                        $item_arr [] = $cont;
                    }
                } 
                
                for($i = 0; $i < count($item_arr); $i++)
                {
                    $item_arr[$i]["links"] = array("rel"=>"items", "href"=>"http://localhost/auction/api/v1/items/".$item_arr[$i]["id"]);
                }
                
            }
            else if(!empty($args) && is_numeric($args[0]))
            {
                if($this->isBidExists($args[0]))
                {
                $get_bid = "SELECT bid_id, bidder_name, details, bid_amount, item_id FROM bids WHERE bid_id = {$this->db->sanitizeInput($args[0])}";
                $this->db->executeQuery($get_bid);
                $bids = $this->db->getRows();
                $item_arr = array();
                foreach($bids as $bid)
                {
                    $this->db->executeQuery("SELECT * FROM items WHERE id = {$bid['item_id']}");
                    foreach($this->db->getRows() as $cont)
                    {
                        $item_arr [] = $cont;
                    }
                } 
                
                for($i = 0; $i < count($item_arr); $i++)
                {
                    $item_arr[$i]["links"] = array("rel"=>"items", "href"=>"http://localhost/auction/api/v1/items/".$item_arr[$i]["id"]);
                }
                }
                else
                {
                   return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource could not found.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);  
                }
            }
            else
            {
               return $this->jsonResponse(array("errors"=>array(
                                          "message" => "Sorry, the requested resource does not exist.",
                                          "internal_msg" => "No items found in the database"
                                         )), 404);  
            }
            $this->db->executeQuery($get_bid);
            $bids_array = $this->db->getRows();
            //print_r($bids_array);
            for($i = 0; $i < count($bids_array); $i++)
            {
                $bids_array[$i]["links"] = array("rel"=>"self", "href"=>"http://localhost/auction/api/v1/biddings/".$bids_array[$i]["bid_id"]);
                $bids_array[$i]["item"] = $item_arr[$i];
                unset($bids_array[$i]["item_id"]);
            }
            return $this->jsonResponse(array("biddings"=>$bids_array));
            
        }
    }
    
    private function isBidExists($bid_id)
    {
        $exists = false;
        $check_bid_exists_or_not = "SELECT * FROM bids WHERE bid_id = {$bid_id}";
        $this->db->executeQuery($check_bid_exists_or_not);
        if($this->db->getNumRows() > 0)
        {
            $exists = true;
        }
        return $exists;
    }
   
}