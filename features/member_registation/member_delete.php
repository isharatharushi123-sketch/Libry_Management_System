<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

$id = $_GET['id'];

// 1. delete child table first
mysqli_query($conn, "DELETE FROM bookborrower WHERE member_id='$id'");

// 2. delete member
$sql = "DELETE FROM member WHERE member_id='$id'";

if(mysqli_query($conn, $sql)){
    header("Location: member_form.php");
    exit();
}
else{
    die("Delete Failed: " . mysqli_error($conn));
}
?>