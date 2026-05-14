<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $del_child = $conn->prepare("DELETE FROM bookborrower WHERE member_id = ?");
    $del_child->bind_param("s", $id);
    $del_child->execute();

    $del_member = $conn->prepare("DELETE FROM member WHERE member_id = ?");
    $del_member->bind_param("s", $id);

    if ($del_member->execute()) {
        $_SESSION['success'] = "Member deleted successfully!";
    } else {
        $_SESSION['error'] = "Delete failed: " . $conn->error;
    }
}
header("Location: member_form.php");
exit();
?>