<?php
header('Content-Type: application/json');
require_once('../config/db.php');

error_reporting(0);
ini_set('display_errors', 0);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $catid = $_POST['catid'] ?? '';
    $Catname = $_POST['catname'] ?? '';
    $modDate = date("Y-m-d H:i:s");

    if(empty($catid) || $catid[0] != 'C'){
        echo json_encode(['status' => 'UidErr', 'message' => 'Invalid Category ID.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO bookcategory(category_id, category_Name, date_modified) VALUES (?,?,?)");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $catid, $Catname, $modDate);
        
        if($stmt->execute()){
            echo json_encode(['status' => 'success', 'message' => 'Category added successfully!']);
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
    } catch(Exception $e){
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>