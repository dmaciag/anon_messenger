<?php

session_start();

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the add_friend page. error#10221');
}

$current_username = strip_data($_SESSION['username']);
$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$find_friend_requests_sql = 
	"SELECT requestor_name, receiver_name, are_friends 
	 FROM   friend_combinations 
	 WHERE  (requestor_name = '$current_username'
	 AND     are_friends    = false)
	 OR     (receiver_name  = '$current_username'
	 AND     are_friends    = false)";
$find_friend_requests = mysql_query($find_friend_requests_sql);

$friends = array();
$count_of_friends = 0;
if( mysql_num_rows( $find_friend_requests ) >= 1 ) {
	while( $friend_request = mysql_fetch_assoc( $find_friend_requests ) ){
		if( $friend_request['receiver_name']  === $current_username ){
			$friend = array('name' => $friend_request['requestor_name']);
			array_push($friends, $friend);
			$count_of_friends++;
		}
	}
	mysql_close($connect);
	if( $count_of_friends !== 0) echo json_encode($friends);
	else echo json_encode(array(array('name' => 'No incoming requests')));
}
else if( mysql_num_rows( $find_friend_requests ) === 0 ){
	mysql_close($connect);
	echo json_encode(array(array('name' => 'No pending requests')));
}
else{
	mysql_close($connect);
	echo json_encode(array(array('name' => 'Should not get here error#10222')));
}

?>