<?php

function strip_data( $data_to_be_stripped ){

	$data_to_be_stripped = 	trim($data_to_be_stripped);
	$data_to_be_stripped = 	stripslashes($data_to_be_stripped);
	$data_to_be_stripped = 	htmlspecialchars($data_to_be_stripped);
	$data_to_be_stripped = 	mysql_real_escape_string($data_to_be_stripped);

	return $data_to_be_stripped;
}

?>