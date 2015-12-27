<?php

$server = "localhost";
$username = "root";
$password = "root";
$db = "my_db";

$conn = new mysqli($server, $username, $password, $db);

if($conn->connect_error){
	die("Connection failed.\n");
}
else{
	echo "Connected successfuly to mysql." . '<br>';
}

$sql = "SELECT username, password FROM registered_users";
$registered_users = $conn->query($sql);

if($registered_users->num_rows > 0 ){
	echo "exists a user " . '<br>';
	var_dump($registered_users);
	/*
	while($user = $registered_users->fetch_assoc()){
		echo "username: " $user["username"] . ", password: " . $user["password"] . '<br>';
	}
	*/
}
else{
	echo "no users found." .'<br>';
}

$email = $_POST[email];
$password = $_POST[password];

$conn->close();

echo $email . '<br>' . $password . '<br>';
echo "Sign In";


?>