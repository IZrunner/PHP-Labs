<?php  
	if ($_POST) {
		require_once '../model/autorun.php';
		$myModel = Model\Data::makeModel(Model\Data::FILE);
		if ($user = $myModel->readUser($_POST['username'])) {
			if ($user->checkPassWord($_POST['password'])) {
				session_start();
				$_SESSION['user'] = $user->getUserName();
				header('Location: ../index.php');
			}
		}
	}

	require_once '../view/autorun.php';
	$myView = \View\GroupListView::makeView(\View\GroupListView::SIMPLEVIEW);

	$myView->showLoginForm();
?>
