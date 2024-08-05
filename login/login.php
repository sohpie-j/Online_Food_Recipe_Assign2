<?php
include '../conn/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signUp'])) {
        // Handle user registration
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $email = $_POST['email'];
        // $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Using password hashing
        $password = $_POST['password']; // Storing password in plain text

        $checkEmail = $conn->prepare("SELECT * FROM tbl_users WHERE email = :email");
        $checkEmail->bindParam(':email', $email);
        $checkEmail->execute();

        if ($checkEmail->rowCount() > 0) {
            echo "<script>alert('Email Address Already Exists!');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO tbl_users (first_name, last_name, email, password) VALUES (:fName, :lName, :email, :password)");
            $stmt->bindParam(':fName', $fName);
            $stmt->bindParam(':lName', $lName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                echo "<script>alert('User registered successfully.'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Error: User registration failed.');</script>";
            }
        }
    }

    if (isset($_POST['signIn'])) {
        // Handle user login
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && $password === $user['password']) { // Comparing plain text passwords
            session_start();
            $_SESSION['user_email'] = $user['email'];
            echo "<script>alert('Login successful.'); window.location.href = '../foodlist.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="login_header">
        <ul class="login_nav">
            <li><a href="../home.php">Home</a></li>
            <li><a href="../foodlist.php">Food List</a></li>
            <li><a href="login.php">Login/Sign Up</a></li>
        </ul>
    </div>

    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Register</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" placeholder="First Name" autocomplete="off" required>
                <label for="fName">First Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" placeholder="Last Name" autocomplete="off" required>
                <label for="lName">Last Name</label>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" autocomplete="off" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password" required>
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <div class="links">
            <p>Already Have Account ?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" autocomplete="off" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password" required>
                <label for="password">Password</label>
            </div>
            <p class="recover"><a href="#">Recover Password</a></p>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <div class="links">
            <p>Don't have account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <script>
        document.getElementById('signUpButton').addEventListener('click', function() {
            document.getElementById('signup').style.display = 'block';
            document.getElementById('signIn').style.display = 'none';
        });

        document.getElementById('signInButton').addEventListener('click', function() {
            document.getElementById('signup').style.display = 'none';
            document.getElementById('signIn').style.display = 'block';
        });
    </script>
</body>
</html>
