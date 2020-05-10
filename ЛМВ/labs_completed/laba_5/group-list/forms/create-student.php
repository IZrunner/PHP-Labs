<?php 
	if($_POST){
		//define last student's file in group
		$nameTpl = '/^student-\d\d.txt\z/';
		$path = __DIR__ . "/../data/group";
		$conts = scandir($path);
		$i = 0;
		foreach ($conts as $node) {
			if (preg_match($nameTpl, $node)) {
				$last_file = $node;
			}
		}
		//get last file's index and increase it by 1
		$file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
		if (strlen($file_index) == 1) {
			$file_index = "0" . $file_index;
		}
		//create new file's name
		$newFileName = "student-" . $file_index . ".txt";

		//save data to file
		$f = fopen("../data/group/" . $newFileName, "w");
		$privilege = 0;
		if ($_POST['stud_privilege'] == 1) {
			$privilege = 1;
		}
		$grArr = array($_POST['stud_name'], $_POST['stud_gender'], $_POST['stud_dob'], $privilege,);
		$grArr = implode(";", $grArr);
		fwrite($f, $grArr);
		fclose($f);
		header('Location: ../index.php');
	}
?>
<!doctype html>
<html>
    <head>
        <title>Додавання студента</title>
        <link rel="stylesheet" type="text/css" href="../css/edit-student-form-style.css">       
    </head>
    <body>
		<a href="../index.php">На головну</a>
		<form name='edit-student' method="post">
			<div>
				<label for='stud_name'>Прізвище : </label>
				<input type="text" name="stud_name">
			</div>
			<div>
				<label for='stud_gender'>Стать :  </label>
				<select name="stud_gender">
					<option disabled>Стать</option>
					<option value="чол">Чоловіча</option>
					<option value="жін">жіноча</option>
				</select>
			</div>
			<div>
				<label for='stud_dob'>Дата народження : </label>
				<input type="date" name="stud_dob">
			</div>
			<div>
				<input type="checkbox" name="stud_privilege" value=1>пільга
			</div>
			<div><input type="submit" name="ok" value="додати"></div>
		</form>
    </body>
</html>