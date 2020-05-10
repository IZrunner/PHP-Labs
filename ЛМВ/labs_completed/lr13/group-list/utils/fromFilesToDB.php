<?php  
require_once '../controller/autorun.php';
require_once '../data/config.php';

$db = new \Model\MySQLdb();
$db->connect();
$db->runQuery("delete from students");
$db->runQuery("delete from groups");
$db->runQuery("delete from users");

$fileModel = \Model\Data::makeModel(\Model\Data::FILE);
$fileModel->setCurrentUser('admin');

$users = $fileModel->readUsers();
foreach($users as $user) {
	$db->runQuery("insert into users(username, passwd, rights) values('" . $user->getUserName() . "', '" . $user->getPassword() . "', '" . $user->getRights() . "')");
}

$dbModel = \Model\Data::makeModel(\Model\Data::DB);
$dbModel->setCurrentUser('admin');

$groups = $fileModel->readGroups();
foreach($groups as $group) {
	$sql = "insert into groups(`number`, department, starosta) values('" . $group->getNumber() . "', '" . str_replace("'", "\'", $group->getDepartment()) . "' , '" . $group->getStarosta() . "')";
	$db->runQuery($sql);
	$res = $db->getArrFromQuery("select max(id) id from groups");

	$grp_id = $res[0]['id'];
	$students =$fileModel->readStudents($group->getId());
	foreach($students as $student) {
		$student->setGroupId($grp_id);
		$dbModel->addStudent($student);
	}
}

$db->disconnect();
?>