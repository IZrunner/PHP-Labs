<?php  
	$dirName = "../data/" . $_GET['group'];
	$conts = scandir($dirName);
	$i = 0;
	foreach ($conts as $node) {
		@unlink($dirName . "/" . $node);
	}
	@rmdir($dirName);
	header('Location: ../index.php');
