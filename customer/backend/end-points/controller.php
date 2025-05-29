<?php
include('../class.php');

$db = new global_class();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'AddToCart') {
            $userId = $_POST['cart_user_id'];
            $productId = $_POST['cart_prod_id'];

            $response = $db->AddToCart($userId, $productId);

            echo json_encode(['status' => $response]);
            }else{
                echo 'requestType NOT FOUND';
            }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>