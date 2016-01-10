var app = angular.module('messenger', []);

app.controller('usersCtrl', function($scope, $http) {

	$scope.search_keypress = function(keyPress){
		$http({
			method: 'GET',
			url: './friend_search.php',
			params: { 'search_query' : $scope.search_query }
		}).
		success(function(response){
			$scope.users = response.users;
		}).
		error(function(response){
			$scope.users = response || 'Failed to grab users';
		});

	};

	$scope.requested_friends = '';

	$scope.submit_user = function() {
	    if ($scope.search_query) {
			$scope.requested_friends = this.search_query;
			$scope.search_query = '';
	    }
	};
});

app.filter('user_search_filter', function(){
	return function(search_array, search_query){
		if(!search_query){
			return search_array;
		}

		var search_result = [];
		angular.forEach(search_array, function(user){
			if(user.username.indexOf(search_query) !== -1){
				search_result.push(user);
			}
		});
		return search_result;
	}
});

app.controller('friendsCtrl', function($scope, $http){
	$http({
		method: 'GET',
		url: './current_friends.php'
	}).
	success(function(response){
		$scope.friends = response.friends;
	}).
	error(function(response){
		$scope.users = response || 'Failed to grab friends';
	});
});

