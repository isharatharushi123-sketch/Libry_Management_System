<!DOCTYPE html>
<html>
<head>
    <title>Library Member Registration</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<h2>Library Member Registration</h2>

<form action="member_insert.php" method="POST">

    Member ID:
    <input type="text" name="member_id"><br><br>

    Firstname:
    <input type="text" name="firstname"><br><br>

    Lastname:
    <input type="text" name="lastname"><br><br>

    Birthday:
    <input type="date" name="birthday"><br><br>

    Email:
    <input type="email" name="email"><br><br>

    <button type="submit">Register</button>

</form>

<br>

<a href="member_view.php">View Members</a>

</body>
</html>