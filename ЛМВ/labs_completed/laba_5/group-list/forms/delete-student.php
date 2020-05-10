<?php 
	unlink(__DIR__ . "/../data/group/" . $_GET['file']);
	header('Location: ../index.php');
?>