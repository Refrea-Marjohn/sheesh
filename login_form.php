<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    // Check database connection
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Sanitize user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];

    // Prepare the query to avoid SQL injection
    $select = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($stmt, "s", $email); // Binding the email parameter

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a matching record is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($pass, $row['password'])) {
            // Set session variables based on the user data
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type']; // Added session for user type

            // Redirect based on user type
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header('Location: admin_page.php');
                exit();
            } elseif ($row['user_type'] == 'attorney') {
                $_SESSION['attorney_name'] = $row['name'];
                header('Location: attorney_page.php');
                exit();
            } else {
                header('Location: user_page.php');
                exit();
            }
        } else {
            // Password mismatch
            $_SESSION['error'] = "Incorrect email or password!";
            header("Location: login_form.php");
            exit();
        }
    } else {
        // No account found
        $_SESSION['error'] = "Account does not exist!";
        header("Location: login_form.php");
        exit();
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        height: 100vh;
        background: #f5f5f5;
    }

    .left-container {
        width: 45%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgb(43, 24, 13);
        padding: 50px;
        position: relative;
    }

    .title-container {
        display: flex;
        align-items: center;
        position: absolute;
        top: 20px;
        left: 30px;
    }

    .title-container img {
        width: 40px;
        height: 40px;
        margin-right: 8px;
    }

    .title {
        font-size: 22px;
        font-weight: bold;
        color: #ffffff;
    }

    .form-header {
        font-size: 25px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 45px;
        margin-top: 35px;
        color: #ffffff;
    }

    .form-container {
        text-align: center;
    }

    .form-container label {
        font-size: 13px;
        font-weight: bold;
        display: block;
        margin: 12px 0 5px;
        color: #ffffff;
        text-align: left;
    }

    .form-container input {
        width: 350px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-bottom: 2px solid #ffffff;
        background: transparent;
        color: #ffffff;
        outline: none;
        transition: all 0.3s ease;
    }

    .form-container input:focus {
        border-bottom: 2px solid #ffcc00;
    }

    .form-container input::placeholder {
        color: rgba(255, 255, 255, 0.6);
        font-style: italic;
    }

    .form-links {
        display: flex;
        justify-content: flex-start;
        margin-top: 10px;
    }

    .form-links a {
        font-size: 14px;
        text-decoration: none;
        color: rgb(221, 224, 8);
        font-weight: bold;
    }

    .form-links a:hover {
        text-decoration: underline;
    }

    .form-container .form-btn {
        background: rgb(94, 79, 62);
        color: white;
        border: 2px solid white;
        cursor: pointer;
        padding: 12px;
        font-size: 18px;
        width: 100%;
        margin-top: 18px;
        border-radius: 6px;
    }

    .form-container .form-btn:hover {
        background: rgb(41, 37, 32);
    }

    .or-text {
        color: white;
        margin: 15px 0;
        font-size: 14px;
    }

    .social-login {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-login a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #f5f5f5;
        border-radius: 50%;
        font-size: 20px;
        color: #333;
        transition: 0.3s;
        text-decoration: none;
    }

    .social-login a:hover {
        background: rgb(221, 224, 8);
        color: white;
    }

    .right-container {
    width: 55%;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    padding: 50px;
    overflow: hidden;
}

.right-container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('atty.jpg') center center/cover no-repeat;
    filter: blur(-6px);
    opacity: 0.8;
    z-index: -1;
}

    .register-box h1 {
        font-size: 45px;
        font-weight: bold;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        animation: typing 3s steps(30, end) forwards;
        margin-bottom: 30px;
    }

    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }

    .register-btn {
        display: inline-block;
        background: rgb(94, 79, 62);
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        font-size: 18px;
        border-radius: 6px;
        border: 2px solid white;
        transition: background 0.3s ease;
    }

    .register-btn:hover {
        background: rgb(41, 37, 32);
    }

    @media (max-width: 768px) {
        body {
            flex-direction: column;
        }

        .left-container, .right-container {
            width: 100%;
            height: 50vh;
        }
    }

.password-container {
    position: relative;
    width: 350px;
}

.password-container input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-bottom: 2px solid #ffffff;
    background: transparent;
    color: #ffffff;
    outline: none;
}

.password-container i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: rgba(255, 255, 255, 0.7);
}

.password-container i:hover {
    color: #ffcc00;
}

.error-popup {
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: rgb(255, 77, 77);
    color: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    z-index: 1000;
    width: 80%;
    max-width: 350px;
}

.error-popup p {
    margin: 0;
    font-size: 16px;
}

.error-popup button {
    background: white;
    border: none;
    padding: 5px 10px;
    color: rgb(255, 77, 77);
    font-weight: bold;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 3px;
}

.error-popup button:hover {
    background: #f5f5f5;
}

</style>
</head>
<body>
    <!-- Incorrect/invalid acc prompt -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-popup">
            <p><?php echo $_SESSION['error']; ?></p>
            <button onclick="closePopup()">OK</button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <!-- Incorrect/invalid acc prompt end-->

    <div class="left-container">
        <div class="title-container">
            <img src="logo.jpg" alt="Logo">
            <div class="title">LawFirm.</div>
        </div>

        <div class="form-container">
            <h2 class="form-header">Login</h2>

            <form action="" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" required placeholder="Enter your email">

                <!-- Error Message Popup -->
                <?php if (isset($_SESSION['error'])): ?>
                    <script>
                        alert("<?php echo $_SESSION['error']; ?>");
                    </script>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <!-- Error Message Popup End -->

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required placeholder="Enter your password">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>

                <div class="form-links">
                    <a href="#">Forgot Password?</a>
                </div>

                <input type="submit" name="submit" value="Login Now" class="form-btn">

                <div class="or-text">or</div>

                <div class="social-login">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="right-container">
        <div class="register-box">
            <h1>Don't have an account?</h1>
        </div>
        <a href="register_form.php" class="register-btn">Register Now</a>
    </div>

    <!--Script for Show password-->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            let icon = this;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
    <!--Script for Show password End-->

    <!--Script for close prompt-->
    <script>
    function closePopup() {
        document.querySelector('.error-popup').style.display = 'none';
    }
    </script>
    <!--Script for close prompt end-->

    <script src="https://kit.fontawesome.com/cc86d7b31d.js" crossorigin="anonymous"></script>
</body>
</html>
