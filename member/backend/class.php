<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }



    public function get_raw_materials()
    {
        $stmt = $this->conn->prepare("SELECT rm.id as rmid, rm.rm_name,rm.rm_quantity FROM raw_materials as rm");
        $stmt->execute();
        $result = $stmt->get_result();
    
        $materials = [];
        while ($row = $result->fetch_assoc()) {
            $materials[] = [
                'id' => $row['rmid'],
                'name' => $row['rm_name'],
                'quantity&unit' => $row['rm_quantity']
            ];
        }
    
        $stmt->close();
        return $materials;
    }
    



public function check_account($id) {

    $id = intval($id);

    $query = "SELECT * FROM user_member WHERE id = $id";

    $result = $this->conn->query($query);

    $items = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }
    return $items; 
}

    



}