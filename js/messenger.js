var app = angular.module('myApp', []);

app.controller('customersCtrl', function($scope, $http) {
    $http.get("./friend_search.php")
    .then(function(response) {
        $scope.users = response.data.users;
      });
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