<?php
include('../../includes/header.php');
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
?>  
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 

        h2 {
            font-size: 2.2em;
            color: #212529;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 13px;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
            margin-right: 5px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #ffffff;
        }


        .custom-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #dee2e6;
        }

        .custom-table th, .custom-table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .custom-table th {
            background-color: #ffffff;
            color: #212529;
            font-weight: bold;
            font-size: 15px;
        }

        .custom-table tr:hover {
            background-color: #f8f9fa; 
        }

        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            font-size: 15px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .btn-close {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
        }

        .btn-close:hover {
            opacity: 1;
        }
    </style>
</head>


<div class="container">

    <h2>Books List</h2>

    <?php
    if(isset($_GET['error']) && $_GET['error'] == 'foreign_key') {
        echo '<div class="alert alert-danger" id="alertBox">
                <strong>Cannot delete book!</strong> This book is currently borrowed or exists in borrow records.
                <button type="button" class="btn-close" onclick="document.getElementById(\'alertBox\').style.display=\'none\'">&times;</button>
              </div>';
    }

    if(isset($_GET['success']) && $_GET['success'] == 'deleted') {
        echo '<div class="alert alert-success" id="alertBox">
                Book deleted successfully!
                <button type="button" class="btn-close" onclick="document.getElementById(\'alertBox\').style.display=\'none\'">&times;</button>
              </div>';
    }
    ?>

    <a href="add.php" class="btn btn-primary">Add New Book</a>

    <table class="custom-table">
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

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_Name']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo urlencode($row['book_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo urlencode($row['book_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                </td>
            </tr>
        <?php 
            } 
        } else {
            echo "<tr><td colspan='4' style='text-align: center;'>No books found.</td></tr>";
        }
        ?>
    </table>

</div>

<?php include('../../includes/footer.php'); ?>
