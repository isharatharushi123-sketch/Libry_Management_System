<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
   
    <link rel="stylesheet" href="assets/css/style.css">
     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar get in boostrap docs -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/Libry_management_System/index.php">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                managements
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/Libry_management_System/features/user_management.php">User Management</a></li>
                <li><a class="dropdown-item" href="/Libry_management_System/features/components/book_reg.php">Book Management</a></li>
                <li><a class="dropdown-item" href="/Libry_management_System/features/components/category_reg.php">Category Management</a></li>
                <li><a class="dropdown-item" href="/Libry_management_System/features/components/fine_management.php">Fine Management</a></li>
                <li><a class="dropdown-item" href="/Libry_management_System/features/book_borrow/borrow.php">Book Borrow</a></li>
                <li><a class="dropdown-item" href="/Libry_management_System/features/components/member_reg.php">Member Management</a></li>
              </ul>
            </li>
             <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/Libry_management_System/features/components/borrow_books.php">Borrow Records</a>
            </li>
             <li class="nav-item">
              <button class="nav-link active" aria-current="page" onclick="logout()">Logout</button>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search any Books" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            fetch('/Libry_management_System/Session/logout.php')
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    console.log('Logged out successfully');
                    window.location.href = '/Libry_management_System/auth/login.php';
                } else {
                    console.error('Logout failed:', data.message);
                    alert('Logout failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during logout');
            });
        }
    </script>

</body>
</html>
