var messenger_app = angular.module('messenger', []);

messenger_app.controller('usersCtrl', function($scope, $http) {
    $http.get("http://www.w3schools.com/angular/customers.php")
    .then(function(response) {$scope.names = response.data.records;});
});