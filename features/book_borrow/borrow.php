<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
include('../../includes/header.php');
?>

<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }
    .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
</style>

<div class="container mt-5">

    <h2>Book Borrow Management</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="insert_borrow.php" method="POST" class="card p-4 shadow-sm">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Borrow ID (BR000)</label>
                <input type="text" name="borrow_id" class="form-control" placeholder="BR001" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Book ID (B000)</label>
                <input type="text" name="book_id" class="form-control" placeholder="B001" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Member ID (M000)</label>
                <input type="text" name="member_id" class="form-control" placeholder="M001" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Borrow Status</label>
                <select name="borrow_status" class="form-select">
                    <option value="borrowed">Borrowed</option>
                    <option value="available">Available</option>
                </select>
            </div>
        </div>
        <button type="submit" name="addBorrow" class="btn btn-primary w-100">Add Borrow Record</button>
    </form>

    <hr class="my-5">

    <h3>Borrow Records</h3>
    <table class="table table-hover table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Borrow ID</th>
                <th>Book ID</th>
                <th>Member ID</th>
                <th>Status</th>
                <th>Date Modified</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM bookborrower ORDER BY borrower_date_modified DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['borrow_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['member_id']); ?></td>
                        <td>
                            <span class="badge <?php echo $row['borrow_status'] == 'borrowed' ? 'bg-warning text-dark' : 'bg-success'; ?>">
                                <?php echo ucfirst($row['borrow_status']); ?>
                            </span>
                        </td>
                        <td><?php echo $row['borrower_date_modified']; ?></td>
                        <td>
                            <a href="edit_borrow.php?id=<?php echo urlencode($row['borrow_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_borrow.php?id=<?php echo urlencode($row['borrow_id']); ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                    <?php 
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('../../includes/footer.php'); ?>