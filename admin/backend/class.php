<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
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
            // Invalid actionType
            return false;
        }
    
        // Bind parameter (userId as integer)
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