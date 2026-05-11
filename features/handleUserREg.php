<?php
header('Content-Type: application/json');
require_once('../config/db.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $userid = $_POST['userid'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $firstname = $_POST['firstname'] ?? ''; 
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $REpassword = $_POST['confirm_password'] ?? ''; 

    if(empty($userid) || $userid[0] != 'U'){
        ob_clean();
        echo json_encode(['status' => 'UidErr', 'message' => 'Invalid User ID.']);
        exit;
    }
    else if(strlen($password) < 8){ 
        ob_clean();
        echo json_encode(['status'=>'passErr','message'=>'Password must have at least 8 characters']);
        exit;
    }
    else if($password != $REpassword){
        ob_clean();
        echo json_encode(['status'=>'PasaMis','message'=>'Password Mismatch']);
        exit;
    }

    $hash_password = md5($password);

    try{
        $stmt = $conn->prepare("SELECT username, email,user_id FROM user WHERE username = ? OR email = ? OR user_id= ?");
        $stmt->bind_param("sss", $username, $email,$userid);
        $stmt->execute();
        $result = $stmt->get_result();
            
    } catch(Exception $e){
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while checking the user.']);
        exit;
    }

    if($result->num_rows === 0){
        $stmt = $conn->prepare("INSERT INTO user (user_id, email, first_name, last_name, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userid, $email, $firstname, $lastname, $username, $hash_password);
            
        if($stmt->execute()){
            ob_clean();
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
            exit;
        }
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Username,Email,Userid already exists.']);
        exit;
    }
}
?>