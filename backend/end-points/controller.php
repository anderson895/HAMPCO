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

            // Call the RegisterMember function
            $result = $db->RegisterMember($fname, $mname, $email, $phone, $role, $sex, $id_number, $password);

            // Check the result of the registration attempt
            if ($result === true) {
                // Registration successful
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registration successful!'
                ]);
            } else {
                // If the result is a string (i.e., error message like email already exists)
                echo json_encode([
                    'status' => 'error',
                    'message' => $result // Return the error message from RegisterMember (e.g., 'Email is already registered.')
                ]);
            }
            
            
            
        }else if ($_POST['requestType'] == 'LoginMember') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $db->LoginMember($email, $password);

            if ($result['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'data' => $result['data'] 
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $result['message'] 
                ]);
            }
        }else if ($_POST['requestType'] == 'Login_Admin') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $result = $db->LoginAdmin($username, $password);

            if ($result['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'data' => $result['data'] 
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $result['message'] 
                ]);
            }
        }else{
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>