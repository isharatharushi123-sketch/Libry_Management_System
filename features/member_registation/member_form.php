<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
include('../../includes/header.php');
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e9ecef;
        margin: 0;
        padding: 0; 
        color: #333;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    h2 {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    /* Message Styles */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 500;
        text-align: center;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .form-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 40px;
        max-width: 500px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    input[type="text"], 
    input[type="date"], 
    input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus, 
    input[type="date"]:focus, 
    input[type="email"]:focus {
        border-color: #3498db;
        outline: none;
    }

    .btn-submit {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        width: 100%;
        transition: background 0.3s;
    }

    .btn-submit:hover {
        background-color: #2980b9;
    }

    .table-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #2c3e50;
        color: #ffffff;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit, .btn-delete {
        padding: 6px 12px;
        text-decoration: none;
        color: white;
        border-radius: 4px;
        font-size: 13px;
        transition: opacity 0.3s;
        display: inline-block;
        margin-right: 5px;
    }

    .btn-edit { background-color: #2ecc71; }
    .btn-delete { background-color: #e74c3c; }
    .btn-edit:hover, .btn-delete:hover { opacity: 0.8; }
</style>

<div class="container">


    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); 
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']); 
            ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Library Member Registration</h2>

        <form action="member_insert.php" method="POST">
            <div class="form-group">
                <label>Member ID:</label>
                <input type="text" name="member_id" placeholder="Ex: M001" required>
            </div>

            <div class="form-group">
                <label>Firstname:</label>
                <input type="text" name="firstname" required>
            </div>

            <div class="form-group">
                <label>Lastname:</label>
                <input type="text" name="lastname" required>
            </div>

            <div class="form-group">
                <label>Birthday:</label>
                <input type="date" name="birthday" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <button type="submit" class="btn-submit">Register Member</button>
        </form>
    </div>

    <div class="table-container">
        <h2>Registered Members</h2>

        <table>
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Birthday</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query එක execute කිරීම
                $sql = "SELECT * FROM member ORDER BY member_id ASC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['member_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['birthday']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="member_edit.php?id=<?php echo urlencode($row['member_id']); ?>" class="btn-edit">Edit</a>
                            <a href="member_delete.php?id=<?php echo urlencode($row['member_id']); ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>No members registered yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../../includes/footer.php');?>