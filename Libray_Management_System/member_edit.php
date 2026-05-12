<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM member WHERE member_id='$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(!$row){
    die("No data found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    
</head>
<body>

<h2>Edit Member</h2>

<form action="member_update.php" method="POST">

<input type="hidden" name="old_id" value="<?php echo $row['member_id']; ?>">

Member ID:
<input type="text" name="member_id" value="<?php echo $row['member_id']; ?>"><br><br>

Firstname:
<input type="text" name="firstname" value="<?php echo $row['first_name']; ?>"><br><br>

Lastname:
<input type="text" name="lastname" value="<?php echo $row['last_name']; ?>"><br><br>

Birthday:
<input type="text" name="birthday" value="<?php echo $row['birthday']; ?>"><br><br>

Email:
<input type="text" name="email" value="<?php echo $row['email']; ?>"><br><br>

<button type="submit">Update</button>

</form>

</body>
</html>