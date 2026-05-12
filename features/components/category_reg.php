<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../config/db.php';

$message = "";

// ADD
if (isset($_POST['add'])) {
    $id   = $_POST['category_id'];
    $name = $_POST['category_name'];
    $date = date('Y-m-d H:i:s');

    if (!preg_match('/^C\d+$/', $id)) {
        $message = "<div class='alert alert-danger'>Category ID must be like C001, C002 etc.</div>";
    } else {
        $sql = "INSERT INTO bookcategory (category_id, category_Name, date_modified) VALUES ('$id', '$name', '$date')";
        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id  = $_GET['delete'];
    $sql = "DELETE FROM bookcategory WHERE category_id='$id'";
    $conn->query($sql);
    $message = "<div class='alert alert-success'>Category deleted!</div>";
}

// LOAD ROW FOR EDITING
$edit_data = null;
if (isset($_GET['edit'])) {
    $id       = $_GET['edit'];
    $result   = $conn->query("SELECT * FROM bookcategory WHERE category_id='$id'");
    $edit_data = $result->fetch_assoc();
}

// UPDATE
if (isset($_POST['update'])) {
    $old_id   = $_POST['old_id'];
    $new_id   = $_POST['category_id'];
    $new_name = $_POST['category_name'];
    $date     = date('Y-m-d H:i:s');

    if (!preg_match('/^C\d+$/', $new_id)) {
        $message = "<div class='alert alert-danger'>Category ID must be like C001, C002 etc.</div>";
    } else {
        $sql = "UPDATE bookcategory SET category_id='$new_id', category_Name='$new_name', date_modified='$date' WHERE category_id='$old_id'";
        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>Category updated successfully!</div>";
            $edit_data = null;
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// GET ALL
$all = $conn->query("SELECT * FROM bookcategory");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<?php include '../../includes/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Book Category Registration</h2>

    <?= $message ?>

    <!-- FORM -->
    <div class="card mb-4">
        <div class="card-header fw-bold">
            <?= $edit_data ? "Edit Category" : "Add New Category" ?>
        </div>
        <div class="card-body">
            <form method="POST">

                <?php if ($edit_data): ?>
                    <input type="hidden" name="old_id" value="<?= $edit_data['category_id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Category ID</label>
                    <input type="text" name="category_id" class="form-control"
                        placeholder="e.g. C001"
                        value="<?= $edit_data ? $edit_data['category_id'] : '' ?>"
                        required>
                    <small class="text-muted">Must start with C followed by numbers. Example: C001</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control"
                        placeholder="e.g. Science Fiction"
                        value="<?= $edit_data ? $edit_data['category_Name'] : '' ?>"
                        required>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <a href="category_reg.php" class="btn btn-secondary">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add" class="btn btn-primary">Add Category</button>
                <?php endif; ?>

            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header fw-bold">All Categories</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Date Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($all->num_rows > 0): ?>
                        <?php while ($row = $all->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['category_id'] ?></td>
                            <td><?= $row['category_Name'] ?></td>
                            <td><?= $row['date_modified'] ?></td>
                            <td>
                                <a href="?edit=<?= $row['category_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?delete=<?= $row['category_id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No categories found. Add one above.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

