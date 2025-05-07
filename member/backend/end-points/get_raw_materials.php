<?php 
include('../class.php');

$db = new global_class();

$materials = $db->get_raw_materials();
echo json_encode($materials);
?>
