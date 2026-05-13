<?php
include('../includes/header.php');
require_once '../Session/session.php'; 
require_login();

require_once '../config/db.php';

$stmt = $conn->prepare('SELECT * FROM user');
$stmt->execute(); 
$result = $stmt->get_result();
?>


<style>
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    .popup-form-container {
        position: fixed; top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff; padding: 30px; border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); 
        width: 400px; max-width: 90%; z-index: 1000;
        font-family: Arial, sans-serif; position: relative;
    }
    .popup-form-container h2 { 
        margin-top: 0;
        color: #333;
        text-align: center;
        margin-bottom: 25px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label { 
        display: block; 
        margin-bottom: 5px; 
        color: #555; 
        font-size: 14px; 
        font-weight: bold; 
    }
    .form-group input { 
        width: 100%; 
        padding: 10px 12px; 
        border: 1px solid #ccc; 
        border-radius: 6px; 
        box-sizing: border-box; 
        font-size: 14px; 
    }
    .form-group input:focus { 
        border-color: #0ea5e9; 
        outline: none; 
        box-shadow: 0 0 5px rgba(14, 165, 233, 0.3); 
    }
    .btn-submit { 
        width: 100%; 
        padding: 12px; 
        background-color: #0ea5e9; 
        color: white; 
        border: none; 
        border-radius: 6px; 
        font-size: 16px; 
        font-weight: bold; 
        cursor: pointer; 
        margin-top: 10px; 
    }
    .btn-submit:hover { 
        background-color: #0284c7; 
    }
    .btn-close { 
        position: absolute; 
        top: 15px; 
        right: 15px; 
        background: none; 
        border: none; 
        font-size: 24px; 
        cursor: pointer; 
        color: #888; 
    }
    .btn-close:hover { color: #ef4444; }
    .th{
        padding: 15px; 
        border-bottom: 2px solid #e0e0e0; 
        background-color: #f8f9fa; 
        text-align: left; 
        color: #333;

    }
    .td{
        padding: 12px 15px; 
        border-bottom: 1px solid #eeeeee; 
        color: #555;'
    }
    .button{
        padding: 12px 15px; 
        border-bottom: 1px solid #eeeeee; 
        text-align: center;
    }
    .button .componunt_edit{
        display: inline-block; 
        padding: 6px 12px; 
        margin: 2px; 
        background-color: #0ea5e9; 
        color: #ffffff; 
        border: none; 
        border-radius: 4px; 
        font-size: 14px;
        font-weight: bold; 
        cursor: pointer;
    }
    .button .componunt_delete{
        display: inline-block; 
        padding: 6px 12px; 
        margin: 2px; 
        background-color: #ef4444; 
        color: #ffffff; 
        text-decoration: none; 
        border-radius: 4px; 
        font-size: 14px; 
        font-weight: bold;
    }
</style>

<div style="padding: 20px; font-family: Arial, sans-serif; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color: #ffffff;">
        <thead>
            <tr>
                <th class="th">User ID</th>
                <th class="th">Email</th>
                <th class="th">First Name</th> 
                <th class="th">Last Name</th>
                <th class="th">User Name</th>
                <th class="th">Actions</th> 
            </tr>
        </thead>
        <tbody>

<?php
if ($result && $result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        echo "
            <tr>
                <td class='td'>{$data['user_id']}</td>
                <td class='td'>{$data['email']}</td>
                <td class='td'>{$data['first_name']}</td>
                <td class='td'>{$data['last_name']}</td>
                <td class='td'>{$data['username']}</td>
                <td class='button'>
                    
                    <!-- Edit Button -->
                    <button onclick=\"openPopup('{$data['user_id']}', '{$data['first_name']}', '{$data['last_name']}', '{$data['username']}', '{$data['email']}')\" class='componunt_edit'>Edit</button>
                    
                    <!-- Delete Button -->
                    <a href='delete_user.php?id={$data['user_id']}' onclick=\"return confirm('Are you sure you want to delete this user?');\" class='componunt_delete'>Delete</a>

                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6' style='padding: 20px; text-align: center; color: #888;'>No users found in the database.</td></tr>";
}
?>

        </tbody>
    </table>
</div>

<div class="popup-overlay" id="myPopup">
    <div class="popup-form-container">
        <button class="btn-close" onclick="closePopup()">&times;</button>
        
        <h2>Edit Details</h2>
        
        <form id="update_user" method="POST">
        
            <input type="hidden" name="user_id" id="edit_user_id">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" id="edit_first_name" required>
            </div>
            
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" id="edit_last_name" required>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="edit_username" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit_email" required>
            </div>
            
            <button type="submit" name="update_user" class="btn-submit">Update</button>
        </form>
    </div>
</div>

<script>

    function openPopup(id, fname, lname, uname, email) {

        document.getElementById("myPopup").style.display = "block";//show popup
        document.getElementById("edit_user_id").value = id;
        document.getElementById("edit_first_name").value = fname;
        document.getElementById("edit_last_name").value = lname;
        document.getElementById("edit_username").value = uname;
        document.getElementById("edit_email").value = email;
    }

    function closePopup() {
        document.getElementById("myPopup").style.display = "none";
    }

    const updateform = document.getElementById('update_user');
        
        update_user.addEventListener('submit', (e) => {
            e.preventDefault();
            const data = new FormData(updateform);
            

            fetch('update_user.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.json()) 
            .then(data => {                    
                console.log(data);
                if(data.status === 'success') {
                    window.location.href = '<?php echo $BASE_URL?>/features/user_management.php';
                } else {
                    console.log('Error');
                    alert(data.message || 'Invalid update details'); 
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        });



</script>

<?php 
include('../includes/footer.php');
?>