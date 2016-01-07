<?php
  session_start();
  require '../functions.php';
  if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the messenger page.');
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
    <link rel="icon" href="../../favicon.ico">
    <title>Messenger</title>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php echo "Welcome : " . $_SESSION['username'] . "<br>"; ?>
    <button onclick="window.location.href='./logout.php'" type="button" class="btn btn-default" style="margin-left: 2px !important; padding: 12px 46px !important;">Log Out</button>
  </body>
</html>
