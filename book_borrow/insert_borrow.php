<?php

include('../config/db.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $borrow_id = $_POST['borrow_id'] ?? '';
    $book_id = $_POST['book_id'] ?? '';
    $member_id = $_POST['member_id'] ?? '';
    $borrow_status = $_POST['borrow_status'] ?? '';

    $date = date("Y-m-d H:i:s");


    // VALIDATION

    if(!preg_match("/^BR[0-9]{3}$/", $borrow_id)){
        die("Invalid Borrow ID");
    }

    if(!preg_match("/^B[0-9]{3}$/", $book_id)){
        die("Invalid Book ID");
    }

    if(!preg_match("/^M[0-9]{3}$/", $member_id)){
        die("Invalid Member ID");
    }


    // INSERT QUERY

    $sql = "INSERT INTO bookborrower
    (borrow_id, book_id, member_id, borrow_status, borrower_date_modified)

    VALUES
    ('$borrow_id', '$book_id', '$member_id', '$borrow_status', '$date')";

    $result = mysqli_query($conn, $sql);

    if($result){

        header("Location: borrow.php");

    }else{

        echo "Insert Failed";

    }

}else{

    header("Location: borrow.php");

}

?>