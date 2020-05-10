<?php  

namespace View;

abstract class GroupListView {
	const SIMPLEVIEW = 0;
	private $user;

	public function setCurrentUser(\Model\User $user) {
		$this->user  = $user;
	}
	public function checkRight($object, $right) {
		return $this->user->checkRight($object, $right);
	}

	public abstract function showMainForm($groups, \Model\Group $group, $students);
	public abstract function showGroupEditForm(\Model\Group $group);
	public abstract function showStudentEditForm(\Model\Student $student);
	public abstract function showStudentCreateForm();
	public abstract function showLoginForm();
	public abstract function showAdminForm($users);
	public abstract function showUserEditForm(\Model\User $user);

	public static function makeView($type) {
		if ($type == self::SIMPLEVIEW) {
			return new MyView();
		}
		return new MyView();
	}
}
?>