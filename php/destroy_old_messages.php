<?php

session_start();

require '../config.php';
require '../functions.php';

if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the friend_search page.');
}

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if( !$connect ) die('Connection to mysql failed, error : ' . mysql_error());

if( !mysql_select_db($db_db) ) die('Cannot connect to db : $db_db, ' . mysql_error());

$message_to_be_destroyed = json_decode( file_get_contents('php://input') , true);

if( !empty( $message_to_be_destroyed ) ){

    $message_id = $message_to_be_destroyed['del_message']['id'];
    if( !empty( $message_id ) ){
        $delete_sql = "DELETE FROM messages WHERE id = '$message_id'"; 
        mysql_query( $delete_sql );
    }
    else{
        $error = "empty message id";
        echo json_encode( array( 'error' => $error ) );
    }  
    mysql_close( $connect );
}
else{
    mysql_close( $connect );
    $error = "empty message";
    echo json_encode( array( 'error' => $error ) );
}

?>