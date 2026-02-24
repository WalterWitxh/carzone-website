<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$host = 'localhost';
	$db = 'carzone_db';
	$user = 'root';
	$pass = '';
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4"; 

	try {
		$pdo = new PDO($dsn, $user, $pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo 'Database connection failed: ' . $e->getMessage(); 
		exit();
	}
?>

