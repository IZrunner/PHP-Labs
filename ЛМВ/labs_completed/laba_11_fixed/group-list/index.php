<?php
	require 'controller/autorun.php';
	$controller = new \Controller\GroupListApp(\Model\Data::FILE, \View\GroupListView::SIMPLEVIEW);
	$controller->run();
?>
