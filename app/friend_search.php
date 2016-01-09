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

$registered_users_sql = "SELECT * FROM registered_users";
$registered_users = mysql_query( $registered_users_sql );

while( $user = mysql_fetch_assoc($registered_users) ){
    $json_user['username'] = $user["username"];
    $json_user_response[]  = $json_user;

}

$search_arr = array("users" => $json_user_response);

mysql_close();

echo json_encode($search_arr);


?>