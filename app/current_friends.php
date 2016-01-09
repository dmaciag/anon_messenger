<?php

session_start();
error_reporting(E_ERROR | E_PARSE);

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die('Something went wrong on the messenger page.');
}

echo "Logged in as: " . $_SESSION['username'] . "<br>";
echo "Friends: " . "<br>";

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$username = strip_data($_SESSION['username']);

$friendships = "SELECT * FROM friend_combinations 
WHERE receiver_name = '$username' OR requestor_name ='$username' AND are_friends = true";
$friendship = mysql_query( $friendships );

while( $friend = mysql_fetch_assoc($friendship) ){
    if( $friend['receiver_name'] === $username) {
    	echo $friend['requestor_name'];
    	echo " ";
    }
    else if($friend['requestor_name'] === $username){
    	echo $friend['receiver_name'];
    }
    echo "<br>";
}

mysql_close();

?>