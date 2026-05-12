<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Members</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<h2>Members Table</h2>

<table border="1">

<tr>
    <th>Member ID</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Birthday</th>
    <th>Email</th>
    <th>Actions</th>
</tr>

<?php

$sql = "SELECT * FROM member";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['member_id']; ?></td>
<td><?php echo $row['first_name']; ?></td>
<td><?php echo $row['last_name']; ?></td>
<td><?php echo $row['birthday']; ?></td>
<td><?php echo $row['email']; ?></td>
<td>

<a href="member_edit.php?id=<?php echo $row['member_id']; ?>">
Edit
</a>

|

<a href="member_delete.php?id=<?php echo $row['member_id']; ?>">
Delete
</a>

</td>

</tr>

<?php
}
?>

</table>

</body>
</html>