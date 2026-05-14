<?php


require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

$id = $_POST['old_id'];
$status = $_POST['borrow_status'];
$date = date("Y-m-d H:i:s");

try{
    $sql =$conn->prepare("UPDATE bookborrower SET borrow_status=?,borrower_date_modified=? WHERE borrow_id=? ");
    $sql->bind_param('sss',$status,$date,$id);
    $result = $sql->execute();

    if($result){

        $SESSION['success'] ="updated Success";

        header("Location: borrow.php");

    }else{
        $SESSION['err']="Update fail";
    }
}
catch(Exception $e){
    $SESSION['err']="update fail";
}

?>