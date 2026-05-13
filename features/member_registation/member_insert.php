<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

$member_id = $_POST['member_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$birthday = $_POST['birthday'];
$email = $_POST['email'];

$sql = "INSERT INTO member (member_id, first_name, last_name, birthday, email)
VALUES ('$member_id', '$firstname', '$lastname', '$birthday', '$email')";

if(mysqli_query($conn, $sql)){
    header("Location: member_form.php");
    exit();
}
else{
    die("Error: " . mysqli_error($conn));
}
?>