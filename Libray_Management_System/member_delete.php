<?php
include 'db.php';

$id = $_GET['id'];

// 1. delete child table first
mysqli_query($conn, "DELETE FROM bookborrower WHERE member_id='$id'");

// 2. delete member
$sql = "DELETE FROM member WHERE member_id='$id'";

if(mysqli_query($conn, $sql)){
    header("Location: member_view.php");
    exit();
}
else{
    die("Delete Failed: " . mysqli_error($conn));
}
?>