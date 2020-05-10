<?php 
	include(__DIR__ . "/../auth/check-auth.php");
	
	require_once '../model/autorun.php';
	$myModel = Model\Data::makeModel(Model\Data::FILE);
	$myModel->setCurrentUser($_SESSION['user']);

	$student = (new \Model\Student())->setId($_GET['file'])->setGroupId($_GET['group']);
	if (!$myModel->removeStudent($student)) {
		die($myModel->getError());
	} else {
		header('Location: ../index.php?group=' . $_GET['group']);
	}
	
