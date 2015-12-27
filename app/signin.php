<?php

$server = "localhost";
$username = "root";
$password = "root";
$db = "my_db";

$conn = new mysqli($server, $username, $password, $db);

if($conn->connect_error){
	die("Connection failed.\n");
}

$email = $_POST[email];
$password = $_POST[password];

$sql = "SELECT * FROM registered_users WHERE username = \"$email\"";
$registered_users = $conn->query($sql);

if($registered_users->num_rows == 1 ){
	$user = $registered_users->fetch_assoc();
	if($user["username"] == $email && $user["password"] == $password){
		echo "Welcome, $email !";
	}
	else{
		echo "Invalid password !";
	}
}
else{
	echo "User is not registered. " .'<br>';
}

$conn->close();


?>