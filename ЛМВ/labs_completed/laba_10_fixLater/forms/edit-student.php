<?php 
	include(__DIR__ . "/../auth/check-auth.php");
	
	require_once '../model/autorun.php';
	$myModel = Model\Data::makeModel(Model\Data::FILE);
	$myModel->setCurrentUser($_SESSION['user']);

	if ($_POST) {
		$student = (new \Model\Student())
			->setId($_GET['file'])
			->setGroupId($_GET['group'])
			->setName($_POST['stud_name'])
			->setDob(new DateTime($_POST['stud_dob']))
			->setPrivilege($_POST['stud_privilege'])
			->setFimaleGender();
		if ($_POST['stud_gender'] == 'чол') {
			$student->setMaleGender();
		}
		if (!$myModel->writeStudent($student)) {
			die($myModel->getError());
		} else {
			header('Location: ../index.php?group=' . $_GET['group']);
		}
	}	

	$student = $myModel->readStudent($_GET['group'], $_GET['file']);

	require_once '../view/autorun.php';
	$myView = \View\GroupListView::makeView(\View\GroupListView::SIMPLEVIEW);
	$myView->setCurrentUser($myModel->getCurrentUser());
	
	$myView->showStudentEditForm($student);
?>