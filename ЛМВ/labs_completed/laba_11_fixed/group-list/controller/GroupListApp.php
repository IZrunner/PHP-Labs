<?php  

namespace Controller;

use Model\Data;
use View\GroupListView;

class GroupListApp {
	private $model;
	private $view;

	public function __construct($modelType, $viewType) {
		session_start();
		$this->model = Data::makeModel($modelType);
		$this->view = GroupListView::makeView($viewType);
	}

	public function checkAuth() {
		if ($_SESSION['user']) {
			$this->model->setCurrentUser($_SESSION['user']);
			$this->view->setCurrentUser($this->model->getCurrentUser());
		} else {
			header('Location: ?action=login');
		}
	}

	public function run() {
		if (!in_array($_GET['action'], array('login','checkLogin'))) {
			$this->checkAuth();
		}
		if ($_GET['action']) {
			switch ($_GET['action']) {
				case 'login':
					$this->showLoginForm();
					break;
				case 'checkLogin':
					$this->checkLogin();
					break;
				case 'logout':
					$this->logout();
					break;
				case 'create-group':
					$this->createGroup();
					break;
				case 'edit-group-form':
					$this->showEditGroupForm();
					break;
				case 'edit-group':
					$this->editGroup();
					break;
				case 'delete-group':
					$this->deleteGroup();
					break;
				case 'create-student-form':
					$this->showCreateStudentForm();
					break;
				case 'create-student':
					$this->createStudent();
					break;
				case 'edit-student-form':
					$this->showEditStudentForm();
					break;
				case 'edit-student':
					$this->editStudent();
					break;
				case 'delete-student':
					$this->deleteStudent();
					break;
				case 'admin':
					$this->adminUsers();
					break;
				case 'edit-user-form':
					$this->showEditUserForm();
					break;
				case 'edit-user':
					$this->editUser();
					break;
				default:
					$this->showMainForm();
			}
		} else {
			$this->showMainForm();
		}
	}
	private function showLoginForm() {
		$this->view->showLoginForm();
	}
	private function checkLogin() {
		if ($user = $this->model->readUser($_POST['username'])) {
			if ($user->checkPassWord($_POST['password'])) {
				session_start();
				$_SESSION['user'] = $user->getUserName();
				header('Location: index.php');
			}
		}
	}
	private function logout() {
		unset($_SESSION['user']);
		header('Location: ?action=login');
	}
	private function showMainForm() {
		$groups = array();
		if ($this->model->checkRight('group', 'view')) {
			$groups = $this->model->readGroups();
		}
		$group = new \Model\Group();
		if ($_GET['group'] && $this->model->checkRight('group', 'view')) {
			$group = $this->model->readGroup($_GET['group']);
		}
		$students = array();
		if ($_GET['group'] && $this->model->checkRight('student', 'view')) {
			$students = $this->model->readStudents($_GET['group']);
		}
		$this->view->showMainForm($groups, $group, $students);
	}
	private function createGroup() {
		if (!$this->model->addGroup()) {
			die($this->model->getError());
		} else {
			header('Location: index.php');
		}
	}
	private function showEditGroupForm() {
		if (!$group = $this->model->readGroup($_GET['group']) ) {
			die($this->model->getError());
		}
		$this->view->showGroupEditForm($group);
	}
	private function editGroup() {
		if (!$this->model->writeGroup((new \Model\Group())
			->setId($_GET['group'])
			->setNumber($_POST['number'])
			->setStarosta($_POST['starosta'])
			->setDepartment($_POST['department'])
	    )) {
			die($this->model->getError());
	    } else {
	    	header('Location: index.php?group=' . $_GET['group']);
	    }
	}
	private function deleteGroup() {
		if (!$this->model->removeGroup($_GET['group'])) {
			die($this->model->getError());
		} else {
			header('Location: index.php');
		}
	}
	private function showEditStudentForm() {
		$student = $this->model->readStudent($_GET['group'], $_GET['file']);
		$this->view->showStudentEditForm($student);
	}
	private function editStudent() {
		$student = (new \Model\Student())
			->setId($_GET['file'])
			->setGroupId($_GET['group'])
			->setName($_POST['stud_name'])
			->setDob(new \DateTime($_POST['stud_dob']))
			->setPrivilege($_POST['stud_privilege'])
			->setFimaleGender();
		if ($_POST['stud_gender'] == 'чол') {
			$student->setMaleGender();
		}
		if (!$this->model->writeStudent($student)) {
			die($this->model->getError());
		} else {
			header('Location: index.php?group=' . $_GET['group']);
		}
	}
	private function showCreateStudentForm() {
		$this->view->showStudentCreateForm();
	}
	private function createStudent() {
		$student = (new \Model\Student())
			->setGroupId($_GET['group'])
			->setName($_POST['stud_name'])
			->setDob(new \DateTime($_POST['stud_dob']))
			->setPrivilege($_POST['stud_privilege'])
			->setFimaleGender();
		if ($_POST['stud_gender'] == 'чол') {
			$student->setMaleGender();
		}
		if (!$this->model->addStudent($student)) {
			die($this->model->getError());
		} else {
			header('Location: index.php?group' . $_GET['group']);
		}
	}
	private function deleteStudent() {
		$student = (new \Model\Student())->setId($_GET['file'])->setGroupId($_GET['group']);
		if (!$this->model->removeStudent($student)) {
			die($this->model->getError());
		} else {
			header('Location: index.php?group=' . $_GET['group']);
		}
	}
	private function adminUsers() {
		$users = $this->model->readUsers();
		$this->view->showAdminForm($users);
	}
	private function showEditUserForm() {
		if(!$user = $this->model->readUser($_GET['username'])) {
			die($this->model->getError());
		}
		$this->view->showUserEditForm($user);
	}
	private function editUser() {
		$rights = "";
		for($i=0; $i<9; $i++) {
			if ($_POST['right' . $i]) {
				$rights .= "1";
			} else {
				$rights .= "0";
			}
		}
		$user = (new \Model\User())
			->setUserName($_POST['user_name'])
			->setPassword($_POST['user_pwd'])
			->setRights($rights);
		if (!$this->model->writeUser($user)) {
			die($this->model->getError());
		} else {
			header('Location: ?action=admin ');
		}
	}
}
?>