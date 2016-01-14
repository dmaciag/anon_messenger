<?php

session_start();

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the add_friend page.');
}
$friend_data = json_decode( file_get_contents('php://input') , true);

$friend_username  = $friend_data['friend'];
$current_username = $_SESSION['username'];

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$update_friendships_sql = 
"UPDATE friend_combinations
 SET    are_friends    = true
 WHERE  receiver_name  = '$current_username'
 AND 	requestor_name = '$friend_username'";

$updated_friendship = mysql_query($update_friendships_sql);



mysql_close($connect);
//todo

?>