<?php
include '../includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>

<title>Books List</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Books List</h2>

<a href="add.php"
class="btn btn-primary mb-3">

Add New Book

</a>

<table class="table table-bordered">

<tr>

<th>Book ID</th>
<th>Book Name</th>
<th>Category</th>
<th>Action</th>

</tr>

<?php

$sql = "SELECT book.book_id,
book.book_name,
bookcategory.category_Name

FROM book

INNER JOIN bookcategory

ON book.category_id =
bookcategory.category_id";

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['book_id']; ?></td>

<td><?php echo $row['book_name']; ?></td>

<td><?php echo $row['category_Name']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['book_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="delete.php?id=<?php echo $row['book_id']; ?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>