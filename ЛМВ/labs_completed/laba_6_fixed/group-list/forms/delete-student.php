<?php 
	unlink(__DIR__ . '/../data/' . $_GET['group'] . "/" . $_GET['file']);
	header('Location: ../index.php?group=' . $_GET['group']);
