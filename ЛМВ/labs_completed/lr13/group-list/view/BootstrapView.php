<?php  

namespace View;

class BootstrapView extends GroupListView {
	const ASSETS_FOLDER = 'view/bootstrap-view/';
	private function showUserInfo() {
		?>
		<div class="container user-info">
			<div class="row">
				<div class="col-md-6 col-md-offset-6 text-center lead">
					<span>Hello <?php echo $_SESSION['user']; ?> !</span>
					<?php if($this->checkRight('user','admin')):?>
						<a class="btn btn-primary" href="?action=admin">Адміністрування</a>
					<?php endif; ?>
					<a class="btn btn-info" href="?action=logout">Вихід</a>
				</div>
			</div>	
		</div>	
		<?php 
	}
	private function showGroups($groups) {
		?>
		<div class="container group-list">
			<div class="row">
				<form name="group-form" method="get" class="col-xs-offset-2 col-xs-8 col-sm-offset-3 col-sm-6">
					<div class="form-group">
						<label for="group">Група</label>
						<select name="group" class="form-control" onchange="document.forms['group-form'].submit();">
							<option value=""></option>
							<?php
							foreach ($groups as $curgroup) {
								echo "<option " . (($curgroup->getId() == $_GET['group'])?"selected":"") . " value='" . $curgroup->getId() . "''>" . $curgroup->getNumber() . "</option>";
							}
							?>
						</select>
					</div>
				</form>
				<?php if($this->checkRight('group', 'create')):?>
					<div>
						<a class="btn btn-success" href="?action=create-group">Додати групу</a>	
					</div>
				<?php endif; ?>
			</div>	
		</div>
		<?php 

	}

	private function showGroup(\Model\Group $group) {
		?>
		<div class="container group-info">
			<div class="row text-center">
				<h2 class="col-xs-12">Список групи <span class="text-primary"><?php echo $group->getNumber(); ?></span></h2>
				<h2 class="col-xs-12">Факультет <span class="text-danger"><?php echo $group->getDepartment(); ?></span></h2>
				<h2 class="col-xs-12">Староста <span class="text-success"><?php echo $group->getStarosta(); ?></span></h2>

				<div class="control col-xs-12">
					<?php if($this->checkRight('group', 'edit')):?>
						<a class="btn btn-primary" href="?action=edit-group-form&group=<?php echo $_GET['group']; ?>">Редагувати групу</a>
					<?php endif; ?>
					<?php if($this->checkRight('group', 'delete')):?>
						<a class="btn btn-danger" href="?action=delete-group&group=<?php echo $_GET['group']; ?>">Видалити групу</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function showStudents($students) {
		?>
		<section class="container students">
			<div class="row text-center">
				<?php if($_GET['group']): ?>
					<?php if($this->checkRight('student', 'create')):?>
						<div class="col-xs-12 col-md-2 col-md-offset-1 text-left add-stud">
							<a class="btn btn-success" href="?action=create-student-form&group=<?php echo $_GET['group']; ?>">Додати студента</a>
						</div>	
					<?php endif; ?>
					<div class="col-xs-12 col-md-8">
						<form name="students-filter" method="post">
							<div class="col-xs-5">
								<label for="stud_name_filter"> Фільтрувати за прізвищем </label>
							</div>	
							<div class="col-xs-4">
								<input class="form-control" type="text" name="stud_name_filter" value="<?php echo $_POST['stud_name_filter']; ?>">
							</div>
							<div class="col-xs-3">
								<input type="submit" value="фільтрувати" class="btn btn-info">
							</div>
						</form>
					</div>
				</div>
				<div class="row text-center table-students">
					<table class="table col-xs-12">
						<thead>
							<tr>
								<th>№</th>
								<th>Староста</th>
								<th>Стать</th>
								<th>Рік народження</th>
								<th>Інструменти</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($students) > 0): ?>
								<?php foreach ($students as $key => $student): ?>
									<?php if(!$_POST['stud_name_filter'] || stristr($student->getName(), $_POST['stud_name_filter'])): ?>
										<?php
										$row_class = 'row';
										if ($student->isGenderMale()) {
											$row_class = 'bg-info';
										}
										if ($student->isGenderFimale()) {
											$row_class = 'bg-danger';
										}
										?>
										<tr class='<?php echo $row_class; ?>'>
											<td><?php echo ($key + 1); ?></td>
											<td><?php echo $student->getName(); ?></td>
											<td><?php echo $student->isGenderMale()?'чол':'жін'; ?></td>
											<td>
												<?php 
												echo date_format($student->getDob(), 'Y');
												?>
											</td>
											<td>
												<?php if($this->checkRight('student', 'edit')):?>
													<a class="btn btn-primary btn-xs" href='?action=edit-student-form&group=<?php echo $_GET['group']; ?>&file=<?php echo $student->getId(); ?>'>Редагувати</a>
												<?php endif; ?>
												<?php if($this->checkRight('student', 'delete')):?>
													<a class="btn btn-danger btn-xs" href='?action=delete-student&group=<?php echo $_GET['group']; ?>&file=<?php echo $student->getId(); ?>'>Видалити</a>
												<?php endif; ?>
											</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</section>
		<?php 
	}

