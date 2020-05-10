<?php 
namespace Model;

class DBData extends Data {
	private $db;

	public function __construct(MySQLdb $db) {
		$this->db = $db;
		$this->db->connect();
	}

	protected function getStudents($groupId) {
		$Students = array();
		if($stud_arr = $this->db->getArrFromQuery("select id, name, dob, gr_id, privilege, gender from students where gr_id=" . $groupId)) {
			foreach($stud_arr as $stud_row) {
				$Student = (new Student())
					->setId($stud_row['id'])
					->setName($stud_row['name'])
					->setDob(new \DateTime($stud_row['dob']))
					->setGroupId($stud_row['gr_id'])
					->setPrivilege($stud_row['privilege']);

				if($stud_row['gender'] == 'чол') {
					$Student->setMaleGender();
				}
				else {
					$Student->setFimaleGender();
				}
				$Students[] = $Student;
			}
		}
		return $Students;
	}

	protected function getStudent($groupId, $id) {
		$Student = new Student();
		if($stud_arr = $this->db->getArrFromQuery("select id, name, dob, gr_id, privilege, gender from students where id=" . $id)) {
			if(count($stud_arr) > 0) {
				$stud_row = $stud_arr[0];
				$Student
					->setId($stud_row['id'])
					->setName($stud_row['name'])
					->setDob(new \DateTime($stud_row['dob']))
					->setGroupId($stud_row['gr_id'])
					->setPrivilege($stud_row['privilege']);

				if($stud_row['gender'] == 'чол') {
					$Student->setMaleGender();
				}
				else {
					$Student->setFimaleGender();
				}
			}
		}
		return $Student;
	}

	protected function getGroups() {
		$groups = array();
		if($grp_arr = $this->db->getArrFromQuery("select id, number, starosta, department from groups")) {
			foreach($grp_arr as $grp_row) {
				$group = (new Group())
					->setId($grp_row['id'])
					->setNumber($grp_row['number'])
					->setDepartment($grp_row['department'])
					->setStarosta($grp_row['starosta']);

				$groups[] = $group;
			}
		}
		return $groups;
	}

	protected function getGroup($id) {
		$group = new Group();
		if($grp_arr = $this->db->getArrFromQuery("select id, number, starosta, department from groups where id=" . $id)) {
			if(count($grp_arr) > 0) {
				$grp_row = $grp_arr[0];
				$group
					->setId($grp_row['id'])
					->setNumber($grp_row['number'])
					->setDepartment($grp_row['department'])
					->setStarosta($grp_row['starosta']);
			}
		}
		return $group;
	}

	protected function getUsers() {
		$users = array();
		if($usr_arr = $this->db->getArrFromQuery("select id, username, passwd, rights from users")) {
			foreach($usr_arr as $usr_row) {
				$user = (new User()) 
					->setUserName($usr_row['username'])
					->setPassword($usr_row['passwd'])
					->setRights($usr_row['rights']);

				$users[] = $user;
			}
		}
		return $users;
	}

	protected function getUser($id) {
		$user = new User();
		if($usr_arr = $this->db->getArrFromQuery("select id, username, passwd, rights from users where username='" . $id . "'")) {
			if(count($usr_arr) > 0) {
				$usr_row = $usr_arr[0];
				$user
					->setUserName($usr_row['username'])
					->setPassword($usr_row['passwd'])
					->setRights($usr_row['rights']);
			}
		}
		return $user;
	}

	protected function setStudent(Student $student) {
		$privilege = 0;
		if($student->isPrivilege()) {
			$privilege = 1;
		}
		$gender = "жін";

		if($student->isGenderMale()) {
			$gender = "чол";
		}

		$sql = "update students set name = '" . $student->getName() . "', dob = '" . $student->getDob()->format('Y-m-d') . "', gr_id = " . $student->getGroupId() . ", privilege = " . $privilege . ", gender = '" . $gender . "' where id = " . $student->getId();
		$this->db->runQuery($sql);
	}

	protected function delStudent(Student $student) {
		$sql = "delete from students where id = " . $student->getId();
		$this->db->runQuery($sql);
	}

	protected function insStudent(Student $student) {
		$privilege = 0;
		if($student->isPrivilege()) {
			$privilege = 1;
		}
		$gender = "жін";

		if($student->isGenderMale()) {
			$gender = "чол";
		}

		$sql = "insert into students(name, dob, gr_id, privilege, gender) values('" . $student->getName() . "', '" . $student->getDob()->format('Y-m-d') . "', " . $student->getGroupId() . ", " . $privilege . ", '" . $gender . "')";
		// echo $sql . "<br>";
		$this->db->runQuery($sql);
	}

	protected function setGroup(Group $group) {
		$sql = "update groups set number='" . $group->getNumber() . "', starosta='" . $group->getStarosta() . "', department='" . str_replace("'", "\'", $group->getDepartment()) . "' where id=" . $group->getId();
		$this->db->runQuery($sql);
	}

	protected function setUser(User $user) {
		$sql = "update users set rights='" . $user->getRights() . "', passwd='" . $user->getPassword() . "' where username='" . $user->getUserName() . "'";
		$this->db->runQuery($sql);
	}

	protected function delGroup($groupId) {
		$sql = "delete from groups where id = " . $groupId;
		$this->db->runQuery($sql);
	}

	protected function insGroup() {
		$sql = "insert into groups(number, department, starosta) values ('new', '', '')";
		$this->db->runQuery($sql);
	}
}
?>