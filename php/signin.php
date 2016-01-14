<?php
  session_start();
  error_reporting(E_ERROR | E_PARSE);
  require '../functions.php';
  if($_SESSION['is_logged_in']){
    if( !redirect_messenger() ) die('failed to redirect to messenger from login');
  }
?>
<!DOCTYPE html>
<html lang="en" ng-app="sign_in_app">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Sign in</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/angular/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-messages.js"></script>
  </head>
  <body>
    <div class="container">
      <form
          method="POST"
          name="sign_in_form" 
          id="signin_form" 
          class="form-signin"
          action="./validate_signin.php"
          >
        <h2 class="form-signin-heading" >Please sign in</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input
            type="text" 
            name="username" 
            id="inputUsername" 
            class="form-control"  
            placeholder="Username" 
            required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox" >
          <label>
            <input type="checkbox" value="remember-me"> Remember me?
          </label>
        </div>
        <button id="signin_button" class="btn btn-primary" type="submit">Sign in</button>
        <button id="register_button" onclick="window.location.href='./register.php'" type="button" class="btn btn-block">Register</button>
      </form>
    </div>
    <script type="text/javascript" src="../js/signin.js"></script>>
  </body>
</html>