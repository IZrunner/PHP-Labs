<?php  
	session_start();
	if (!$_SESSION['user']) {
		header('Location: /lr10/auth/login.php');
	}
