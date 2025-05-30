<?php


include ('dbconnect.php');

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }


     public function list_raw_stock_logs()
    {
        $stmt = $this->conn->prepare("
            SELECT 
                stock_history.stock_id,
                stock_history.stock_type,
                stock_history.stock_outQty,
                stock_history.stock_changes,
                stock_history.stock_date,
                stock_history.stock_user_type,
                raw_materials.id AS raw_id,
                raw_materials.rm_name,
                COALESCE(user_admin.id, user_member.id) AS user_id,
                COALESCE(user_admin.fullname, user_member.fullname) AS fullname,
                COALESCE('Administrator') AS role
            FROM stock_history
            LEFT JOIN user_admin
                ON stock_history.stock_user_type = 'Administrator'
                AND user_admin.id = stock_history.stock_user_id
            LEFT JOIN user_member
                ON stock_history.stock_user_type = 'member'
                AND user_member.id = stock_history.stock_user_id
            LEFT JOIN raw_materials
                ON raw_materials.id = stock_history.stock_raw_id
            ORDER BY `stock_id` DESC
        ");

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
















public function list_prod_stock_logs()
{
    $stmt = $this->conn->prepare("
        SELECT 
            product_stock.pstock_id,
            product_stock.pstock_stock_type,
            product_stock.pstock_stock_outQty,
            product_stock.pstock_stock_changes,
            product_stock.pstock_stock_date,
            product.prod_id AS prod_id,
            product.prod_name,
            user_admin.id AS user_id,
            user_admin.fullname AS fullname
        FROM product_stock
        LEFT JOIN user_admin
            ON user_admin.id = product_stock.pstock_user_id
        LEFT JOIN product
            ON product.prod_id = product_stock.pstock_prod_id
        ORDER BY `pstock_id` DESC
    ");

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}


     public function get_list_task()
    {
        $stmt = $this->conn->prepare("SELECT 
        task.task_id,
        task.task_user_id,
        task.task_name,
        task.task_material,
        task.task_category,
        task.date_start,
        task.date_end,
        task.status as task_status,
        user_member.id as user_id,
        user_member.fullname,
        user_member.role,
        user_member.id_number
        FROM task
        LEFT JOIN user_member
        ON user_member.id = task.task_user_id
        ");
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        return $result;
    }


    public function get_raw_materials_details($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM raw_materials WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();  
        $stmt->close();
        return $data;
    }



    public function delete_raw_material($id)
    {
        $query = $this->conn->prepare("
            DELETE FROM `raw_materials` 
            WHERE `id` = ?
        ");

        $query->bind_param("i", $id);
        
        $result = $query->execute();
        $query->close();

        return $result;
    }



    public function update_raw_material($id, $name, $desc, $qty, $status)
    {
        $query = $this->conn->prepare("
            UPDATE `raw_materials` 
            SET `rm_name` = ?, `rm_description` = ?, `rm_quantity` = ?, `rm_status` = ? 
            WHERE `id` = ?
        ");
    
        $query->bind_param("ssisi", $name, $desc, $qty, $status, $id);
        
        $result = $query->execute();
        $query->close();
    
        return $result;
    }



public function RawStockin($user_id, $raw_id, $stock_in_qty)
    {
       // Step 1: Get current rm_quantity
        $query = $this->conn->prepare("SELECT rm_quantity FROM raw_materials WHERE id = ?");
        $query->bind_param("i", $raw_id);
        $query->execute();
        $query->bind_result($current_rm_quantity);
        $query->fetch();
        $query->close();

        // Step 2: Split numeric value and unit
        if (preg_match('/^([\d,\.]+)\s*(\w+)$/', $current_rm_quantity, $matches)) {
            $current_qty = floatval(str_replace(',', '', $matches[1])); // Remove commas
            $unit = $matches[2];
        } else {
            return false; // Unexpected format
        }

        // Step 3: Subtract quantity
        $new_qty = $current_qty + $stock_in_qty;
        if ($new_qty < 0) {
            return false; // Prevent negative stock
        }

        $new_rm_quantity = $new_qty . ' ' . $unit;

        // Step 4: Update rm_quantity
        $updateQty = $this->conn->prepare("UPDATE raw_materials SET rm_quantity = ? WHERE id = ?");
        $updateQty->bind_param("si", $new_rm_quantity, $raw_id);
        $resultQty = $updateQty->execute();
        $updateQty->close();

        if (!$resultQty) {
            return false;
        }

        $change_log = "$current_qty -> $new_qty";
        $insertLog = $this->conn->prepare("INSERT INTO stock_history (stock_raw_id,stock_user_type, stock_type,stock_outQty, stock_changes, stock_user_id) VALUES (?,'Administrator', 'Stock In',?, ?, ?)");
        $insertLog->bind_param("iisi", $raw_id,$stock_in_qty, $change_log, $user_id);
        $resultLog = $insertLog->execute();
        $insertLog->close();

        return $resultLog;
    }




   public function ProdStockin($user_id, $prod_id, $stock_in_qty)
{
    // Step 1: Get current prod_stocks
    $query = $this->conn->prepare("SELECT prod_stocks FROM product WHERE prod_id = ?");
    $query->bind_param("i", $prod_id);
    $query->execute();
    $query->bind_result($current_qty);
    $query->fetch();
    $query->close();

    // Step 2: Add stock_in_qty to current quantity
    $new_qty = $current_qty + $stock_in_qty;
    if ($new_qty < 0) {
        return false; 
    }

    // Step 3: Update the product stock
    $updateQty = $this->conn->prepare("UPDATE product SET prod_stocks = ? WHERE prod_id = ?");
    $updateQty->bind_param("ii", $new_qty, $prod_id);
    $resultQty = $updateQty->execute();
    $updateQty->close();

    // Step 4: Insert into product_stock log
    $change_log = "$current_qty -> $new_qty";
    $insertLog = $this->conn->prepare("INSERT INTO product_stock(pstock_user_id, pstock_prod_id, pstock_stock_type, pstock_stock_outQty, pstock_stock_changes) VALUES (?, ?, 'Stock In', ?, ?)");
    $insertLog->bind_param("iiis", $user_id, $prod_id, $stock_in_qty, $change_log);
    $resultLog = $insertLog->execute();
    $insertLog->close();

    return $resultLog;
}







    public function AddRawMaterials($rm_name, $rm_description, $rm_qty, $rm_status)
    {
        $query = $this->conn->prepare("
            INSERT INTO `raw_materials` (`rm_name`, `rm_description`, `rm_quantity`, `rm_status`)
            VALUES (?, ?, ?, ?)
        ");

        $query->bind_param("ssss", $rm_name, $rm_description, $rm_qty, $rm_status);

        $result = $query->execute();
        $query->close();

        return $result;
    }


  
    

    public function RegisterMember($actionType, $userId)
    {
        if ($actionType == "verify") {
            $query = $this->conn->prepare("
                UPDATE `user_member`
                SET `status` = '1'
                WHERE `id` = ?
            ");
        } else if ($actionType == "decline") {
            $query = $this->conn->prepare("
                DELETE FROM `user_member`
                WHERE `id` = ?
            ");
        } else {
            return false;
        }
        $query->bind_param("i", $userId);
    
        $result = $query->execute();
        $query->close();
    
        return $result;
    }
    

    public function fetch_all_category(){
            $query = $this->conn->prepare("SELECT * FROM `product_category`");

            if ($query->execute()) {
                $result = $query->get_result();
                return $result;
            }
        }





  public function fetch_all_product(){
        $query = $this->conn->prepare("SELECT * 
        FROM `product` 
        LEFT JOIN product_category
        ON product.prod_category_id = product_category.category_id
        where prod_status='1'
        ");

        if ($query->execute()) {
            $result = $query->get_result();
            return $result;
        }
    }





 public function addProduct(
    $product_Name,
    $product_Price,
    $product_Category,
    $product_Description,
    $uniqueFileName
) {
    $query = "INSERT INTO `product` 
              (`prod_name`, `prod_price`, `prod_category_id`, `prod_description`, `prod_image`) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        return false; // Prepare failed
    }

    $stmt->bind_param("sdiss", 
        $product_Name, 
        $product_Price, 
        $product_Category, 
        $product_Description, 
        $uniqueFileName
    );

    if ($stmt->execute()) {
        $prod_id = $stmt->insert_id;
        $stmt->close();
        return $prod_id;
    } else {
        $stmt->close();
        return false;
    }
}



public function UpdateProduct(
    $product_Id,
    $product_Name,
    $product_Price,
    $product_Category,
    $product_Description,
    $uniqueFileName
) {
    $query = "UPDATE `product` SET 
                `prod_name` = ?, 
                `prod_price` = ?, 
                `prod_category_id` = ?, 
                `prod_description` = ?";
    if (!empty($uniqueFileName)) {
        $query .= ", `prod_image` = ?";
    }

    $query .= " WHERE `prod_id` = ?";

    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        return false;
    }

    if (!empty($uniqueFileName)) {
        $stmt->bind_param(
            "sdissi",
            $product_Name,
            $product_Price,
            $product_Category,
            $product_Description,
            $uniqueFileName,
            $product_Id
        );
    } else {
        $stmt->bind_param(
            "sdisi",
            $product_Name,
            $product_Price,
            $product_Category,
            $product_Description,
            $product_Id
        );
    }

    $result = $stmt->execute();
    $stmt->close();

    return $result;

    
}


public function DeleteProduct($prod_id) {
        $status = 0; 
        $query = $this->conn->prepare(
            "UPDATE `product` SET `prod_status` = ? WHERE `prod_id` = ?"
        );
        $query->bind_param("is", $status, $prod_id);
        
        if ($query->execute()) {
            return 'success';
        } else {
            return 'Error: ' . $query->error;
        }
    }



    public function GetProductById($product_Id) {
        $query = "SELECT * FROM `product` WHERE `prod_id` = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $product_Id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $product = $result->fetch_assoc();
            $stmt->close();
            return $product;
        } else {
            $stmt->close();
            return false;
        }
    }






    public function fetch_all_non_verify_member() {

        $sql = "SELECT 
                    um.id AS umid, 
                    um.id_number AS umid_number, 
                    um.fullname AS umfullname, 
                    um.email AS umemail, 
                    um.phone AS umphone, 
                    um.role AS umrole, 
                    um.sex AS umsex, 
                    um.date_created AS umdate_created, 
                    um.status AS umstatus
                FROM user_member AS um
                ORDER BY um.id ASC";
    
        $result = $this->conn->query($sql);
        return $result;
    
    }
    
    
    public function fetch_all_materials() {

        $sql = "SELECT 
                    rm.id AS rmid, 
                    rm.rm_name,
                    rm.rm_description,
                    rm.rm_quantity,
                    CASE 
                        WHEN rm.rm_quantity = 0 THEN 'Out of Stocks'
                        ELSE rm.rm_status
                    END AS rm_status
                FROM raw_materials AS rm
                ORDER BY rm.id ASC";
    
        $result = $this->conn->query($sql);
        return $result;
    
    }
    




public function check_account($id) {

    $id = intval($id);

    $query = "SELECT * FROM user_admin WHERE id = $id";

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