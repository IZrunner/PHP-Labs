<?php
    include(__DIR__ . "/../auth/check-auth.php");
    if (!CheckRight('group', 'edit')) {
        die('Ви не маєте права на виконання цієї операції');
    }
    if ($_POST) {
        $f = fopen("../data/" . $_GET['group'] . "/group.txt", "w");
        $grArr = array($_POST['number'],$_POST['starosta'],$_POST['department']);
        $grStr = implode(";", $grArr);
        fwrite($f, $grStr);
        fclose($f);
        header('Location: ../index.php?group=' . $_GET['group']);
    }
    $groupFolder = $_GET['group'];
    require('../data/declare-group.php');
?>
<!DOCTYPE html>
<html >
<head>
<link rel="stylesheet" href="../css/edit-group-form-style.css">
    <title>Document</title>
</head>
<body>
    <a href="../index.php?group=<?php echo $_GET['group']?>">На головну</a>    
    <form name='edit-group' method='post'>
        <div>
            <label for="number">Номер групи : </label>
            <input type="text" name="number" value="<?php echo $data['group']['number']; ?>">
        </div>
        <div>
            <label for="starosta">Староста : </label>
            <input type="text" name="starosta" value="<?php echo $data['group']['starosta']; ?>">
        </div>
        <div>
            <label for="department">Факультет : </label>
            <input type="text" name="department" value="<?php echo $data['group']['department']; ?>">
        </div>
        <div>
            <input type="submit" name="OK" value="змінити">
        </div>
    </form>
</body>
</html>