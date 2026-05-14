<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];

    $check_stmt = $conn->prepare("SELECT member_id FROM member WHERE member_id = ?");
    $check_stmt->bind_param("s", $member_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Member ID '$member_id' already exists in the system!";
        header("Location: member_form.php");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO member (member_id, first_name, last_name, birthday, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $member_id, $firstname, $lastname, $birthday, $email);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Member registered successfully!";
            header("Location: member_form.php");
            exit();
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("Location: member_form.php");
            exit();
        }
    }
}
?>