<?php
	require('auth/check-auth.php');
	
	require_once 'model/autorun.php';
	$myModel = Model\Data::makeModel(Model\Data::FILE);
	$myModel->setCurrentUser($_SESSION['user']);

	require_once 'view/autorun.php';
	$myView = \View\GroupListView::makeView(\View\GroupListView::SIMPLEVIEW);
	$myView->setCurrentUser($myModel->getCurrentUser());

	$groups = array();
	if($myModel->checkRight('group', 'view')) {
		$groups = $myModel->readGroups();
	}
	$group = new \Model\Group();
	if($_GET['group'] && $myModel->checkRight('group', 'view')) {
		$group = $myModel->readGroup($_GET['group']);
	}
	$students = array();
	if ($_GET['group'] && $myModel->checkRight('student', 'view')) {
		$students = $myModel->readStudents($_GET['group']);
	}

	$myView->showMainForm($groups, $group, $students);
?>
