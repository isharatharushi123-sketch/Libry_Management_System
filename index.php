<?php
include('includes/header.php');
require_once('Session/session.php');
require_login();
$current_user = current_user()['first_name'];
?>
<div>
    <h1 style="color: #001f3f; font-size: 2em;">HI!, <?php echo $current_user; ?>!</h1>
    <p style="color: #001f3f; font-size: 1.2em;">Welcome to the Library Management System.</p>
</div>
<?php 
include('includes/footer.php');
?>