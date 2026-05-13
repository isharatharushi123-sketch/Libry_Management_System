<?php


require_once('../../config/db.php');
require_once('../../Session/session.php');
include('../../includes/header.php');
require_login();

$id = $_GET['id'];

$sql = "SELECT * FROM bookborrower
WHERE borrow_id='$id'";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

?>

<div class="container mt-5">

<h2>Edit Borrow</h2>

<form action="update_borrow.php" method="POST">

<input type="hidden"
name="old_id"
value="<?php echo $row['borrow_id']; ?>">

<div class="mb-3">

<label>Borrow Status</label>

<select name="borrow_status"
class="form-control">

<option value="borrowed">
Borrowed
</option>

<option value="available">
Available
</option>

</select>

</div>

<button type="submit"
class="btn btn-success">

Update

</button>

</form>

</div>

<?php include('../../includes/footer.php'); ?>