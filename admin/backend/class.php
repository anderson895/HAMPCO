<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


     public function list_stock_logs()
    {
        $stmt = $this->conn->prepare("SELECT 
        stock_history.stock_id,
        stock_history.stock_type,
        stock_history.stock_outQty,
        stock_history.stock_changes,
        stock_history.stock_date,
        raw_materials.id as raw_id,
        raw_materials.rm_name,
        user_member.id as user_id,
        user_member.fullname,
        user_member.role,
        user_member.id_number
        FROM stock_history
        LEFT JOIN user_member
        ON user_member.id = stock_history.stock_user_id 
        LEFT JOIN raw_materials
        ON raw_materials.id = stock_history.stock_raw_id  
        ");
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        return $result;
    }


     public function get_list_task()
    {
        $stmt = $this->conn->prepare("SELECT 
        task.task_id,
        task.task_user_id,
        task.task_name,
        task.task_material,
        task.task_category,
        task.date_start,
        task.date_end,
        task.status as task_status,
        user_member.id as user_id,
        user_member.fullname,
        user_member.role,
        user_member.id_number
        FROM task
        LEFT JOIN user_member
        ON user_member.id = task.task_user_id
        ");
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
        $data = $result->fetch_assoc();  
        $stmt->close();
        return $data;
    }



    public function delete_raw_material($id)
    {
        $query = $this->conn->prepare("
            DELETE FROM `raw_materials` 
            WHERE `id` = ?
        ");

        $query->bind_param("i", $id);
        
        $result = $query->execute();
        $query->close();

        return $result;
    }



    public function update_raw_material($id, $name, $desc, $qty, $status)
    {
        $query = $this->conn->prepare("
            UPDATE `raw_materials` 
            SET `rm_name` = ?, `rm_description` = ?, `rm_quantity` = ?, `rm_status` = ? 
            WHERE `id` = ?
        ");
    
        $query->bind_param("ssisi", $name, $desc, $qty, $status, $id);
        
        $result = $query->execute();
        $query->close();
    
        return $result;
    }
    

    public function AddRawMaterials($rm_name, $rm_description, $rm_qty, $rm_status)
    {
        $query = $this->conn->prepare("
            INSERT INTO `raw_materials` (`rm_name`, `rm_description`, `rm_quantity`, `rm_status`)
            VALUES (?, ?, ?, ?)
        ");

        $query->bind_param("ssss", $rm_name, $rm_description, $rm_qty, $rm_status);

        $result = $query->execute();
        $query->close();

        return $result;
    }


  
    

    public function RegisterMember($actionType, $userId)
    {
        if ($actionType == "verify") {
            $query = $this->conn->prepare("
                UPDATE `user_member`
                SET `status` = '1'
                WHERE `id` = ?
            ");
        } else if ($actionType == "decline") {
            $query = $this->conn->prepare("
                DELETE FROM `user_member`
                WHERE `id` = ?
            ");
        } else {
            return false;
        }
        $query->bind_param("i", $userId);
    
        $result = $query->execute();
        $query->close();
    
        return $result;
    }
    





    public function fetch_all_non_verify_member() {

        $sql = "SELECT 
                    um.id AS umid, 
                    um.id_number AS umid_number, 
                    um.fullname AS umfullname, 
                    um.email AS umemail, 
                    um.phone AS umphone, 
                    um.role AS umrole, 
                    um.sex AS umsex, 
                    um.date_created AS umdate_created, 
                    um.status AS umstatus
                FROM user_member AS um
                WHERE um.status != '1'
                ORDER BY um.id ASC";
    
        $result = $this->conn->query($sql);
        return $result;
    
    }
    
    
    public function fetch_all_materials() {

        $sql = "SELECT 
                    rm.id AS rmid, 
                    rm.rm_name,
                    rm.rm_description,
                    rm.rm_quantity,
                    CASE 
                        WHEN rm.rm_quantity = 0 THEN 'Out of Stocks'
                        ELSE rm.rm_status
                    END AS rm_status
                FROM raw_materials AS rm
                ORDER BY rm.id ASC";
    
        $result = $this->conn->query($sql);
        return $result;
    
    }
    




public function check_account($id) {

    $id = intval($id);

    $query = "SELECT * FROM user_admin WHERE id = $id";

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