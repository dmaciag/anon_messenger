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

app.controller('friends_and_messagesCtrl', function($scope, $http, $rootScope){
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

	//also gets messages
	$scope.selected_friend = function(){
		$scope.selected = this.friend;
		$scope.current_friend = this.friend;
		console.log('selected friend: %o', $scope.current_friend);
		$http({
			method: 'POST',
			url: './get_messages.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : $scope.selected['name'] }
		}).
		success(function(response){
			$scope.all_messages   = response['all_messages'];
			console.log($scope.all_messages);

		}).
		error(function(response){
			console.log('error response');
		});
	}

	$scope.send_message = function(keyDown){
		if( 
			keyDown.keyCode == 13 && 
			keyDown.shiftKey == false  && 
			$scope.the_message != null && 
			$scope.the_message != ""
		  )
		{
            keyDown.preventDefault();
            var date = new Date();

            console.log('date: %o', $scope.date);
            $scope.inject_message = {
            	'message' 			: $scope.the_message,
            	'date_created'   	: '2016-01-18 06:20:20',
            	'sender'			: 'current_user'
            };
            $scope.all_messages = $scope.all_messages.concat($scope.inject_message);
            for(var i = 0; i< $scope.all_messages.length; i++){
            	console.log($scope.all_messages[i]['sender']);
            }

			$http({
				method: 'POST',
				url: './send_message.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: { 				
					'message' : $scope.the_message,
					'friend'  : $scope.current_friend['name'],
					'date_created' : date
				}
			}).success(function(response){
				console.log(response);
			}).error(function(){
				console.log(response);
			});
			$scope.the_message = '';

			var message_body = document.getElementById("messages_body_id");
			message_body.scrollTop = message_body.scrollHeight;
		}
	};
});

app.controller('friend_requestsCtrl', function($scope, $http, $rootScope){
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




