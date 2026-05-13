<?php

include('../config/db.php');

$id = $_POST['borrow_id'];

$status = $_POST['borrow_status'];

$date = date("Y-m-d H:i:s");

$sql = "UPDATE bookborrower SET

borrow_status='$status',
borrower_date_modified='$date'

WHERE borrow_id='$id'";

$result = mysqli_query($conn,$sql);

if($result){

    header("Location: borrow.php");

}else{

    echo "Update Failed";

}

?>