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

$friend_data = json_decode( file_get_contents('php://input') , true);
$friend_username = $friend_data['friend'];

$user_messages_sql= 
"SELECT message
 FROM   messages
 WHERE  receiver  = '$friend_username'
 AND    sender    = '$username'";
 
$friend_messages_sql= 
"SELECT message
 FROM   messages
 WHERE  receiver  = '$username'
 AND    sender    = '$friend_username'";

$user_messages_data   = mysql_query( $user_messages_sql );
$friend_messages_data = mysql_query( $friend_messages_sql );

$user_messages   = array();
$friend_messages = array();

while( $user_message_data = mysql_fetch_assoc($user_messages_data) ){
	$message = $user_message_data['message'];	
	array_push($user_messages, $message);
}
while( $friend_message_data = mysql_fetch_assoc($friend_messages_data) ){
	$message = $friend_message_data['message'];	
	array_push($friend_messages, $message);
}

$POST_contents = array('user_messages' => $user_messages, 'friend_messages' => $friend_messages);

echo json_encode(($POST_contents));

?>