<?php

require_once '../config/db.php';
require_once '../Session/session.php';
require_login();

if(isset($_GET['id'])){

    $user_id=$_GET['id'];

    try{
        $stmt=$conn->prepare('DELETE FROM user WHERE user_id=?');
        $stmt->bind_param('s',$user_id);
        $stmt->execute();

        if($stmt){
            header("Location:user_management.php");
        }
    }
    catch(Exception $e){
        echo "Cannot delete user some error occor";
    }


}

?>