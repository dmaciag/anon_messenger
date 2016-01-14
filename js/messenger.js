var app = angular.module('messenger', []);

app.controller('usersCtrl', function($scope, $http, $timeout) {

	$scope.search_keyup = function(keyPress){
		
		console.log('searching!');
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

	$scope.requested_friend = '';
	$scope.submit_user = function() {
	    if ($scope.search_query) {
	    	console.log('searching!');
			$scope.requested_friend = this.search_query;

			$http({
				method: 'GET',
				url: './request_friend.php',
				params: { 'search_query' : this.search_query }
			}).
			success(function(response){
				console.log(response);
				$scope.message = response;
			}).
			error(function(response){
				$scope.users = response || 'Failed to send invite';
			});
	    }
	    $scope.search_query = '';
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
		console.log(search_result);
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

app.controller('friend_requestsCtrl', function($scope, $http){
		$http({
			method: 'POST',
			url: './friend_requests.php',
		}).
		success(function(response){
			console.log(response);
			$scope.friend_requests = response;
		}).
		error(function(response){
			$scope.friend_requests = response || 'Failed to grab friend_requests';
		});
});
