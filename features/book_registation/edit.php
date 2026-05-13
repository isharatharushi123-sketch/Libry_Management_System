<?php
include('../../includes/header.php');
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM book WHERE book_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row){
        die("<div class='container mt-5'><h3>Book not found!</h3></div>");
    }
} else {
    die("<div class='container mt-5'><h3>Invalid Request!</h3></div>");
}

if(isset($_POST['update'])){

    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $category_id = $_POST['category_id'];


    if(!preg_match("/^B[0-9]{3}$/", $book_id)){
        die("<div class='container mt-5'><div class='alert alert-danger'>Invalid Book ID format.</div></div>");
    }


    $update_stmt = $conn->prepare("UPDATE book SET book_name = ?, category_id = ? WHERE book_id = ?");
    $update_stmt->bind_param("sss", $book_name, $category_id, $id);

    if($update_stmt->execute()){
        header("Location: Book_Registation.php?success=updated");
        exit();
    } else {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Error updating book.</div></div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2>Edit Book</h2>

    <form method="POST">

        <label>Book ID</label>
        <input type="text" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>" class="form-control mb-3" readonly>

        <label>Book Name</label>
        <input type="text" name="book_name" value="<?php echo htmlspecialchars($row['book_name']); ?>" class="form-control mb-3" required>

        <label>Category</label>
        <select name="category_id" class="form-control mb-3">
            <?php
            $cat_sql = "SELECT * FROM bookcategory";
            $cat_result = mysqli_query($conn, $cat_sql);

            while($c = mysqli_fetch_assoc($cat_result)){
                $selected = ($row['category_id'] == $c['category_id']) ? "selected" : "";
                echo "<option value='" . htmlspecialchars($c['category_id']) . "' $selected>" . htmlspecialchars($c['category_Name']) . "</option>";
            } 
            ?>
        </select>

        <button type="submit" name="update" class="btn btn-success">Update Book</button>
        <a href="Book_Registation.php" class="btn btn-secondary">Cancel</a> 

    </form>

</div>

</body>
</html>