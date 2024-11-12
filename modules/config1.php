<?php

	//  Development Database connection
	
	$databaseHost = 'localhost';
	$databaseName = 'studentdatabase';
	$databaseUsername = 'root';
	$databasePassword = 'Ud0chukwu@2001';

	// remote/Production Database connection
	
	// $databaseHost = '';
	// $databaseName = '';
	// $databaseUsername = '';
	// $databasePassword = '';
	
	try {
		
		$conn = new PDO('mysql:host=' . $databaseHost . ';dbname=' . $databaseName . '', $databaseUsername, $databasePassword);
	}
	catch (PDOException $e) {
    echo $e->getMessage();
	}
	// echo "Connection is there<br/>";
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

?>