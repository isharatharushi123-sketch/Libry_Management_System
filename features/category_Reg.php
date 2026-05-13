<?php
require_once('../config/db.php');
require_once('../Session/session.php');
include('../includes/header.php');

$stmt = $conn->prepare('SELECT * FROM bookcategory');
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7f6;
        padding: 40px;
        color: #333;
    }

    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
        margin-top: 0;
        color: #2c3e50;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .alert {
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 5px;
        font-size: 14px;
        border: 1px solid transparent;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .btn-add {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-bottom: 20px;
        transition: background 0.3s;
    }

    .btn-add:hover {
        background-color: #2980b9;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f8f9fa;
        color: #555;
    }

    .action-btns a {
        text-decoration: none;
        margin-right: 10px;
        font-size: 14px;
        color: #3498db;
        cursor: pointer;
    }

    .action-btns a.delete {
        color: #e74c3c;
    }

    .modal {
        display: none; 
        position: fixed; 
        z-index: 100; 
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 30px;
        border-radius: 8px;
        width: 400px;
        position: relative;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .close-btn {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #888;
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn-save {
        width: 100%;
        background-color: #2ecc71;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-save:hover {
        background-color: #27ae60;
    }
</style>

<div class='body'>
    <div class="container">
        <h2>Book Category Management</h2>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">
                Category deleted successfully!
            </div>
        <?php endif; ?>

        <button class="btn-add" onclick="toggleModal(true)">+ Add New Category</button>

        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Date Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result): ?>
                    <?php while($value = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($value['category_id']); ?></td>
                            <td><?php echo htmlspecialchars($value['category_Name']); ?></td>
                            <td><?php echo htmlspecialchars($value['date_modified']); ?></td>
                            <td class="action-btns">
                                <a onclick="openUpdateModal('<?php echo $value['category_id']; ?>', '<?php echo $value['category_Name']; ?>')">Update</a>
                                <a href="catdelete.php?id=<?php echo urlencode($value['category_id']); ?>" 
                                   class="delete" 
                                   onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="toggleModal(false)">&times;</span>
            <h3>Register Category</h3>
            <form id="catform">
                <label for="catID">Category ID:</label>
                <input type="text" id="catID" name="catid" placeholder="e.g., C001" required>
                <label for="catName">Category Name:</label>
                <input type="text" id="catName" name="catname" placeholder="Enter name" required>
                <button type="submit" class="btn-save">Save Category</button>
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="toggleUpdateModal(false)">&times;</span>
            <h3>Update Category</h3>
            <form id="updateForm">
                <label for="upCatID">Category ID:</label>
                <input type="text" id="upCatID" name="catid" readonly style="background-color: #f0f0f0;">
                <label for="upCatName">Category Name:</label>
                <input type="text" id="upCatName" name="catname" required>
                <button type="submit" class="btn-save" style="background-color: #3498db;">Update Category</button>
            </form>
        </div>
    </div>
</div>

<script>
    const fromVal = document.getElementById('catform');
    const updateFormVal = document.getElementById('updateForm');

    function toggleModal(show) {
        document.getElementById('categoryModal').style.display = show ? 'block' : 'none';
    }

    function toggleUpdateModal(show) {
        document.getElementById('updateModal').style.display = show ? 'block' : 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            toggleModal(false);
            toggleUpdateModal(false);
        }
    }

    function openUpdateModal(id, name) {
        document.getElementById('upCatID').value = id;
        document.getElementById('upCatName').value = name;
        toggleUpdateModal(true);
    }

    function validationForm(id) {
        const catID = document.getElementById(id).value.trim();
        if(catID !== '' && catID[0] === 'C') {
            return true;
        }
        alert("Invalid ID Format! (Must start with 'C')");
        return false;
    }

    fromVal.addEventListener('submit', (e) => {
        e.preventDefault();
        if(validationForm('catID')){
            const data = new FormData(fromVal);
            fetch('catHandler.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    updateFormVal.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = new FormData(updateFormVal);
        fetch('catUpdate.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<?php include('../includes/footer.php'); ?>
