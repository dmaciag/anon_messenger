<?php
  session_start();
  require '../functions.php';
  if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the messenger page.');
  }
?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Messenger</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/messenger.css" type="text/css" rel ="stylesheet">
    <script src="../node_modules/angular/angular.js"></script>
    <!--<scripts src="../js/messenger.js"></script>-->
  </head>
  <body ng-app="myApp">
    <?php echo "Welcome : " . $_SESSION['username'] . "<br>"; ?>
    <input type="text" size="20" ng-model="search_query">
     <div ng-controller="customersCtrl">
      <ul>
        <li ng-repeat="user in users | user_search_filter:search_query">
          {{ user.username }}
        </li>
      </ul>
    </div>
    <button id="logout_button" onclick="window.location.href='./logout.php'" class="btn btn-lg btn-primary btn-block">Logout</button>
    <script src="../js/messenger.js"> </script>
  </body>
</html>
