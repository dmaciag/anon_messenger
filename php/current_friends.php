<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the messenger page.');
}

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$username = strip_data($_SESSION['username']);

$friendships =  
"SELECT * FROM friend_combinations 
 WHERE  (receiver_name  = '$username' 
 AND 	 are_friends    = true)
 OR 	(requestor_name ='$username' 
 AND 	 are_friends    = true)";
$friendship = mysql_query( $friendships );

while( $friend = mysql_fetch_assoc($friendship) ){
    if( $friend['receiver_name'] === $username) {
    	$json_friend['name'] = $friend['requestor_name'];
    	$json_friend_response[] = $json_friend;
    }
    else if($friend['requestor_name'] === $username){
    	$json_friend['name'] = $friend['receiver_name'];
    	$json_friend_response[] = $json_friend;
    }
}
$response_arr = array('friends' => $json_friend_response);

mysql_close($connect);

echo json_encode($response_arr);

?>