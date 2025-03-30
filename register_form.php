<?php
@include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $name = filter_var(mysqli_real_escape_string($conn, $_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(mysqli_real_escape_string($conn, $_POST['email']), FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $user_type = $_POST['user_type']; // Allow selection of user type

    if (!$email) {
        $error[] = 'Invalid email format!';
    } else {
        $select = "SELECT * FROM user_form WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists!';
        } else {
            if ($pass !== $cpass) {
                $error[] = 'Passwords do not match!';
            } else {
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $insert = "INSERT INTO user_form (name, email, password, user_type) 
                            VALUES ('$name', '$email', '$hashed_pass', '$user_type')";
                if (mysqli_query($conn, $insert)) {
                    header('location: login_form.php');
                    exit();
                } else {
                    $error[] = 'Registration failed, try again!';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
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
        margin-bottom: 15px;
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
        margin-left: 85px;
        color: #ffffff;
        text-align: left;
    }

    .form-container input, 
    .form-container select {
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

    .form-container input:focus,
    .form-container select:focus {
        border-bottom: 2px solid #ffcc00;
    }

    .form-container input::placeholder {
        color: rgba(255, 255, 255, 0.6);
        font-style: italic;
    }

    /* Register Now Button with Box Effect */
    .form-container .form-btn {
        background: rgb(94, 79, 62);
        color: white;
        border: 2px solid white;
        cursor: pointer;
        padding: 12px;
        font-size: 18px;
        width: 73s%;
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
    opacity: 0.8; /* Adjust transparency */
    z-index: -1;
}

    .register-box h1 {
        font-size: 45px;
        font-weight: bold;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        /* background: rgba(206, 206, 206, 0.6); */
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

    /* Login Now Button Styling with Box Effect */
    .login-btn {
        display: inline-block;
        background: rgb(94, 79, 62);
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        font-size: 18px;
        border-radius: 6px;
        border: 2px solid white; /* Box effect */
        transition: background 0.3s ease;
    }

    .login-btn:hover {
        background: rgb(41, 37, 32);
    }

    /* Ensure Login Now button is separate from header */
    .login-btn {
        animation: none;
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
    </style>
</head>
<body>
<div class="left-container">
    <div class="title-container">
        <img src="logo.jpg" alt="Logo">
        <div class="title">LawFirm.</div>
    </div>

    <div class="form-container">
        <h2 class="form-header">Create Your Account</h2>
        
        <form action="" method="post">
            <?php if (isset($error)) {
                foreach ($error as $err) {
                    echo '<span class="error-msg">' . $err . '</span>';
                }
            } ?>

            <label for="name">Full Name</label>
            <input type="text" name="name" required placeholder="Enter your full name">

            <label for="email">Email</label>
            <input type="email" name="email" required placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" name="password" required placeholder="Enter your password">

            <label for="cpassword">Confirm Password</label>
            <input type="password" name="cpassword" required placeholder="Confirm your password">

            <label for="user_type">Account Type</label>
            <select name="user_type">
                <option value="user">User</option>
                <option value="attorney">Attorney</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" name="submit" value="Register Now" class="form-btn">
        </form>
    </div>
</div>

<div class="right-container">
    <div class="register-box">
        <h1>Already have an account?</h1>
    </div>
    <a href="login_form.php" class="login-btn">Login Now</a>
</div>

    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/cc86d7b31d.js" crossorigin="anonymous"></script>
</body>
</html>
