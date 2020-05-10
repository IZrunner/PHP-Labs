<?php  
namespace Model;

class FileData extends Data {
	const DATA_PATH = __DIR__ . '/../data/';
	const STUD_FILE_TEMPLATE = '/^student-\d\d.txt\z/';
	const GROUP_FILE_TEMPLATE = '/^group-\d\d\z/';

	protected function getStudents($groupId) {
		$Students = array();
		$conts = scandir(self::DATA_PATH . $groupId);

		foreach ($conts as $node) {
			if (preg_match(self::STUD_FILE_TEMPLATE, $node)) {
				$Students[] = $this->getStudent($groupId, $node);
			}
		}
		return $Students;
	}

	protected function getStudent($groupId, $id) {
		$f = fopen(self::DATA_PATH . $groupId . "/" . $id,"r");

		$rowStr = fgets($f);
		$rowArr = explode(";", $rowStr);

		$Student = (new Student())
			->setId($id)
			->setName($rowArr[0])
			->setDob(new \DateTime($rowArr[2]))
			->setPrivilege($rowArr[3]);

		if ($rowArr[1] == 'чол') {
			$Student->setMaleGender();
		} 
		else {
			$Student->setFimaleGender();
		}

		fclose($f);
		return $Student;
	}

	protected function getGroups() {
		$groups = array();
		$conts = scandir(self::DATA_PATH);

		foreach ($conts as $node) {
			if (preg_match(self::GROUP_FILE_TEMPLATE, $node)) {
				$groups[] = $this->getGroup($node);
			}
		}
		return $groups;
	}

	protected function getGroup($id) {
		$f = fopen(self::DATA_PATH . $id . "/group.txt","r");

		$grStr = fgets($f);
		$grArr = explode(";", $grStr);
		fclose($f);

		$group = (new Group())
			->setId($id)
			->setNumber($grArr[0])
			->setDepartment($grArr[1])
			->setStarosta($grArr[2]);

		return $group;
	}

	protected function getUsers() {
		$users = array();
		$f = fopen(self::DATA_PATH . "users.txt","r");

		while(!feof($f)) {
			$rowStr = fgets($f);
			$rowArr = explode(";", $rowStr);

			if (count($rowArr) == 3) {
				$user = (new User())
					->setUserName($rowArr[0])
					->setPassword($rowArr[1])
					->setRights(substr($rowArr[2],0,9));

				$users[] = $user;
			}
		}

		fclose($f);
		return $users;
	}

	protected function getUser($id) {
		$users = $this->getUsers();

		foreach ($users as $user) {
			if ($user->getUserName() == $id) {
				return $user;
			}
		}
		return false;
	}

	protected function setStudent(Student $student) {
		$f = fopen(self::DATA_PATH . $student->getGroupId() . "/" . $student->getId(), "w");
		$privilege = 0;

		if ($student->isPrivilege()) {
			$privilege = 1;
		}

		$gender = 'жін';
		if ($student->isGenderMale()) {
			$gender = 'чол';
		}

		$grArr = array($student->getName(), $gender, $student->getDob()->format("Y-m-d"), $privilege,);
		$grStr = implode(";", $grArr);

		fwrite($f, $grStr);
		fclose($f);
	}

	protected function delStudent(Student $student) {
		unlink(self::DATA_PATH . $student->getGroupId() . "/" . $student->getId());
	}

	protected function insStudent(Student $student) {
		//last file of student in group
		$path = self::DATA_PATH . $student->getGroupId();
		$conts = scandir($path);
		$i = 0;

		foreach ($conts as $node) {
			if (preg_match(self::STUD_FILE_TEMPLATE, $node)) {
				$last_file = $node;
			}
		}

		//index of the last file and plus 1
		$file_index = (String)(((int)substr($last_file, -6, 2)) + 1);

		if (strlen($file_index) == 1) {
			$file_index = "0" . $file_index;
		}

		//create name of the new file
		$newFileName = "student-" . $file_index . ".txt";

		$student->setId($newFileName);
		$this->setStudent($student);
	}

	protected function setGroup(Group $group) {
		$f = fopen(self::DATA_PATH . $group->getId()  . "/group.txt", "w");

		$grArr = array($group->getNumber(), $group->getDepartment(), $group->getStarosta(),);
		$grStr = implode(";", $grArr);

		fwrite($f, $grStr);
		fclose($f);
	}

	protected function setUser(User $user) {
		$users = $this->getUsers();
		$found = false;

		foreach ($users as $key => $oneUser) {
			if ($user->getUserName() == $oneUser->getUserName()) {
				$found = true;
				break;
			}
		}

		if ($found) {
			$users[$key] = $user;
			$f = fopen(self::DATA_PATH . "users.txt", "w");

			foreach ($users as $oneUser) {
				$grArr = array($oneUser->getUserName(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n",);
				$grStr = implode(";", $grArr);
				fwrite($f, $grStr);
			}
			fclose($f);
		}
	}

	protected function delGroup($groupId) {
		$dirName = self::DATA_PATH . $groupId;
		$conts = scandir($dirName);

		$i = 0;
		foreach ($conts as $node) {
			@unlink($dirName . "/" . $node);
		}

		@rmdir($dirName);
	}
	protected function insGroup() {
		//last folder of the group
		$path = self::DATA_PATH ;
		$conts = scandir($path);

		foreach ($conts as $node) {
			if (preg_match(self::GROUP_FILE_TEMPLATE, $node)) {
				$last_group = $node;
			}
		}

		//index of last folder plus 1
		$group_index = (String)(((int)substr($last_group, -1, 2)) + 1);
		if (strlen($group_index) == 1) {
			$group_index = "0" . $group_index;
		}

		//name of the new folder
		$newGroupName = "group-" . $group_index;

		mkdir($path . $newGroupName);
		$f = fopen($path . $newGroupName . "/group.txt" , "w");
		
		fwrite($f, "New; ; ");
		fclose($f);
	}
}
?>