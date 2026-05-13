<?php
require_once('../config/db.php');
require_once('../Session/session.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM bookcategory WHERE category_id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            header("Location: category_Reg.php?msg=deleted");
        } else {
            header("Location: category_Reg.php?error=Cannot delete category. It might be in use.");
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        header("Location: category_Reg.php?error=Cannot delete this category because books are registered under it.");
    }
} else {
    header("Location: category_Reg.php");
}
exit();
?>