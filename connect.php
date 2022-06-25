<?php 
	$host = 'localhost';
	$database = 'медиатека';
	$username = 'root';
	$password = '';
	$conn = mysqli_connect($host,$username,$password,$database);
	if(!$conn) die("Ошибка соединения с базой данных". mysqli_connect_error());
?>