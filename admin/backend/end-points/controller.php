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
            


        }else if ($_POST['requestType'] == 'AddRawMaterials') {
            
            $rm_name = $_POST['rm_name'];
            $rm_description = $_POST['rm_description'];
            $rm_qty = $_POST['rm_qty'];
            $rm_status = $_POST['rm_status'];
            
            $result = $db->AddRawMaterials($rm_name, $rm_description,$rm_qty,$rm_status);
            
            if ($result === true) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Successful!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Operation failed. Please try again.'
                ]);
            }
            


        }else if ($_POST['requestType'] == 'updateRawMaterial') {
            $id = $_POST['rmid'];
            $name = $_POST['rm_name'];
            $desc = $_POST['rm_description'];
            $qty = $_POST['rm_quantity']; 
            $status = $_POST['rm_status'];
        
            $result = $db->update_raw_material($id, $name, $desc, $qty, $status);
        
            echo json_encode([
                "status" => $result ? "success" : "error",
                "message" => $result ? "Material updated successfully." : "Update failed."
            ]);
        }else if ($_POST['requestType'] == 'RawStockin') {

            session_start();

            $user_id = $_SESSION['id'];
            $raw_id = $_POST['raw_id'];
            $stock_in_qty = $_POST['rm_quantity'];
            $result = $db->RawStockin($user_id, $raw_id, $stock_in_qty);
            echo json_encode([
                "status" => $result ? "success" : "error",
                "message" => $result ? "Material updated successfully." : "Update failed."
            ]);

            
        }else if ($_POST['requestType'] == 'deleteRawMaterial') {
            $id = $_POST['rmid'];
            // Your DB delete logic here
            $result = $db->delete_raw_material($id);
        
            echo json_encode([
                "status" => $result ? "success" : "error",
                "message" => $result ? "Material deleted successfully." : "Delete failed."
            ]);
        } else{
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>