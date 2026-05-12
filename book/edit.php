<?php

include '../includes/db.php';

$id = $_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM book WHERE book_id='$id'");

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $category_id = $_POST['category_id'];

    // Validation
    if(!preg_match("/^B[0-9]{3}$/",$book_id)){
        die("Invalid Book ID");
    }

    $sql = "UPDATE book SET

    book_id='$book_id',
    book_name='$book_name',
    category_id='$category_id'

    WHERE book_id='$id'";

    if(mysqli_query($conn,$sql)){
        header("Location: index.php");
    }else{
        echo "Error";
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

<input type="text"
name="book_id"
value="<?php echo $row['book_id']; ?>"
class="form-control mb-3">

<label>Book Name</label>

<input type="text"
name="book_name"
value="<?php echo $row['book_name']; ?>"
class="form-control mb-3">

<label>Category</label>

<select name="category_id"
class="form-control mb-3">

<?php

$cat = mysqli_query($conn,
"SELECT * FROM bookcategory");

while($c=mysqli_fetch_assoc($cat)){

?>

<option value="<?php echo $c['category_id']; ?>"

<?php
if($row['category_id']==$c['category_id']){
    echo "selected";
}
?>

>

<?php echo $c['category_Name']; ?>

</option>

<?php } ?>

</select>

<button type="submit"
name="update"
class="btn btn-success">

Update

</button>

</form>

</div>

</body>
</html>