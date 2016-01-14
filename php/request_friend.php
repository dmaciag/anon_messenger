<?php

session_start();

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the add_friend page. error #10101');
}

$friend_username = strip_data($_GET['search_query']);
$current_username = strip_data($_SESSION['username']);

if( $friend_username === $current_username){
	echo 'cannot add yourself';
}
else if(empty($friend_username)){ 
	echo 'empty';
}
else{

	$connect = mysql_connect($db_hostname, $db_username, $db_password);

	if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

	if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

	$find_friend_sql = "SELECT username 
						FROM registered_users 
						WHERE username = '$friend_username'";
	$find_friend = mysql_query($find_friend_sql);

	if(mysql_num_rows($find_friend) == 1) {
		$check_friendships_sql = 	"SELECT requestor_name, receiver_name, are_friends 
									 FROM 	friend_combinations 
									 WHERE (requestor_name = '$current_username' 
									 AND 	receiver_name  = '$friend_username') 
									 OR    (receiver_name  = '$current_username' 
									 AND 	requestor_name = '$friend_username')";
		$check_friendships = mysql_query($check_friendships_sql);

		if( mysql_num_rows($check_friendships) >= 1 ){
			mysql_close($connect);
			echo 'already has friendship';
		}
		else{
			$insert_friendship_sql =   
			"INSERT INTO friend_combinations (requestor_name, receiver_name, are_friends)
			 VALUES ('$current_username', '$friend_username', false)";

			$inserted_friendship = mysql_query($insert_friendship_sql);

			if( !$inserted_friendship ){
				$error_mesage  = 'Invalid query error: ' . mysql_error() . "<br>";
				$error_mesage .= 'Desired query: ' . $insert_friendship_sql;
				die( $error_mesage );
			}
			mysql_close($connect);
			echo "sent friend request to $friend_username";
		}
	}
	else if(mysql_num_rows($find_friend) === 0){
		mysql_close($connect);
		echo 'user not found';
	}
	else{
		mysql_close($connect);
		echo 'Should not have found more than one of the same friend';
	}
}

?>