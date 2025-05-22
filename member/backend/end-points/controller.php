<?php
include('../class.php');

$db = new global_class();

// MarkAsDone

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'CreateProgress') {

            session_start();
            
            $user_id=$_SESSION['id'];

            $data = $_POST;
            $material_name = $data['material_name'] ?? '';
            $material_category = $data['material_category'] ?? '';
            $rm_status = $data['rm_status'] ?? '';

            $raw_used = $data['raw_used'] ?? [];
            $raw_qty = $data['raw_qty'] ?? [];
            $unit_value = $data['unit_value'] ?? [];

            $raw_materials_details = [];
            // Check if arrays are aligned
            if (count($raw_used) === count($raw_qty) && count($raw_qty) === count($unit_value)) {
                for ($i = 0; $i < count($raw_used); $i++) {
                    $raw_materials_details[] = [
                        'raw_id' => $raw_used[$i],
                        'quantity' => $raw_qty[$i],
                        'unit' => $unit_value[$i],
                    ];
                }
                // Convert to JSON string for DB insertion if needed
                $raw_materials_json = json_encode($raw_materials_details);

                $result = $db->CreateTask($user_id,$material_name, $material_category, $rm_status, $raw_materials_json);

                if ($result === true) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Task created successfully!'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to create task.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Mismatched raw material data.'
                ]);
            }

        } else if ($_POST['requestType'] == 'MarkAsDone') {

                $task_id = $_POST['task_id'];
              
                $result = $db->MarkAsDone($task_id,'Done');

                if ($result == "success") {
                    echo json_encode(["status" => 200, "message" => "Update successfully"]);
                } else {
                    echo json_encode(["status" => 400, "message" => $result]);
                }

        }else {
            echo json_encode([
                'status' => 'error',
                'message' => 'requestType NOT FOUND'
            ]);
        }

    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>