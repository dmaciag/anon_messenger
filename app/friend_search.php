<?php

session_start();

require '../functions.php';
require '../config.php';

if( !$_SESSION['is_logged_in'] ){
	if( !redirect_signin() ) die( 'failed to redirect to signin from friend search ajax' ); 
}

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$q = $_GET['q'];
echo $q . "<br>";
for($i =0; $i < sizeof($q); $i++){
	echo $q . "<br>";
	$regexp_user .= "[" . $q[$i] . "]"; 
}
$registered_users_sql = "SELECT username FROM registered_users WHERE username REGEXP '^$regexp_user.*$'";
$registered_users = mysql_query( $registered_users_sql );

while( $user = mysql_fetch_assoc($registered_users) ){
	echo $user["username"] . "<br>";
}

mysql_close();

?>

<!DOCTYPE html>
<html>
<head>
	
</head>

<body>
	
</body>

</html>