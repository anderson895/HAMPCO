<?php
include ('dbconnect.php');
date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }



      public function check_account($user_id ) {
        $user_id  = intval($user_id);
        $query = "SELECT * FROM user_customer WHERE customer_id  = $user_id";
        $result = $this->conn->query($query);
        $items = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }


    

    public function fetch_user_info($userID){
        $query = $this->conn->prepare("SELECT * FROM user_customer where customer_id = '$userID'");
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    
    

      public function fetch_all_categories(){
        $query = $this->conn->prepare("SELECT * FROM product_category");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    
    


     public function fetch_all_product() {
        $query = $this->conn->prepare("SELECT 
                product.*, 
                product_category.*
            FROM product
            LEFT JOIN product_category
            ON product.prod_category_id = product_category.category_id
            where prod_status='1'
        ");
    
        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }
    
    
     

}