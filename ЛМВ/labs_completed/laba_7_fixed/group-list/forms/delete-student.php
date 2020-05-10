<?php
    include(__DIR__ . "/../auth/check-auth.php");
    if (!CheckRight('student', 'delete')) {
        die('Ви не маєте права на виконання цієї операції');
    }
    unlink(__DIR__ . "/../data/". $_GET['group'] . "/" . $_GET['file']);
    header('Location: ../index.php?group=' . $_GET['group']);