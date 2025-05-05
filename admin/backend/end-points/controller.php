<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'MemberVerification') {
            
            $actionType = $_POST['actionType'];
            $userId = $_POST['userId'];
            
            $result = $db->RegisterMember($actionType, $userId);
            
            if ($result === true) {
                echo json_encode([
                    'status' => 'success',
                    'message' => ucfirst($actionType) . ' successful!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Operation failed. Please try again.'
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