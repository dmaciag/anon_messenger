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
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/messenger.css" type="text/css" rel ="stylesheet">
    <script src="../node_modules/angular/angular.js"></script>
    <!--<scripts src="../js/messenger.js"></script>-->
  </head>
  <body>
    <?php echo "Welcome : " . $_SESSION['username'] . "<br>"; ?>
    <form id="messenger_search">
    <input type="text" size="20">
     <div ng-app="myApp" ng-controller="customersCtrl">
<ul>
  <li ng-repeat="x in names">
    {{ x.Name + ', ' + x.Country }}
  </li>
</ul>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http) {
    $http.get("http://www.w3schools.com/angular/customers.php")
    .then(function(response) {$scope.names = response.data.records;
      console.log('scope names: %o', $scope.names);});
});
</script> 
  </body>
</html>
