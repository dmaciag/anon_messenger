var app = angular.module('messenger', ['ngMdIcons', 'luegg.directives']);

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

app.controller('friends_and_messagesCtrl', function($scope, $http, $rootScope, $interval){
	$rootScope.max_id = 1;
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

	$rootScope.is_on_default_page = true;

	$scope.make_current = function(){
		$scope.friend_selected_row_name = this.friend['name'];
	};

	//also gets messages
	$scope.selected_friend = function(){

		$scope.selected = this.friend;
		$scope.current_friend = this.friend;

		$http({
			method: 'POST',
			url: './get_messages.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			data: { 'friend' : $scope.selected['name'] }
		}).
		success(function(response){
			$scope.all_messages = response['all_messages'];
			$rootScope.max_id   = response['latest_message_id'];
		}).
		error(function(response){
			console.log('initial error response %o: ', response);
		});

		if( $rootScope.is_on_default_page ){
			$interval(function(){
				$http({
					method: 'POST',
					url: './get_messages.php',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data: { 'friend' : $scope.selected['name'] }
				}).
				success(function(response){
					$scope.all_messages = response['all_messages'];
				}).
				error(function(response){
					console.log('continous error response %o: ', response);
				});
			}, 2000);
		}
		$rootScope.is_on_default_page = false;


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

            //need to build better way of grabbing id, probably through http
            $scope.inject_message = {
            	'message' 			: $scope.the_message,
            	'date_created'		: '2016-01-19 05:55:55',
            	'sender'			: 'current_user',
            };

            //change 8 to 20, 8 is for testing purposes
            if( $scope.all_messages.length >= 8 ) {
            	$scope.message_to_be_deleted = $scope.all_messages[0];
            	$scope.all_messages.shift();
            	
            	$http({
					method: 'POST',
					url: './destroy_old_messages.php',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data: { 				
						'del_message' : $scope.message_to_be_deleted
					}
				}).error( function(response){
					console.log('failed to delete old message : %o', response);
				});

            }
            
            $scope.all_messages.push($scope.inject_message);

			$http({
				method: 'POST',
				url: './send_message.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: { 				
					'message'     : $scope.the_message,
					'friend'      : $scope.current_friend['name'],
				}
			}).error(function(){
				// need something like growl
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




