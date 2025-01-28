<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }

 if(isset($_POST['submitR'])){

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING); 
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   
 
    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_users->execute([$email]);
 
    if($select_users->rowCount() > 0){
       $warning_msg[] = 'email already taken!';
    }else{
       if($pass != $c_pass){
          $warning_msg[] = 'Password not matched!';
       }else{
          $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, type, password) VALUES(?,?,?,?,?,?)");
          $insert_user->execute([$id, $name, $number, $email, $type, $c_pass]);
          
          if($insert_user){
             $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
             $verify_users->execute([$email, $pass]);
             $row = $verify_users->fetch(PDO::FETCH_ASSOC);
          
             if($verify_users->rowCount() > 0){
                setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
                header('location:login.php');
             }else{
                $error_msg[] = 'something went wrong!';
             }
          }
 
       }
    }
 
 }


 if(isset($_POST['submitL'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
 
    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $select_users->execute([$email, $pass]);
    $row = $select_users->fetch(PDO::FETCH_ASSOC);
 
    if($select_users->rowCount() > 0){
       setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
       header('location:Main.php');
    }else{
       $warning_msg[] = 'Incorrect username or password!';
    }
 
 }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!----header-------->
<?php include 'components/user_header.php';

?>
<!----registersection--->
<div class="body">
<div class="container1" id="container1">
        <div class="form-container1 sign-up">    
            <form action="login.php" method="post">
                <h1 class="name">Create Account</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <span class="desc">Use your email for registeration</span>
                <input type="text" placeholder="Name" name="name" required maxlength="50">
                <input type="email" placeholder="Email" name="email" required maxlength="50">
                
                  <select name="type" required class="input">
                     <option value="student">Student</option>
                     <option value="local_community">Local Community</option>
                  </select>
                
                <input type="text" name="number" required min="0" max="9999999999" maxlength="10" placeholder="Enter your Tel. number">
                <input type="password" placeholder="Password" name="pass" required maxlength="20">
                <input type="password" name="c_pass" required maxlength="20" placeholder="confirm your password">
                <!-- <input type="submit" value="Sign Up" name="submit" class="btn"> -->
                <button name="submitR">Sign Up</button>
            </form>
        </div>
        <div class="form-container1 sign-in">
            <form action="" method="post">
                <h1 class="name">Sign In</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <span class="desc">Use your email & password</span>
                <input type="email" name="email" placeholder="Email" required maxlength="50">
                <input type="password" name="pass" placeholder="Password" required maxlength="20">
                
                <button name="submitL">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, User!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!----footer---->

    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="js/script.js"></script>
<script src="js/login.js"></script>
<?php include 'components/message.php'; ?>
</body>
</html>             

