<?php
require 'config.php';

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pass = mysqli_real_escape_string($conn,md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn,md5($_POST['cpassword']));

    $select_users = mysqli_query($conn,"SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query faild');
    
    if(mysqli_num_rows($select_users) > 0){
        $message[] = 'user already exist!';
    }
    else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched';
        }
        else{
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, admin) VALUES ('$name','$email','$cpass',0)") or die('query faild');
            $message[] = 'registered successfully!';
            header('location:login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>Register</h3>
            <input type="text" name="name" placeholder="Enter your name" required class="box">
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <input type="password" name="password" placeholder="Enter your password" required class="box">
            <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
            <input type="submit" name="submit" value="Register now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>