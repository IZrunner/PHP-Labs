<?php
    require('auth/check-auth.php');
    require('data/declare-groups.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/main-style.css" />
        <link rel="stylesheet" href="css/gender-style.css" />
        <link rel="stylesheet" href="css/group-choose-style.css" />
        <title>Список групи</title>
    </head>
    <body>
        <header>
            <div class="user-info">
                <span>Hello <?php echo $_SESSION['user']; ?> !</span>
                <?php if (CheckRight('user', 'admin')): ?> 
                    <a href="admin/index.php">Адміністрування</a>
                <?php endif; ?>
                <a href="auth/logout.php">Logout</a>
            </div>
            <?php if(CheckRight('group', 'view')): ?>
                <form name="group-form" method="get">
                    <label for="group">Група: </label>
                    <select name="group">
                        <?php
                            foreach ($data['groups'] as $curgroup) {
                                echo "<option " . (($curgroup['file'] == $_GET['group'])?"selected":"") . " value='" . $curgroup['file'] . "'>" .$curgroup['number'] . "</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" value="OK">
                    <?php if(CheckRight('group', 'create')): ?>
                        <a href="forms/create-group.php">Додати групу</a>
                    <?php endif; ?>
                </form>
                <?php if($_GET['group']): ?>
                    <?php 
                        $groupFolder = $_GET['group'];
                        require('data/declare-data.php');
                    ?>
                    <h1>Список групи <span class="group-number"> <?php echo $data['group']['number']; ?> </span></h1>
                    <h3>Староста: <span class="group-starosta"> <?php echo $data['group']['starosta']; ?> </span></h3>
                    <h3>Факультет <span class="group-department"><?php echo $data['group']['department'];?></span></h3>
                    <div class="control">
                        <?php if(CheckRight('group', 'edit')): ?>
                            <a href="forms/edit-group.php?group=<?php echo $_GET['group']; ?>">Редагувати групу</a>
                        <?php endif; ?>
                        <?php if(CheckRight('group', 'delete')): ?>
                            <a href="forms/delete-group.php?group=<?php echo $_GET['group']; ?>">Видалити групу</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </header>
        <?php if(CheckRight('student', 'view')): ?>
            <section>
                <?php if($_GET['group']): ?>
                    <?php if(CheckRight('student', 'create')): ?>
                        <div class="control">
                            <a href="forms/create-student.php?group=<?php echo $_GET['group']; ?>">Додати студента</a>
                        </div>
                    <?php endif; ?>
                    <form name="students-filter" method="post">
                        Фільтрувати за прізвищем <input type="text" name="stud_name_filter" value="<?php echo $_POST['stud_name_filter']; ?>">
                        <input type="submit" value="Фільтрувати">
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Прізвище І.П.</th>
                                <th>Стать</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['students'] as $key => $student): ?>
                                <?php if(!$_POST['stud_name_filter'] || stristr($student['name'], $_POST['stud_name_filter'])): ?>
                                    <?php
                                        $row_class='row';
                                        if ($student['gender'] == 'чол') {
                                        $row_class = 'student-boy';
                                        }
                                        if ($student['gender'] == 'жін') {
                                        $row_class = 'student-girl';
                                        }
                                    ?>
                                    <tr class = '<?php echo $row_class; ?>'>
                                        <td> <?php echo ($key + 1); ?> </td>
                                        <td> <?php echo $student['name']; ?></td>
                                        <td> <?php echo $student['gender']; ?></td>
                                        <td>
                                            <?php 
                                                $date_of_birth = new Datetime($student['dob']);
                                                echo date_format($date_of_birth, 'Y');
                                            ?>
                                        </td>
                                        <td>
                                            <?php if(CheckRight('student', 'edit')): ?>
                                                <a href="forms/edit-student.php?group=<?php echo $_GET['group'];?>&file=<?php echo $student['file']; ?>">Редагувати</a>
                                            <?php endif; ?>
                                            <?php if(CheckRight('student', 'delete')): ?>
                                                <a href="forms/delete-student.php?group=<?php echo $_GET['group'];?>&file=<?php echo $student['file']; ?>">Видалити</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif?>
            </section>
        <?php endif; ?>
    </body>
</html>
