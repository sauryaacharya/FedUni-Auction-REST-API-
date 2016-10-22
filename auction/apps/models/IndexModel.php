<?php
class IndexModel extends Model {
    
    public function __construct() {
        parent::__construct();     
    }
    
    /*
    public function getAllItemsInAuction()
    {
        $curl = curl_init("http://localhost/auction/rest/api/v1/items");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $item_arr = json_decode(curl_exec($curl), TRUE);
        $all_item = array();
        curl_close($curl);
        foreach($item_arr as $key=>$value)
        {
            foreach($value as $item)
            {
                $all_item [] = $item;
            }
        }
        return $all_item;
    }
     * 
     */
    
}