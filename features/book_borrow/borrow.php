<?php
include('../../includes/header.php');
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
?>

<div class="container mt-5">

    <h2>Book Borrow Management</h2>

    <form action="insert_borrow.php" method="POST">

        <div class="mb-3">
            <label>Borrow ID</label>
            <input type="text" name="borrow_id"
            class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Book ID</label>
            <input type="text" name="book_id"
            class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Member ID</label>
            <input type="text" name="member_id"
            class="form-control" required>
        </div>

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
        name="addBorrow"
        class="btn btn-primary">

            Add Borrow

        </button>

    </form>

    <hr>

    <h3>Borrow Records</h3>

    <table class="table table-bordered">

        <tr>
            <th>Borrow ID</th>
            <th>Book ID</th>
            <th>Member ID</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

<?php

$sql = "SELECT * FROM bookborrower";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['borrow_id']; ?></td>

<td><?php echo $row['book_id']; ?></td>

<td><?php echo $row['member_id']; ?></td>

<td><?php echo $row['borrow_status']; ?></td>

<td><?php echo $row['borrower_date_modified']; ?></td>

<td>

<a href="edit_borrow.php?id=<?php echo $row['borrow_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="delete_borrow.php?id=<?php echo $row['borrow_id']; ?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

    </table>

</div>

<?php include('../../includes/footer.php'); ?>