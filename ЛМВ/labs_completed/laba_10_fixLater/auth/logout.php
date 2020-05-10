<?php  
	session_start();
	unset($_SESSION['user']);
	header('Location: /lr10/auth/login.php');
?>