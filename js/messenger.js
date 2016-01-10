var app = angular.module('messenger', []);

app.controller('usersCtrl', function($scope, $http) {

    $http.get("./friend_search.php")
    .then(function(response) {
        $scope.users = response.data.users;
      });

	$scope.requested_friends = [];

	$scope.submit_user = function() {
	    if ($scope.search_query) {
			$scope.requested_friends.push(this.search_query);
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
	$http.get('./current_friends.php').then(function(response){ 
		$scope.friends = response.data.friends;
	});
});