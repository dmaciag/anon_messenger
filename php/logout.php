<?php

session_start();
require '../functions.php';

if( $_SESSION['is_logged_in'] ){
	session_destroy();
	if( !redirect_signin() ) die('did not redirect to sign in from logout');
}
else{
	die('Should not be logged in');
}

?>