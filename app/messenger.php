<?php
  session_start();
  require '../functions.php';
  if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the messenger page.');
  }
?>
<!DOCTYPE html>
<html lang="en" ng-app="messenger">
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
  </head>
  <body>
  <?php echo 'user: ' . $_SESSION['username'] . "<br>"; ?>
    <form ng-submit="submit_user()" ng-controller="customersCtrl">
      <div id="search_user_container" class="dropdown-container">
        <input type="text" class="form-control" size="20" ng-model="search_query" placeholder="Request a friend" />
            <div id="search_results" ng-repeat="user in users | user_search_filter:search_query">
              {{ user.username }}
            </div>
        Requested friends : {{requested_friends}}
      </div>
    </form>
    <button id="settings_button" onclick="window.location.href='./settings.php'" class="btn btn-default">Settings</button>
    <button id="logout_button" onclick="window.location.href='./logout.php'" class="btn btn-default">Logout</button>
    <script src="../js/messenger.js"> </script>
  </body>
</html>
