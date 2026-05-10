<?php
header('Content-Type: application/json');
require_once('../config/db.php');
require_once('../Session/session.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if(empty($username) || empty($password)){
        echo json_encode(['status' => 'error', 'message' => 'Username and password are required.']);
        exit;
    }


    $hash_password = md5($password);


    try{
        
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    } catch(Exception $e){
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while checking the user.']);
        exit;
    }

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();
        
        if($hash_password === $user['password']){
            $_SESSION['user'] = [
                'username' => $user['username'],
                'id' => $user['user_id'],
                'first_name' =>$user['first_name']
            ];
            ob_clean();
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
            exit;
        }
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
        exit;
    }
}
?>