<?php  
namespace Model;

abstract class Data {
	const FILE = 0;

	private $error;
	private $user;

	public function setCurrentUser($userName) {
		$this->user  = $this->readUser($userName);
	}

	public function getCurrentUser() {
		return $this->user;
	}
	
	public function checkRight($object, $right) {
		return $this->user->checkRight($object, $right);
	}

	public function readStudents($groupId) {
		if ($this->user->checkRight('student', 'view')) {
			$this->error = "";
			return $this->getStudents($groupId);
		} else {
			$this->error = "You have no permissions to view students";
			return false;
		}
	}
	protected abstract function getStudents($groupId);

	public function readStudent($groupId, $id) {
		if ($this->checkRight('student', 'view')) {
			$this->error = "";
			return $this->getStudent($groupId, $id);
		} else {
			$this->error = "You have no permissions to view student";
			return false;
		}
	}
	protected abstract function getStudent($groupId, $id);

	public function readGroups() {
		if ($this->checkRight('group', 'view')) {
			$this->error = "";
			return $this->getGroups();
		} else {
			$this->error = "You have no permissions to view groups";
			return false;
		}
	}
	protected abstract function getGroups();

	public function readGroup($id) {
		if ($this->checkRight('group', 'view')) {
			$this->error = "";
			return $this->getGroup($id);
		} else {
			$this->error = "You have no permissions to view group";
			return false;
		}
	}
	protected abstract function getGroup($id);

	public function readUsers() {
		if ($this->checkRight('user', 'admin')) {
			$this->error = "";
			return $this->getUsers();
		} else {
			$this->error = "You have no permissions to administrate users";
			return false;
		}
	}
	protected abstract function getUsers();

	public function readUser($id) {
		$this->error = "";
		return $this->getUser($id);
	}
	protected abstract function getUser($id);

	public function writeStudent(Student $student) {
		if ($this->checkRight('student', 'edit')) {
			$this->error = "";
			$this->setStudent($student);
			return true;
		} else {
			$this->error = "You have no permissions to edit students";
			return false;
		}
	}
	protected abstract function setStudent(Student $student);

	public function writeGroup(Group $group) {
		if ($this->checkRight('group', 'edit')) {
			$this->error = "";
			$this->setGroup($group);
			return true;
		} else {
			$this->error = "You have no permissions to edit groups";
			return false;
		}
	}
	protected abstract function setGroup(Group $group);

	public function writeUser(User $user) {
		if ($this->checkRight('user', 'admin')) {
			$this->error = "";
			$this->setUser($user);
			return true;
		} else {
			$this->error = "You have no permissions to administrate users";
			return false;
		}
	}
	protected abstract function setUser(User $user);

	public function removeStudent(Student $student) {
		if ($this->checkRight('student', 'delete')) {
			$this->error = "";
			$this->delStudent($student);
			return true;
		} else {
			$this->error = "You have no permissions to delete students";
			return false;
		}
	}
	protected abstract function delStudent(Student $student);

	public function addStudent(Student $student) {
		if ($this->checkRight('student', 'create')) {
			$this->error = "";
			$this->insStudent($student);
			return true;
		} else {
			$this->error = "You have no permissions to create students";
			return false;
		}
	}
	protected abstract function insStudent(Student $student);

	public function removeGroup($groupId) {
		if ($this->checkRight('group', 'delete')) {
			$this->error = "";
			$this->delGroup($groupId);
			return true;
		} else {
			$this->error = "You have no permissions to delete groups";
			return false;
		}
	}
	protected abstract function delGroup($groupId);

	public function addGroup() {
		if ($this->checkRight('group', 'create')) {
			$this->error = "";
			$this->insGroup();
			return true;
		} else {
			$this->error = "You have no permissions to create groups";
			return false;
		}
	}
	protected abstract function insGroup();

	public function getError() {
		if ($this->error) {
			return $this->error;
		} 
		return false;
	}

	public static function makeModel($type) {
		if ($type == self::FILE) {
			return new FileData();
		}
		return new FileData();
	}
}
?>