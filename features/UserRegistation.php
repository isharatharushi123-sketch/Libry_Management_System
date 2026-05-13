<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library Management System</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  
    <style>
    .login-container {
        height: auto;
        min-height: 520px;
        max-width: 950px;
        align-self: center;
        overflow: hidden;
    }

    .right-side {
        padding: 20px;
        overflow-y: auto;
    }

    .login-card {
        max-width: 450px;
        background: transparent;
        box-shadow: none;
    }

    .registration-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0px 25px; 
    }

    .full-width {
        grid-column: span 2;
    }

    .input-group {
        margin-bottom: 8px;
        text-align: left;
    }

    .input-group label {
        font-size: 0.85rem;
        color: #666;
    }

    .input-group input {
        padding: 7px 11px;
        background-color: #fff;
        width: 100%;
        box-sizing: border-box;
    }
    .login-btn {
        margin-top: 14px;
        text-transform: none;
        letter-spacing: 0.5px;
        width: 100%;
    }
    
    .error-msg {
        color: #e74c3c;
        font-size: 0.75rem;
        margin-top: 4px;
        display: block;
        height: 12px;
    }

    .input-error {
        border: 1px solid #e74c3c !important;
    }
    </style>
</head>
<body>

    <div class="body-logingForm" style="overflow: hidden;">
    
        <div class="login-container">
            <div class="left-side">
                <h1>Library</h1>
                <p>Management System</p>
                <div style="margin-top: 20px; width: 50px; height: 4px; background: #fff; border-radius: 2px;"></div>
            </div>

            <div class="right-side">
                <div class="login-card">
                    <h2>Member Registation</h2>
                    <form method="POST" id="login-form">
                        <div class="registration-grid">
                            
                            <span class="error-msg full-width" id="backendErr" style="text-align: center; height: auto; margin-bottom: 10px; font-size: 0.85rem;"></span>
                            
                            <div class="input-group full-width">
                                <label for="userid">User ID</label>
                                <input type="text" id="userid" name="userid" placeholder="Enter User ID" required>
                                <span class="error-msg" id="userid-error"></span>
                            </div>
                            
                            <div class="input-group">
                                <label for="firstname">First Name</label>
                                <input type="text" id="firstname" name="firstname" placeholder="Enter first name" required>
                            </div>

                            <div class="input-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" id="lastname" name="lastname" placeholder="Enter last name" required>
                            </div>

                            <div class="input-group full-width">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter email" required>
                            </div>

                            <div class="input-group full-width">
                                <label for="username">User Name</label>
                                <input type="text" id="username" name="username" placeholder="Enter username" required>
                                <span class="error-msg" id="username-error"></span>
                            </div>
                            
                            <div class="input-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter password" required>
                                <span class="error-msg" id="password-Err"></span>
                            </div>

                            <div class="input-group">
                                <label for="re-password">Re Enter Password</label>
                                <input type="password" id="re-password" name="confirm_password" placeholder="Re-enter password" required>
                                <span class="error-msg" id="Re-password-Err"></span>
                            </div>
                        </div>

                        <button type="submit" class="login-btn">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const loginform = document.getElementById('login-form');
        
        function validateForm(){
            const useridInput = document.getElementById('userid');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('re-password');

            const userid = useridInput.value.trim();
            const password = passwordInput.value.trim();
            const confirmPassword = confirmPasswordInput.value.trim();

            let isValid = true;

            document.getElementById('userid-error').innerText = '';
            document.getElementById('password-Err').innerText = '';
            document.getElementById('Re-password-Err').innerText = '';
            document.getElementById('backendErr').innerText = '';
            
            useridInput.classList.remove('input-error');
            passwordInput.classList.remove('input-error');
            confirmPasswordInput.classList.remove('input-error');

            if(userid !== ''){
                if(userid[0].toUpperCase() !== 'U'){
                    document.getElementById('userid-error').innerText = 'Invalid User ID.';
                    useridInput.classList.add('input-error');
                    isValid = false;
                }
            }

            if(password.length < 8){
                document.getElementById('password-Err').innerText = 'Password must be at least 8 characters long';
                passwordInput.classList.add('input-error');
                isValid = false;
            }
            else if(password !== confirmPassword){
                document.getElementById('Re-password-Err').innerText = 'Password mismatch';
                confirmPasswordInput.classList.add('input-error');
                isValid = false;
            }

            return isValid;
        }

        loginform.addEventListener('submit', (e) => {
            e.preventDefault();

            const validation = validateForm();

            if(validation){
                const data = new FormData(loginform);

                fetch('handleUserREg.php', {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json()) 
                .then(data => {
                    console.log(data);
                    if(data.status === 'success') {
                        console.log('Success');
                        window.location.href = '../index.php';
                    } else if(data.status == 'UidErr'){
                        document.getElementById('userid-error').innerText = data.message;
                        document.getElementById('userid').classList.add('input-error'); 
                    }
                    else if(data.status == 'passErr'){
                        document.getElementById('password-Err').innerText = data.message;
                        document.getElementById('password').classList.add('input-error');
                    }
                    else if(data.status == 'PasaMis'){
                        document.getElementById('Re-password-Err').innerText = data.message;
                        document.getElementById('re-password').classList.add('input-error');
                    }
                    else{
                        document.getElementById('backendErr').innerText = data.message;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
            }
        });
    </script>

</body>
</html>