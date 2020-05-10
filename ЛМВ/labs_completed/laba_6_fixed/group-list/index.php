<?php
	require('data/declare-groups.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/main-style.css">
	<link rel="stylesheet" type="text/css" href="css/gender-style.css">
	<link rel="stylesheet" type="text/css" href="css/group-choose-style.css">
</head>

<body>
	<header>
		<form name="group-form" method="get">
		<label for="group">Група</label>
		<select name="group">
			<option value=""></option>
			<?php
			foreach ($data['groups'] as $curgroup) {
				echo "<option " . (($curgroup['file'] == $_GET['group'])?"selected":"") . "value='" . $curgroup['file'] . "''>" . $curgroup['number'] . "</option>";
			}
			?>
		</select>
		<input type="submit" value="ok">
		<a href="forms/create-group.php">Додати групу</a>	
		</form>
		<?php if($_GET['group']): ?>
			<?php
				$groupFolder = $_GET['group'];
				require('data/declare-data.php');
			?>
		<h2>Список групи <span class="group-number"><?php echo $data['group']['number']; ?></span></h2>
		<h2>Староста <span class="group-starosta"><?php echo $data['group']['starosta']; ?></span></h2>
		<h2>Факультет <span class="group-department"><?php echo $data['group']['department']; ?></span></h2>
		<div class="control">
		<a href="forms/edit-group.php?group=<?php echo $_GET['group']; ?>">Редагувати групу</a>
		<a href="forms/delete-group.php?group=<?php echo $_GET['group']; ?>">Видалити групу</a>
		</div>
	<?php endif; ?>
	</header>
	<br/>
	<section>
		<?php if($_GET['group']): ?>
		<div class="control">
		<a href="forms/create-student.php?group=<?php echo $_GET['group']; ?>">Додати студента</a>
		</div>	
		<form name="students-filter" method="post">Фільтрувати за прізвищем <input type="text" name="stud_name_filter" value="<?php echo $_POST['stud_name_filter']; ?>">
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
				<?php foreach ($data['students'] as $key => $student): ?>
					<?php if(!$_POST['stud_name_filter'] || stristr($student['name'], $_POST['stud_name_filter'])): ?>
						<?php
							$row_class = 'row';
							if ($student['gender'] == 'чол'){
								$row_class = 'student-boy';
							}
							if ($student['gender'] == 'жін'){
								$row_class = 'student-girl';
							}
						?>
						<tr class='<?php echo $row_class; ?>'>
							<td><?php echo ($key + 1); ?></td>
							<td><?php echo $student['name']; ?></td>
							<td><?php echo $student['gender']; ?></td>
							<td>
								<?php 
									$date_of_birth = new Datetime($student['dob']);
									echo date_format($date_of_birth, 'Y');
								?>
							</td>
							<td>
								<a href='forms/edit-student.php?group=<?php echo $_GET['group']; ?>&file=<?php 
								echo $student['file']; 
								?>'>Редагувати |</a>

								<a href="forms/delete-student.php?group=<?php echo $_GET['group']; ?>&file=<?php echo $student['file']; ?>">Видалити</a>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	</section>
</body>
</html>