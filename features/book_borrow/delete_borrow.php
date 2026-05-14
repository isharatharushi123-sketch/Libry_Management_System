<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM bookborrower WHERE borrow_id = ?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Record deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete the record.";
    }
}

header("Location: borrow.php");
exit();
?>