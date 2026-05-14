<?php
require_once('config/db.php');
include('includes/header.php');
require_once('Session/session.php');
require_login();
$current_user = current_user()['first_name'];

$user_count = $conn->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];
$member_count = $conn->query("SELECT COUNT(*) as total FROM member")->fetch_assoc()['total'];
$borrowed_count = $conn->query("SELECT COUNT(*) as total FROM bookborrower where borrow_status='Borrowed' ")->fetch_assoc()['total'];
$book_count = $conn->query("SELECT COUNT(*) as total FROM book")->fetch_assoc()['total'];

?>

<style>
    .dashboard-container {
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .welcome-section {
        margin-bottom: 40px;
    }


    .cards-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .dash-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 30px 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-bottom: 6px solid;
    }


    .dash-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .dash-card h3 {
        margin: 0;
        color: #7f8c8d;
        font-size: 1.1em;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }

    .dash-card .count {
        font-size: 3em;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }

    .card-users { border-color: #3498db; }   
    .card-members { border-color: #2ecc71; }  
    .card-borrowed { border-color: #e67e22; } 
    .card-books { border-color: #9b59b6; }    

</style>

<div class="dashboard-container">
    
    <div class="welcome-section">
        <h1 style="color: #001f3f; font-size: 2.2em; margin-bottom: 5px;">HI!, <?php echo htmlspecialchars($current_user); ?>!</h1>
        <p style="color: #555; font-size: 1.2em; margin-top: 0;">Welcome to the Library Management System Dashboard.</p>
    </div>


    <div class="cards-wrapper">
        

        <div class="dash-card card-users">
            <h3>System Users</h3>
            <p class="count"><?php echo $user_count; ?></p>
        </div>

   
        <div class="dash-card card-members">
            <h3>Registered Members</h3>
            <p class="count"><?php echo $member_count; ?></p>
        </div>

   
        <div class="dash-card card-borrowed">
            <h3>Borrowed Books</h3>
            <p class="count"><?php echo $borrowed_count; ?></p>
        </div>
        <div class="dash-card card-books">
            <h3>Total Books</h3>
            <p class="count"><?php echo $book_count; ?></p>
        </div>

    </div>
</div>

<?php 
include('includes/footer.php');
?>