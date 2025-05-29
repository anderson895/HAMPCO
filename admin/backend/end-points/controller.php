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

            
        }else if ($_POST['requestType'] == 'ProdStockin') {

            session_start();

            $user_id = $_SESSION['id'];
            $prod_id = $_POST['prod_id'];
            $stock_in_qty = $_POST['rm_quantity'];
            $result = $db->ProdStockin($user_id, $prod_id, $stock_in_qty);
            echo json_encode([
                "status" => $result ? "success" : "error",
                "message" => $result ? "Product updated successfully." : "Update failed."
            ]);

            
        }else if ($_POST['requestType'] == 'deleteRawMaterial') {
            $id = $_POST['rmid'];
            // Your DB delete logic here
            $result = $db->delete_raw_material($id);
        
            echo json_encode([
                "status" => $result ? "success" : "error",
                "message" => $result ? "Material deleted successfully." : "Delete failed."
            ]);
        }else if ($_POST['requestType'] == 'AddProduct') {

                $product_Name = $_POST['rm_name'];
                $product_Price = $_POST['rm_price'];
                
                $product_Description = $_POST['rm_description'];
                $product_Category = $_POST['rm_product_Category'];
                $product_Image = $_FILES['rm_product_image'];


               
                
                if ($product_Image['error'] === UPLOAD_ERR_OK) {

                    $uploadDir = '../../../upload/';
                    $fileExtension = pathinfo($product_Image['name'], PATHINFO_EXTENSION);
                    $uniqueFileName = uniqid('product_', true) . '.' . $fileExtension;
                    $uploadFilePath = $uploadDir . $uniqueFileName;

                    if (move_uploaded_file($product_Image['tmp_name'], $uploadFilePath)) {
                            $prod_id = $db->addProduct(
                            $product_Name,
                            $product_Price,
                            $product_Category,
                            $product_Description,
                            $uniqueFileName
                        );
                
                
                        echo "success";
                      
                    } else {
                        echo 'Error uploading image. Please try again.';
                    }
                } else {
                    echo 'No image uploaded or there was an error with the image.';
                }
        

        
        }else if ($_POST['requestType'] == 'UpdateProduct') {

             $product_Id = $_POST['rm_id'];
            $product_Name = $_POST['rm_name'];
            $product_Price = $_POST['rm_price'];
            $product_Description = $_POST['rm_description'];
            $product_Category = $_POST['rm_product_Category'];
            $product_Image = $_FILES['rm_product_image'];

            $uploadDir = '../../../upload/';
            $uniqueFileName = null;

            // Step 1: Get current image filename from DB
            $currentProduct = $db->GetProductById($product_Id); // You need to have this method implemented
            $currentImage = $currentProduct ? $currentProduct['prod_image'] : null;

            if ($product_Image['error'] === UPLOAD_ERR_OK) {
                // Step 2: Unlink old image if exists
                if ($currentImage && file_exists($uploadDir . $currentImage)) {
                    unlink($uploadDir . $currentImage);
                }

                // Step 3: Upload new image
                $fileExtension = pathinfo($product_Image['name'], PATHINFO_EXTENSION);
                $uniqueFileName = uniqid('product_', true) . '.' . $fileExtension;
                $uploadFilePath = $uploadDir . $uniqueFileName;

                if (!move_uploaded_file($product_Image['tmp_name'], $uploadFilePath)) {
                    echo 'Error uploading image. Please try again.';
                    exit;
                }
            } elseif ($product_Image['error'] !== UPLOAD_ERR_NO_FILE) {
                echo 'There was an error with the image upload.';
                exit;
            }

            $prod_id = $db->UpdateProduct(
                $product_Id,
                $product_Name,
                $product_Price,
                $product_Category,
                $product_Description,
                $uniqueFileName
            );

            if ($prod_id) {
                echo 200;
            } else {
                echo 'Failed to update product.';
            }


        
        }else if($_POST['requestType'] =='DeleteProduct'){

                $prod_id = $_POST['prod_id'];
            

                $result = $db->DeleteProduct($prod_id);

                if ($result == "success") {
                    echo json_encode(["status" => 200, "message" => "Remove Successfully"]);
                } else {
                    echo json_encode(["status" => 400, "message" => $result]);
                }
        
        } else{
            echo 'requestType NOT FOUND';
        }
    } else {
        echo 'Access Denied! No Request Type.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
}
?>