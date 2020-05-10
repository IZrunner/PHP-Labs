<?php 
	include(__DIR__ . "/../auth/check-auth.php");

	if ($_POST) {
		require_once '../model/autorun.php';
		$myModel = Model\Data::makeModel(Model\Data::FILE);
		$myModel->setCurrentUser($_SESSION['user']);

		$student = (new \Model\Student())
			->setGroupId($_GET['group'])
			->setName($_POST['stud_name'])
			->setDob(new DateTime($_POST['stud_dob']))
			->setPrivilege($_POST['stud_privilege'])
			->setFimaleGender();
		if ($_POST['stud_geneder'] == 'чол') {
			$student->setMaleGender();
		}
		if (!$myModel->addStudent($student)) {
			die($myModel->getError());
		} else {
			header('Location: ../index.php?group=' . $_GET['group']);
		}
	}

	require_once '../view/autorun.php';
	$myView = \View\GroupListView::makeView(\View\GroupListView::SIMPLEVIEW);
	
	$myView->showStudentCreateForm();
	
?>
