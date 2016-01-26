var app = angular.module('messenger', ['ngMdIcons']);

app.controller('usersCtrl', function($scope, $http, $timeout) {

	$scope.search_keyup = function(keyUp){
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
		// if( keyUp.keyCode == 13 ){
		// 	$scope.users = [];
		// }
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

	console.log('main');
	$rootScope.is_on_default_page = true;

	$scope.make_current = function(){
		$scope.friend_selected_row_name = this.friend['name'];
	};

	//also gets messages
	$scope.selected_friend = function(){

		$rootScope.is_on_default_page = false;


		$scope.selected = this.friend;
		$scope.current_friend = this.friend;
		$http({
			method: 'POST',
			url: './get_messages.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : $scope.selected['name'] }
		}).
		success(function(response){
			$scope.all_messages   = response['all_messages'];
		}).
		error(function(response){
			console.log('error response %o: ', response);
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
			if( $rootScope.id == null ) $rootScope.id = 300;
			++$rootScope.id;
            keyDown.preventDefault();
            var date = new Date();
            //need to build better way of grabbing id, probably through http
            // $scope.message_id = ++$scope.all_messages[$scope.all_messages.length - 1]['id'];
            $scope.inject_message = {
            	'message' 			: $scope.the_message,
            	'date_created'		: '2016-01-19 05:55:55',
            	'sender'			: 'current_user',
             	'id'				: 300
            };

            $scope.all_messages.push($scope.inject_message);

			$http({
				method: 'POST',
				url: './send_message.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: { 				
					'message' : $scope.the_message,
					'friend'  : $scope.current_friend['name']
				}
			}).success(function(response){
			}).error(function(){
				console.log("error: %o", response);
			});

			$scope.the_message = '';

			var message_body = document.getElementById("messages_body_id");
			message_body.scrollTop = message_body.scrollHeight;
		}
	};
});

app.controller('friend_requestsCtrl', function( $scope, $http, $rootScope ){

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

		var friend_obj = {
			'name' : friend
		};
		
		var move_to_friends_index = _.findIndex($scope.friend_requests, friend_obj);
		
		$scope.friends.push(friend_obj);
		
		if( move_to_friends_index !== null){
			$scope.friend_requests.splice(move_to_friends_index, 1);
		}
	};

	$scope.reject_friend_request = function(friend){
		$http({
			method: 'POST',
			url: './reject_friend_request.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : friend }
		});

		var unwanted_friend_obj = {
			'name' : friend
		};

		var delete_friend_request_index = _.findIndex($scope.friend_requests, unwanted_friend_obj);

		if( delete_friend_request_index !== null){
			$scope.friend_requests.splice(delete_friend_request_index, 1);
		}

	};

});