	public function showMainForm ($groups, \Model\Group $group, $students) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<title>Список группы</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<header>
				<?php 
				$this->showUserInfo();
				if($this->checkRight('group', 'view')) {
					$this->showGroups($groups);
					if($_GET['group']) {
						$this->showGroup($group);
					}
				}
				?>
			</header>
			<?php  
			if($this->checkRight('student', 'view')) {
				$this->showStudents($students);
			}
			?>
		</body>
		</html>
		<?php 
	}

	public function showGroupEditForm(\Model\Group $group) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Редагування групи</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main-style.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
						<form name='edit-group' method="post" action="?action=edit-group&group=<?php echo $_GET['group'];?>">
							<div class="form-group"><label for='number'>Номер групи : </label><input class="form-control" type="text" name="number" value="<?php echo $group->getNumber(); ?>"></div>
							<div class="form-group"><label for='starosta'>Cтароста : </label><input class="form-control" type="text" name="starosta" value="<?php echo $group->getStarosta(); ?>"></div>
							<div class="form-group"><label for='department'>Факультет : </label><input class="form-control" type="text" name="department" value="<?php echo $group->getDepartment(); ?>"></div>
							<button type="submit" class="btn btn-success pull-right">змінити</button>
							<a class="btn btn-info btn-sm pull-left" href="index.php?group=<?php echo $_GET['group'];?>" class="admin-link">На головну</a>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>
		<?php 
	}

	public function showStudentEditForm(\Model\Student $student) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Редагування студента</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">

						<form name="edit-student" method="post" action="?action=edit-student&file=<?php echo $_GET['file'];?>&group=<?php echo $_GET['group'];?>">
							<div class="form-group">
								<label for="stud_name">Прізвище : </label>
								<input class="form-control" type="text" name="stud_name" value="<?php echo $student->getName(); ?>">
							</div>
							<div class="form-group">
								<label for="stud_gender">Стать : </label>
								<select class="form-control" name="stud_gender">
									<option disabled>Стать</option>
									<option <?php echo ($student->isGenderMale())?"selected":""; ?> value="чол">Чоловіча</option>
									<option <?php echo ($student->isGenderFimale())?"selected":""; ?> value="жін">Жіноча</option>
								</select>
							</div>
							<div class="form-group">
								<label for="stud_dob">Дата народження : </label>
								<input class="form-control" type="date" name="stud_dob" value='<?php echo $student->getDob()->format('Y-m-d'); ?>'>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" <?php echo ($student->isPrivilege())?"checked":""; ?> name="stud_privilege" value="1"> пільга
								</label>
							</div>
							<button type="submit" class="btn btn-success pull-right">змінити</button>
							<a class="btn btn-info pull-left btn-sm" href="index.php?group=<?php echo $_GET['group'];?>" class="admin-link">На головну</a>
						</form>
					</div>
				</div>
			</div>	
		</body>
		</html>
		<?php 
	}

	public function showStudentCreateForm() {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<title>Додавання студента</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
						<form name="edit-student" method="post" action="?action=create-student&group=<?php echo $_GET['group'];?>">
							<div class="form-group">
								<label for="stud_name">Прізвище : </label>
								<input class="form-control" type="text" name="stud_name">
							</div>
							<div class="form-group">
								<label for="stud_geneder">Стать : </label>
								<select class="form-control" name="stud_geneder">
									<option disabled>Стать</option>
									<option value="чол">Чоловіча</option>
									<option value="жін">Жіноча</option>
								</select>
							</div>
							<div class="form-group">
								<label for="stud_dob">Дата народження : </label>
								<input class="form-control" type="date" name="stud_dob">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="stud_privilege" value=1> пільга
								</label>
							</div>
							<button class="btn btn-success pull-right" type="submit">додати</button>
							<a class="btn btn-info pull-left btn-sm" href="index.php?group=<?php echo $_GET['group'];?>" class="admin-link">На головну</a>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>
		<?php 
	}

	public function showLoginForm() {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Аутентифікація</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<form method="post" action="?action=checkLogin">
				<div class="container">
					<div class="row text-center">
						<div class="col-md-4 col-sm-6 col-lg-3 col-sm-offset-3 col-md-offset-4">
							<div class="form-group">
								<input class="form-control" name="username" placeholder="username">
							</div>
							<div class="form-group">
								<input class="form-control" type="password" name="password" placeholder="password">
							</div>
							<button type="submit" value="login" class="btn btn-default">Login</button>
						</div>
					</div>
				</div>
			</form>
		</body>
		</html>
		<?php
	}

	public function showUserEditForm(\Model\User $user) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Редагування користувача</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>

			
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">

						<form name='edit-user' method="post" action="?action=edit-user&user=<?php echo $_GET['user']; ?>">
							<div class="form-group">
								<label for="user_name">Username: </label>
								<input class="form-control" readonly type="text" name="user_name" value= "<?php echo $user->getUserName(); ?>">
							</div>
							<div class="form-group">
								<label for="user_pwd">Password: </label>
								<input class="form-control" type="text" name="user_pwd" value= "<?php echo $user->getPassword(); ?>">
							</div>
							<div><p>Група:</p>
								<input type="checkbox" <?php echo ('1' == $user->getRight(0))?"checked":""; ?> name='right0' value='1'><span> перегляд</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(1))?"checked":""; ?> name='right1' value='1'><span> створення</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(2))?"checked":""; ?> name='right2' value='1'><span> редагування</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(3))?"checked":""; ?> name='right3' value='1'><span> видалення</span>
							</div>
							<div><p>Студент:</p>
								<input type="checkbox" <?php echo ('1' == $user->getRight(4))?"checked":""; ?> name='right4' value='1'><span> перегляд</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(5))?"checked":""; ?> name='right5' value='1'><span> створення</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(6))?"checked":""; ?> name='right6' value='1'><span> редагування</span>
								<input type="checkbox" <?php echo ('1' == $user->getRight(7))?"checked":""; ?> name='right7' value='1'><span> видалення</span>
							</div>
							<div><p>Користувачі:</p>
								<input type="checkbox" <?php echo ('1' == $user->getRight(8))?"checked":""; ?> name='right8' value='1'><span> адміністрування</span>
							</div>
							<div><input type="submit" name="ok" value="змінити"><a style="float: right;" class="btn btn-info" href="?action=admin" class="admin-link">До списку користувачів</a></div>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>
		<?php
	}

	public function showAdminForm($users) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Адміністрування</title>
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
			<script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
		</head>
		<body>
			<a class="btn btn-info" href="index.php" class="admin-link">На головну</a>
			<h3 class="mt">Адміністрування користувачів</h3>

			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<table>
							<thead>
								<tr class="bg-warning">
									<th style="padding: 6px 20px;" class="btn-warning text-center">Користувач</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($users as $user): ?>
									<?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != '' ): ?>
									<tr>
										<td style="padding: 6px 20px;" class="btn-info text-center"><a href="?action=edit-user-form&username=<?php echo $user->getUserName();?>"><?php echo $user->getUserName(); ?></a></td>
									</tr>
								<?php endif ?>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
	</html>
	<?php
}

}
?>