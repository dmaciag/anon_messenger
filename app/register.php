<?php
  session_start();
  require '../functions.php';
  if($_SESSION['is_logged_in']){
    if( !redirect_messenger() ) die('failed to redirect to messenger from login');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/register.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container">
      <form id="form_check_password" class="form-signin" action="./validate_register.php" method="post">
        <h2 class="form-signin-heading" >Enter information</h2>
        <?php 
              if( $_SESSION['user_already_exists_in_db'] ) {
                  echo "<p>   User already exists </p>"; 
              }
        ?>
        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control"  placeholder="Username" required>
        <label for="last_name" class="sr-only">Email</label>
        <input type="email" name="email" id="email" class="form-control"  placeholder="Email" required>
        <label for="inputPassword_first" class="sr-only">Password</label>
        <input type="password" name="password_first" id="inputPassword_first" class="form-control" placeholder="Password" required>
        <label for="inputPassword_second" class="sr-only">Confirm Password</label>
        <input type="password" name="password_second" id="inputPassword_second" class="form-control" placeholder="Confirm Password" required>
        <button id="register_button" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      </form>   
    </div>
    <script src="../js/register.js"></script>
  </body>
</html>
