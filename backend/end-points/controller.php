<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'RegisterMember') {
            $fname = $_POST['first-name'];
            $mname = $_POST['last-name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $sex = $_POST['sex'];
            $id_number = $_POST['id_number'];
            $password = $_POST['password'];
            $confirmpass = $_POST['confirm-password'];
            $phone = $_POST['phone'];
            
            $result = $db->RegisterMember($fname, $mname, $email, $phone, $role, $sex, $id_number, $password);
            
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
            }
            
            
            
        } else {
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>