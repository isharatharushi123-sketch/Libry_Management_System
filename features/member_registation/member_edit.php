<?php
require_once('../../config/db.php');
require_once('../../Session/session.php');
require_login();
include('../../includes/header.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM member WHERE member_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row){
        die("<div class='container' style='margin-top: 50px; text-align: center;'><h2>No data found</h2></div>");
    }
} else {
    die("<div class='container' style='margin-top: 50px; text-align: center;'><h2>Invalid Request</h2></div>");
}
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
        display: flex;
        justify-content: center;

    .form-container {
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
    }

    h2 {
        color: #2c3e50;
        border-bottom: 2px solid #2ecc71; 
        padding-bottom: 10px;
        margin-top: 0;
        margin-bottom: 25px;
        text-align: center;
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
        border-color: #2ecc71;
        outline: none;
    }

    .btn-submit {
        background-color: #2ecc71;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        width: 100%;
        transition: background 0.3s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background-color: #27ae60;
    }

    .btn-cancel {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #7f8c8d;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .btn-cancel:hover {
        color: #e74c3c;
    }
</style>

<div class="container">
    <div class="form-container">
        <h2>Edit Member Details</h2>

        <form action="member_update.php" method="POST">
            
            <input type="hidden" name="old_id" value="<?php echo htmlspecialchars($row['member_id']); ?>">

            <div class="form-group">
                <label>Member ID:</label>
                <input type="text" name="member_id" value="<?php echo htmlspecialchars($row['member_id']); ?>" readonly style="background-color: #f1f1f1; cursor: not-allowed;">
            </div>

            <div class="form-group">
                <label>Firstname:</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Lastname:</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Birthday:</label>
                <input type="date" name="birthday" value="<?php echo htmlspecialchars($row['birthday']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>

            <button type="submit" class="btn-submit">Update Member</button>
            
            <a href="javascript:history.back()" class="btn-cancel">Cancel</a>

        </form>
    </div>
</div>

<?php include('../../includes/footer.php');?>