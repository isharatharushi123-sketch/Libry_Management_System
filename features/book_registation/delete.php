<?php
require_once '../../config/db.php';
require_once '../../Session/session.php';
require_login();

if(isset($_GET['id'])) {
    
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM book WHERE book_id = ?");
    $stmt->bind_param("s", $id);

    try {
    
        $stmt->execute();
        
        header("Location: Book_Registation.php?success=deleted");
        exit();
        
    } catch (mysqli_sql_exception $e) {
        
        if ($e->getCode() == 1451) {
            header("Location: Book_Registation.php?error=foreign_key");
            exit();
        } else {
            echo "Error deleting record: " . $e->getMessage();
        }
    }

    $stmt->close();

} else {
    echo "Invalid Request! Book ID is missing.";
}
?>