<?php 
	if ($_POST) {
		$f = fopen("../data/group/group.txt", "w");
		$grArr = array($_POST['number'], $_POST['department'], $_POST['starosta'],);
		$grStr = implode(";", grArr);
		fwrite($f, $grStr);
		fclose($f);
		header('Location: ../index.php');
	}
	require('../data/declare-group.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Редагування группи</title>
		
		<link rel="stylesheet" type="text/css" href="/css/edit-group-form-style.css">
	</head>
	<body>
		<a href="/group-list/index.php">На головну</a>
		<form name='edit-group' method='post'>
			<div><label for='number'>Номер группи : </label><input type="text" name="number" value="<?php echo 
			$data['group']['number']; ?>"></div>
			<div><label for='starosta'>Староста : </label><input type="text" name="starosta" value="<?php echo 
			$data['group']['starosta']; ?>"></div>
			<div><label for='department'>Факультет : </label><input type="text" name="department" value="<?php echo 
			$data['group']['department']; ?>"></div>
			<div><input type="submit" name="ok" value="змінити"></div>
		</form>
	</body>
</html>