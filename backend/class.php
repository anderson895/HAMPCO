<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


    public function RegisterMember($fname, $mname, $email, $phone, $role, $sex, $id_number, $password)

    {
        $fullname = $fname . ' ' . $mname;
    
     
    
        // Hash the password here
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query = $this->conn->prepare("
            INSERT INTO `user_member` 
                (`fullname`, `email`, `phone`, `password`, `role`, `sex`, `id_number`)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
    
        $result = $query->execute([
            $fullname,
            $email,
            $phone,
            $hashedPassword,
            $role,
            $sex,
            $id_number
        ]);
    
        return $result;
    }
    
    



public function check_account($id) {

    $id = intval($id);

    $query = "SELECT * FROM user WHERE id = $id";

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