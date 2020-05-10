<?php  

namespace View;

class MyView extends GroupListView {
	private function showGroups($groups) {
		?>
		<form name="group-form" method="get">
			<label for="group">Група</label>
			<select name="group">
				<option value=""></option>
				<?php 
				foreach($groups as $curgroup) {
					echo "<option " . (($curgroup->getId() == $_GET['group'])?"selected":"") . " value='" . $curgroup->getId() . "''>" . $curgroup->getNumber() . "</option>";
				}
				?>
			</select>
			<input type="submit" value="ok">
			<?php if($this->checkRight('group', 'create')): ?>
				<a href="forms/create-group.php">Додати групу</a>
			<?php endif; ?>
		</form>
		<?php  
	}
	private function showGroup(\Model\Group $group) {
		?>
		<h2>Список групи <span class="group-number"><?php echo $group->getNumber(); ?></span></h2>
		<h2>Староста <span class="group-starosta"><?php echo $group->getStarosta(); ?></span></h2>
		<h2>Факультет <span class="group-department"><?php echo $group->getDepartment(); ?></span></h2>
		<div class="control">
			<?php if($this->checkRight('group', 'edit')):?>
				<a href="forms/edit-group.php?group=<?php echo $_GET['group']; ?>">Редагувати групу</a>
			<?php endif; ?>
			<?php if($this->checkRight('group', 'delete')):?>
				<a href="forms/delete-group.php?group=<?php echo $_GET['group']; ?>">Видалити групу</a>
				<?php endif; ?>
		</div>
		<?php
	}
	private function showStudents($students) {
		?>
		<section>
			<?php if($_GET['group']): ?>
				<?php if($this->checkRight('student', 'create')):?>
					<div class="control">
						<a href="forms/create-student.php?group=<?php echo $_GET['group']; ?>">Додати студента</a>
					</div>	
				<?php endif; ?>
				<form name="students-filter" method="post">
					Фільтрувати за прізвищем <input type="text" name="stud_name_filter" value="<?php echo $_POST['stud_name_filter']; ?>">
					<input type="submit" value="фільтрувати">
				</form>
				<table>
					<thead>
					<tr>
						<th>№</th>
						<th>Староста</th>
						<th>Стать</th>
						<th>Рік народження</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php if (count($students) > 0): ?>
					<?php foreach ($students as $key => $student): ?>
						<?php if(!$_POST['stud_name_filter'] || stristr($student->getName(), $_POST['stud_name_filter'])): ?>
							<?php
							$row_class = 'row';
							if ($student->isGenderMale()) {
								$row_class = 'student-boy';
							}
							if ($student->isGenderFimale()) {
								$row_class = 'student-girl';
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
										<a href='forms/edit-student.php?group=<?php echo $_GET['group']; ?>&file=<?php echo $student->getId(); ?>'>Редагувати</a>
									<?php endif; ?>
									|
									<?php if($this->checkRight('student', 'delete')):?>
										<a href="forms/delete-student.php?group=<?php echo $_GET['group']; ?>&file=<?php echo $student->getId(); ?>">Видалити</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		<?php endif; ?>
		</section>
		<?php
	}
	public function showMainForm($groups, \Model\Group $group, $students) {
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Список групи</title>
			<link rel="stylesheet" type="text/css" href="css/main-style.css">
			<link rel="stylesheet" type="text/css" href="css/gender-style.css">
			<link rel="stylesheet" type="text/css" href="css/group-choose-style.css">
		</head>
		<body>
		<header>
			<div class="user-info">
				<span>Hello <?php echo $_SESSION['user']; ?> !</span>
				<?php if($this->checkRight('user','admin')):?>
				<a href="admin/index.php">Адміністрування</a>
				<?php endif; ?>
				<a href="auth/logout.php">Logout</a>
			</div>
			<?php  
			if($this->checkRight('group', 'view')) {
				$this->showGroups($groups);
				if ($_GET['group']) {
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
			<link rel="stylesheet" type="text/css" href="../css/edit-group-form-style.css">
		</head>
		<body>
		<a href="../index.php?group=<?php echo $_GET['group'];?>">На головну</a>
		<form name='edit-group' method="post">
		    <div><label for='number'>Номер групи : </label><input type="text" name="number" value="<?php echo $group->getNumber(); ?>"></div>
		    <div><label for='starosta'>староста : </label><input type="text" name="starosta" value="<?php echo $group->getStarosta(); ?>"></div>
		    <div><label for='department'>Факультет : </label><input type="text" name="department" value="<?php echo $group->getDepartment(); ?>"></div>
		    <div><input type="submit" name="ok" value="змінити"></div>
		</form>
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
			<link rel="stylesheet" type="text/css" href="../css/edit-student-form-style.css">
		</head>
		<body>
		<a href="../index.php?group=<?php echo $_GET['group'];?>">На головну</a>
		<form name="edit-student" method="post">
			<div>
				<label for="stud_name">Прізвище : </label>
				<input type="text" name="stud_name" value="<?php echo $student->getName(); ?>">
			</div>
			<div>
				<label for="stud_gender">Стать : </label>
				<select name="stud_gender">
					<option disabled></option>
					<option <?php echo ($student->isGenderMale())?"selected":""; ?> value="чол">Чоловіча</option>
					<option <?php echo ($student->isGenderFimale())?"selected":""; ?> value="жін">Жіноча</option>
				</select>
			</div>
			<div>
				<label for="stud_dob">Дата народження : </label>
				<input type="date" name="stud_dob" value='<?php echo $student->getDob()->format('Y-m-d'); ?>'>
			</div>
			<div>
				<input type="checkbox" <?php echo ($student->isPrivilege())?"checked":""; ?> name="stud_privilege" value=1> пільга
			</div>
			<div><input type="submit" name="ok" value="змінити"></div>
		</form>
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
			<link rel="stylesheet" type="text/css" href="../css/edit-student-form-style.css">
		</head>
		<body>
			<a href="../index.php?group=<?php echo $_GET['group'];?>">На головну</a>
		<form name="edit-student" method="post">
			<div>
				<label for="stud_name">Прізвище : </label>
				<input type="text" name="stud_name">
			</div>
			<div>
				<label for="stud_geneder">Стать : </label>
				<select name="stud_geneder">
					<option disabled>Стать</option>
					<option value="чол">Чоловіча</option>
					<option value="жін">Жіноча</option>
				</select>
			</div>
			<div>
				<label for="stud_dob">Дата народження : </label>
				<input type="date" name="stud_dob">
			</div>
			<div>
				<input type="checkbox" name="stud_privilege" value=1> пільга
			</div>
			<div><input type="submit" name="ok" value="додати"></div>
		</form>
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
			<link rel="stylesheet" type="text/css" href="../css/login-style.css">
		</head>
		<body>
		<form method="post">
			<p>
				<input align="center" type="text" name="username" placeholder="username">
			</p>
			<p>
				<input type="password" name="password" placeholder="password">
			</p>
			<p>
				<input type="submit" value="login">
			</p>
		</form>
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
		</head>
		<body>
		<header>
			<a href="../index.php">На головну</a>
			<h1>Адміністрування користувачів</h1>
			<link rel="stylesheet" type="text/css" href="../css/main-style.css">
		</header>
		<section>
			<table>
				<thead>
				<tr>
					<th>Користувач</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($users as $user):?>
					<?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != '' ): ?>
						<tr>
							<td><a href="edit-user.php?username=<?php echo $user->getUserName();?>"><?php echo $user->getUserName(); ?></td>
						</tr>
					<?php endif ?>
				<?php endforeach;?>
				</tbody>
			</table>
		</section>
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
			<link rel="stylesheet" type="text/css" href="admin.css">
		</head>
		<body>
		<a href="index.php">До списку користувачів</a>
		<form name='edit-user' method="post">
			<div class="tbl">
				<div>
					<label for="user_name">Username: </label>
					<input readonly type="text" name="user_name" value= "<?php echo $user->getUserName(); ?>">
				</div>
			    <div>
					<label for="user_pwd">Password</label>
					<input type="text" name="user_pwd" value= "<?php echo $user->getPassword(); ?>">
				</div>
			</div>
			<div><p>Група:</p>
				<input type="checkbox" <?php echo ('1' == $user->getRight(0))?"checked":""; ?> name='right0' value='1'><span>перегляд</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(1))?"checked":""; ?> name='right1' value='1'><span>створення</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(2))?"checked":""; ?> name='right2' value='1'><span>редагування</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(3))?"checked":""; ?> name='right3' value='1'><span>видалення</span>
			</div>
			<div><p>Студент:</p>
				<input type="checkbox" <?php echo ('1' == $user->getRight(4))?"checked":""; ?> name='right4' value='1'><span>перегляд</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(5))?"checked":""; ?> name='right5' value='1'><span>створення</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(6))?"checked":""; ?> name='right6' value='1'><span>редагування</span>
				<input type="checkbox" <?php echo ('1' == $user->getRight(7))?"checked":""; ?> name='right7' value='1'><span>видалення</span>
			</div>
			<div><p>Користувачі:</p>
				<input type="checkbox" <?php echo ('1' == $user->getRight(8))?"checked":""; ?> name='right8' value='1'><span>адміністрування</span>
			</div>
			<div><input type="submit" name="ok" value="змінити"></div>
		</form>
		</body>
		</html>
		<?php
	}
}
