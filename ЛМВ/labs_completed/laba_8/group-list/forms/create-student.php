<?php
    include(__DIR__ . "/../auth/check-auth.php");
    if (!CheckRight('student', 'create')) {
        die('Ви не маєте права на виконання цієї операції');
    }
    if ($_POST) {

        $nameTpl = '/^student-\d\d.txt\z/';
        $path = __DIR__ . "/../data/" . $_GET['group'];
        $conts = scandir($path);
        $i = 0;
        foreach ($conts as $node) {
            if (preg_match($nameTpl, $node)) {
                $last_file = $node;
            }
        }

        $file_index = (String)(((int)substr($last_file, -6, 2))+1);
        if (strlen($file_index)==1) {
            $file_index = "0" . $file_index;
        }

        $newFileName = "student-" . $file_index . ".txt";


        $f = fopen("../data/" . $_GET['group'] . "/" . $newFileName, "w");
        $privilege = 0;
        if ($_POST['stud_privilege'] == 1) {
            $privilege = 0;
        }
        $grArr= array($_POST['stud_name'],$_POST['stud_gender'],$_POST['stud_dob'],$privilege);
        $grStr = implode(";", $grArr);
        fwrite($f,$grStr);
        fclose($f);
        header('Location: ../index.php?group=' . $_GET['group']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Додавання студента</title>
    <link rel="stylesheet" href="../css/edit-student-form-style.css">
</head>
<body>
<a href="../index.php">На головну</a>
    <form name="edit-student" method="post">
        <div>
            <label for="stud_name">Прізвище: </label>
            <input type="text" name="stud_name">
        </div>
        <div>
            <label for="stud_gender">Стать: </label>
            <select name="stud_gender">
                <option disabled>Стать</option>
                <option value="чол">Чоловіча</option>
                <option value="жін">Жіноча</option>
            </select>
        </div>
        <div>
            <label for="stuud_dob">Дата народження:</label>
            <input type="date" name="stud_dob">
        </div>
        <div>
            <input type="checkbox" name="stud_privilege"> пільга
        </div>
        <div>
            <input type="submit" name="ok" value="змінити">
        </div>
    </form>
</body>
</html>