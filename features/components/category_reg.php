<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}
require_once '../../config/db.php';

$success = "";
$error = "";

// ── INSERT ──────────────────────────────────────────────────────────────────
if (isset($_POST['add_category'])) {
    $cat_id   = trim($_POST['category_id']);
    $cat_name = trim($_POST['category_name']);
    $date_mod = date('Y-m-d H:i:s');

    // Validate Category ID format: C followed by digits (e.g. C001)
    if (!preg_match('/^C\d+$/', $cat_id)) {
        $error = "Category ID must be in 'C&lt;NUMBER&gt;' format (e.g. C001).";
    } elseif (empty($cat_name)) {
        $error = "Category Name cannot be empty.";
    } else {
        // Check duplicate
        $chk = $conn->prepare("SELECT category_id FROM bookcategory WHERE category_id = ?");
        $chk->bind_param("s", $cat_id);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            $error = "Category ID already exists. Please use a different ID.";
        } else {
            $stmt = $conn->prepare("INSERT INTO bookcategory (category_id, category_Name, date_modified) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $cat_id, $cat_name, $date_mod);
            if ($stmt->execute()) {
                $success = "Book category added successfully!";
            } else {
                $error = "Failed to add category. Please try again.";
            }
        }
    }
}

// ── UPDATE ───────────────────────────────────────────────────────────────────
if (isset($_POST['update_category'])) {
    $old_id   = trim($_POST['old_category_id']);
    $cat_id   = trim($_POST['category_id']);
    $cat_name = trim($_POST['category_name']);
    $date_mod = date('Y-m-d H:i:s');

    if (!preg_match('/^C\d+$/', $cat_id)) {
        $error = "Category ID must be in 'C&lt;NUMBER&gt;' format (e.g. C001).";
    } elseif (empty($cat_name)) {
        $error = "Category Name cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE bookcategory SET category_id=?, category_Name=?, date_modified=? WHERE category_id=?");
        $stmt->bind_param("ssss", $cat_id, $cat_name, $date_mod, $old_id);
        if ($stmt->execute()) {
            $success = "Category updated successfully!";
        } else {
            $error = "Failed to update category.";
        }
    }
}

// ── DELETE ───────────────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $del_id = trim($_GET['delete']);
    $stmt   = $conn->prepare("DELETE FROM bookcategory WHERE category_id = ?");
    $stmt->bind_param("s", $del_id);
    if ($stmt->execute()) {
        $success = "Category deleted successfully!";
    } else {
        $error = "Failed to delete category.";
    }
}

// ── FETCH ALL ─────────────────────────────────────────────────────────────────
$categories = $conn->query("SELECT * FROM bookcategory ORDER BY category_id ASC");

// ── FETCH ONE FOR EDIT ────────────────────────────────────────────────────────
$edit_cat = null;
if (isset($_GET['edit'])) {
    $edit_id  = trim($_GET['edit']);
    $edit_stmt = $conn->prepare("SELECT * FROM bookcategory WHERE category_id = ?");
    $edit_stmt->bind_param("s", $edit_id);
    $edit_stmt->execute();
    $edit_result = $edit_stmt->get_result();
    $edit_cat    = $edit_result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Category Registration | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        body { background: #f4f6fb; }
        .page-header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            color: #fff;
            padding: 28px 32px 20px;
            border-radius: 12px;
            margin-bottom: 28px;
        }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .card-header {
            background: #fff;
            border-bottom: 2px solid #e8eaf6;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 12px 12px 0 0 !important;
        }
        .table th { background: #e8eaf6; color: #1a237e; font-weight: 600; }
        .btn-primary   { background: #1a237e; border-color: #1a237e; }
        .btn-primary:hover { background: #283593; border-color: #283593; }
        .badge-available { background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: .78rem; }
    </style>
</head>
<body>
<?php include '../../includes/header.php'; ?>

<div class="container py-4">

    <!-- Page header -->
    <div class="page-header d-flex align-items-center gap-3">
        <i class="bi bi-tags-fill fs-2"></i>
        <div>
            <h4 class="mb-0">Book Category Registration</h4>
            <small class="opacity-75">Manage book categories in the library system</small>
        </div>
    </div>

    <!-- Alerts -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- ── FORM ─────────────────────────────────────────────── -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header py-3">
                    <i class="bi bi-<?= $edit_cat ? 'pencil-square' : 'plus-circle' ?> me-2 text-primary"></i>
                    <?= $edit_cat ? 'Edit Category' : 'Add New Category' ?>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="" novalidate>

                        <?php if ($edit_cat): ?>
                            <input type="hidden" name="old_category_id" value="<?= htmlspecialchars($edit_cat['category_id']) ?>">
                        <?php endif; ?>

                        <!-- Category ID -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">Category ID <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="category_id"
                                name="category_id"
                                class="form-control"
                                placeholder="e.g. C001"
                                pattern="^C\d+$"
                                required
                                value="<?= $edit_cat ? htmlspecialchars($edit_cat['category_id']) : '' ?>"
                            >
                            <div class="form-text text-muted">Must start with <strong>C</strong> followed by digits (e.g. C001).</div>
                        </div>

                        <!-- Category Name -->
                        <div class="mb-4">
                            <label for="category_name" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="category_name"
                                name="category_name"
                                class="form-control"
                                placeholder="e.g. Science Fiction"
                                required
                                value="<?= $edit_cat ? htmlspecialchars($edit_cat['category_Name']) : '' ?>"
                            >
                        </div>

                        <?php if ($edit_cat): ?>
                            <div class="d-grid gap-2">
                                <button type="submit" name="update_category" class="btn btn-warning fw-semibold">
                                    <i class="bi bi-save me-1"></i> Update Category
                                </button>
                                <a href="category_reg.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="d-grid">
                                <button type="submit" name="add_category" class="btn btn-primary fw-semibold">
                                    <i class="bi bi-plus-lg me-1"></i> Add Category
                                </button>
                            </div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>
        </div>

        <!-- ── TABLE ────────────────────────────────────────────── -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-table me-2 text-primary"></i>All Book Categories</span>
                    <span class="badge bg-primary rounded-pill">
                        <?= $categories->num_rows ?> record<?= $categories->num_rows !== 1 ? 's' : '' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Date Modified</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($categories->num_rows > 0):
                                    $i = 1;
                                    while ($row = $categories->fetch_assoc()): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $i++ ?></td>
                                    <td><span class="badge bg-primary"><?= htmlspecialchars($row['category_id']) ?></span></td>
                                    <td><?= htmlspecialchars($row['category_Name']) ?></td>
                                    <td><small class="text-muted"><?= htmlspecialchars($row['date_modified']) ?></small></td>
                                    <td class="text-center">
                                        <a href="?edit=<?= urlencode($row['category_id']) ?>"
                                           class="btn btn-sm btn-outline-warning me-1"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="?delete=<?= urlencode($row['category_id']) ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           title="Delete"
                                           onclick="return confirm('Delete category \'<?= htmlspecialchars($row['category_Name']) ?>\'? This cannot be undone.')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No categories found. Add one using the form.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /row -->
</div><!-- /container -->

<?php include '../../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Client-side Category ID validation
document.querySelector('form').addEventListener('submit', function(e) {
    const catId = document.getElementById('category_id').value.trim();
    if (!/^C\d+$/.test(catId)) {
        e.preventDefault();
        alert("Category ID must be in 'C<NUMBER>' format (e.g. C001).");
        document.getElementById('category_id').focus();
    }
});
</script>
</body>
</html>
