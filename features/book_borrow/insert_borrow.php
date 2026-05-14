<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = $_POST['borrow_id'] ?? '';
    $book_id = $_POST['book_id'] ?? '';
    $member_id = $_POST['member_id'] ?? '';
    $borrow_status = $_POST['borrow_status'] ?? '';
    $date = date("Y-m-d H:i:s");

  
    if (!preg_match("/^BR[0-9]{3}$/", $borrow_id)) {
        $_SESSION['error'] = "Invalid Borrow ID format (Should be like BR001).";
    } elseif (!preg_match("/^B[0-9]{3}$/", $book_id)) {
        $_SESSION['error'] = "Invalid Book ID format (Should be like B001).";
    } elseif (!preg_match("/^M[0-9]{3}$/", $member_id)) {
        $_SESSION['error'] = "Invalid Member ID format (Should be like M001).";
    } else {

        try {
          
            $check = $conn->prepare("SELECT borrow_id FROM bookborrower WHERE borrow_id = ?");
            $check->bind_param("s", $borrow_id);
            $check->execute();
            
            if ($check->get_result()->num_rows > 0) {
                $_SESSION['error'] = "Borrow ID '$borrow_id' already exists!";
            } else {
              
                $stmt = $conn->prepare("INSERT INTO bookborrower (borrow_id, book_id, member_id, borrow_status, borrower_date_modified) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $borrow_id, $book_id, $member_id, $borrow_status, $date);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Borrow record added successfully!";
                }
            }
        } 
        catch (mysqli_sql_exception $e) {
            // Error code 1452-forigen key err
            if ($e->getCode() == 1452) {
                
                $_SESSION['error'] = "Cannot add data: Either Book ID '$book_id' or Member ID '$member_id' is not registered in the system.";
            } else {
                $_SESSION['error'] = "Database Error: " . $e->getMessage();
            }
        }
    }
}

header("Location: borrow.php");
exit();
?>