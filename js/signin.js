var app = angular.module('sign_in_app', []);

app.controller('sign_in_ctrl', function($scope, $http){
	// $scope.submit_sign_in = function(){
	// 		console.log('get request');
	// 		$http({
	// 			method: 'POST',
	// 			url: './validate_signin.php',
	// 			params: { 	'username_query' : $scope.username_query,
	// 						'password_query' : $scope.password_query
	// 					}
	// 		}).
	// 		success(function(response){	
	// 			$scope.signin_message = response;
	// 			//$scope.users = response.users;
	// 		}).
	// 		error(function(response){
	// 			console.log('error');
	// 			$scope.users = response || 'Failed to grab users';
	// 		});
	// 	};
	
});
console.log('yo');