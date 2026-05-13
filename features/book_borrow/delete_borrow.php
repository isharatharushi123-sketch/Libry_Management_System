<?php

//feature complete

require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();


$id = $_GET['id'];

$sql = "DELETE FROM bookborrower 
WHERE borrow_id='$id'";

$result = mysqli_query($conn, $sql);

if($result){

    header("Location: borrow.php");

}else{

    echo "Delete Failed";

}

?>