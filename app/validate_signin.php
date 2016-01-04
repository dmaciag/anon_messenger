<?php

require "./../config.php";

$connect = mysql_connect($hostname, $username, $password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db) ) die('Cannot connect to db : $db, ' . mysql_error());

$email = $_POST[email];
$email = stripslashes($email);

$password = $_POST[password];
$password = stripslashes($password);

$sql_query = "SELECT username, password FROM registered_users WHERE username = \"$email\"";
$registered_users = mysql_query($sql_query);

if( !$registered_users ){
	$error_mesage  = 'Invalid query error: ' . mysql_error() . "\n";
	$error_mesage .= 'Desired query: ' . $sql_query;
	die($error_mesage);
}

if( mysql_num_rows($registered_users) == 1 ){
	$user = mysql_fetch_assoc($registered_users);

	if( $user["username"] == $email && $user["password"] == $password ){
		echo "Welcome, $email !";
		
	}
	else{
		echo "Invalid password !";
	}
}
else{
	echo "User is not registered. " .'<br>';
}

mysql_close($connect);

?>