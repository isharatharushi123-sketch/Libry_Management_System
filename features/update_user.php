<?php
header('Content-Type: application/json');
require_once('../config/db.php');
require_once('../Session/session.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $userid = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $fname=isset($_POST['first_name']) ? $_POST['first_name']:'';
    $lname=isset($_POST['last_name']) ? $_POST['last_name']:'';
    $username=isset($_POST['username']) ? $_POST['username']:'';
    $email=isset($_POST['email']) ? $_POST['email']:'';
    
    if($userid!='' && $fname !='' && $lname != '' && $username !='' && $email != ''){
        try{
            $stmt=$conn->prepare('update user set email =?,first_name=?,last_name=?,username=? where user_id=?');
            $stmt->bind_param("sssss",$email,$fname,$lname,$username,$userid);
            $stmt->execute();

            if($stmt){
                ob_clean();
                echo json_encode(['status' => 'success', 'message' => 'Update Success.']);
                exit;
            }
        }
        catch(Exception $e){
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.'+$e]);
            exit;

        }



    }


    
}
?>