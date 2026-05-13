<?php
include('../../includes/header.php');
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Books List</h2>


    <?php

    if(isset($_GET['error']) && $_GET['error'] == 'foreign_key') {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Cannot delete book!</strong> This book is currently borrowed or exists in borrow records.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    if(isset($_GET['success']) && $_GET['success'] == 'deleted') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Book deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    ?>

    <a href="add.php" class="btn btn-primary mb-3">Add New Book</a>

    <table class="table table-bordered">
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT book.book_id, book.book_name, bookcategory.category_Name 
                FROM book 
                INNER JOIN bookcategory ON book.category_id = bookcategory.category_id";
        
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <tr>
            <td><?php echo $row['book_id']; ?></td>
            <td><?php echo $row['book_name']; ?></td>
            <td><?php echo $row['category_Name']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['book_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?php echo $row['book_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include('../../includes/footer.php'); ?>
</body>
</html>