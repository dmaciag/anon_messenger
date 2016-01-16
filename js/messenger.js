var app = angular.module('messenger', ['ngMdIcons']);

app.controller('usersCtrl', function($scope, $http, $timeout) {

	$scope.search_keyup = function(keyPress){
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
			$scope.requested_friend = this.search_query;

			$http({
				method: 'GET',
				url: './request_friend.php',
				params: { 'search_query' : this.search_query }
			}).
			success(function(response){
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
		$scope.users = response || 'Failed to grab current friends';
	});

	$scope.selected_friend = function(){
		$scope.selected = this.friend;
		$http({
			method: 'POST',
			url: './get_messages.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : $scope.selected['name'] }
		}).
		success(function(response){
			$scope.messages = response;
			console.log('messages: ');
			console.log($scope.messages);
		}).
		error(function(response){
			console.log('error response');
		});
		console.log($scope.friend_body_message);
	}
});

app.controller('friend_requestsCtrl', function($scope, $http){
	$http({
		method: 'POST',
		url: './friend_requests.php',
	}).
	success(function(response){
		if(response[0]['warning'] != null){
			$scope.warning_message = response[0]['warning'];
			$scope.has_friend_requests = false;
		}
		else
		{		
			$scope.has_friend_requests = true;
			$scope.friend_requests = response;
		}
	}).
	error(function(response){
		$scope.friend_requests = response || 'Failed to grab friend_requests';
	});

	$scope.accept_friend_request = function(friend){
		$http({
			method: 'POST',
			url: './accept_friend_request.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : friend }
		});
	};
	$scope.reject_friend_request = function(friend){
		$http({
			method: 'POST',
			url: './reject_friend_request.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : friend }
		});
	};
});
