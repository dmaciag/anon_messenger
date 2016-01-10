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
    <form ng-submit="submit_user()" ng-controller="usersCtrl">
      <div id="search_user_container" class="dropdown-container">
        <div id="search_results">
          <table id="users_table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><input id="users_table_input" type="text" ng-model="search_query" ng-keyup="search_keyup($event)" placeholder="Request a friend"/></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="user in users | user_search_filter:search_query">
                <td ng-click="count = count +1" ng-init="count=0">{{user.username}} , {{count}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        Search Query: {{search_query}} <br>
        Requested friend : {{requested_friend}}
      </div>
    </form>
    <div ng-controller="friendsCtrl">
      <table id="friends_table" class="table table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Your Friends</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="friend in friends | orderBy : 'name' ">
            <td>{{friend.name}}</td>
          </tr>
        </tbody>
      </table>
    <div>
    <button id="settings_button" onclick="window.location.href='./settings.php'" class="btn btn-default">Settings</button>
    <button id="logout_button" onclick="window.location.href='./logout.php'" class="btn btn-default">Logout</button>
    <script src="../js/messenger.js"></script>
  </body>
</html>
