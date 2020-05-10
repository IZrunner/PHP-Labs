<?php 
	if ($_POST) {
		//last file of student
		$nameTpl = '/^student-\d\d.txt\z/';
		$path = __DIR__ . "/../data/" . $_GET['group'];
		$conts = scandir($path);
		$i = 0;
		foreach ($conts as $node) {
			if (preg_match($nameTpl, $node)) {
			  $last_file = $node;
		    }
	    }
		//index of last file increase 1
		$file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
		if (strlen($file_index) == 1) {
			$file_index = "0" . $file_index;
		}
		//create name of the new file
		$newFileName = "student-" . $file_index . ".txt";

		//save data in file
		$f = fopen("../data/" . $_GET['group'] . "/" . $newFileName, "w");
		$privilege = 0;
		if ($_POST["stud_privilege"] == 1) {
			$privilege = 1;
		}
		$grArr = array($_POST['stud_name'], $_POST['stud_geneder'], $_POST['stud_dob'], $privilege,);
		$grStr = implode(";", $grArr);
		fwrite($f, $grStr);
		fclose($f);
		header('Location: ../index.php?group=' . $_GET['group']);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Додавання студента</title>
	<link rel="stylesheet" type="text/css" href="../css/edit-student-form-style.css">
</head>
<body>
	<a href="../index.php">На головну</a>
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