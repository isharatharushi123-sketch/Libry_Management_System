<?php

include('../config/db.php');

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