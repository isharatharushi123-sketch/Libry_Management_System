<?php
include('../../includes/header.php');
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();


if(isset($_POST['submit'])){

    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $category_id = $_POST['category_id'];

   
    if(!preg_match("/^B[0-9]{3}$/",$book_id)){
        die("Invalid Book ID Format");
    }

    
    $sql = "INSERT INTO book
    VALUES('$book_id','$book_name','$category_id')";

    if(mysqli_query($conn,$sql)){
        header("Location: Book_Registation.php");
    }else{
        echo "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Book</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Add Book</h2>

<form method="POST">

<label>Book ID</label>

<input type="text"
name="book_id"
class="form-control mb-3"
placeholder="B001"
required>

<label>Book Name</label>

<input type="text"
name="book_name"
class="form-control mb-3"
required>

<label>Category</label>

<select name="category_id"
class="form-control mb-3">

<?php

$result = mysqli_query($conn,
"SELECT * FROM bookcategory");

while($row = mysqli_fetch_assoc($result)){

?>

<option value="<?php echo $row['category_id']; ?>">

<?php echo $row['category_Name']; ?>

</option>

<?php } ?>

</select>

<button type="submit"
name="submit"
class="btn btn-success">

Add Book

</button>

<a href="index.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</body>
</html>