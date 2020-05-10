<?php 
	include(__DIR__ . "/../auth/check-auth.php");
	
	require_once '../model/autorun.php';
	$myModel = Model\Data::makeModel(Model\Data::FILE);
	$myModel->setCurrentUser($_SESSION['user']);

	if ($_POST) {
		if (!$myModel->writeGroup((new \Model\Group())
			->setId($_GET['group'])
			->setNumber($_POST['number'])
			->setStarosta($_POST['starosta'])
			->setDepartment($_POST['department'])
		)) {
			die($myModel->getError());
		} else {
			header('Location: ../index.php?group=' . $_GET['group']);
		}
	}
	if (!$group = $myModel->readGroup($_GET['group']) ) {
		die($myModel->getError());
	}

	require_once '../view/autorun.php';
	$myView = \View\GroupListView::makeView(\View\GroupListView::SIMPLEVIEW);
	$myView->setCurrentUser($myModel->getCurrentUser());

	$myView->showGroupEditForm($group);
?>
