<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

$old_id = $_POST['old_id'];

$member_id = $_POST['member_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];

$sql = "UPDATE member SET
member_id='$member_id',
first_name='$firstname',
last_name='$lastname',
birthday='$birthday',
email='$email'
WHERE member_id='$old_id'";

if(mysqli_query($conn, $sql)){
    header("Location: member_form.php");
    exit();
}
else{
    die("Update Failed: " . mysqli_error($conn));
}
?>