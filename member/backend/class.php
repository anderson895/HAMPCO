<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }








     public function CreateTask($material_name, $material_category, $rm_status, $raw_materials_details)
    {
        $query = $this->conn->prepare("
            INSERT INTO `task` 
                (`task_name`, `task_material`, `task_category`, `date_start`, `status`) 
            VALUES (?, ?, ?, NOW(), ?)
        ");
        $query->bind_param("ssss", $material_name, $raw_materials_details, $material_category, $rm_status);

        $result = $query->execute();
        $query->close();

        return $result;
    }
    







    public function get_list_task()
    {
        $stmt = $this->conn->prepare("SELECT * FROM task");
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        return $result;
    }


    public function get_raw_materials_details($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM raw_materials WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();  // fetch one row as assoc array
        $stmt->close();
        return $data;
    }




    public function markAsDone($task_id, $status) {
    $query = $this->conn->prepare("UPDATE `task` SET `status` = ?, `date_end` = NOW() WHERE `task_id` = ?");
    $query->bind_param("si", $status, $task_id);

    if ($query->execute()) {
            return 'success';
        } else {
            return 'Execute failed: ' . $query->error;
        }
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
                'quantity_unit' => $row['rm_quantity']
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