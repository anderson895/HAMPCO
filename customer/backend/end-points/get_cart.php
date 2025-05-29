<?php 
include('../class.php');
$db = new global_class();

session_start();
$userId = $_SESSION['customer_id'];
$getCartlist = $db->getCartlist($userId); 


echo json_encode($getCartlist);
?>