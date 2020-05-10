<?php
    include(__DIR__ . "/../auth/check-auth.php");
    if (!CheckRight('group', 'create')) {
        die('Ви не маєте права на виконання цієї операції');
    }
    $nameTpl = '/^group-\d\d\z/';
    $path =__DIR__ . "/../data";
    $conts = scandir($path);

    $i=0;
    foreach ($conts as $node) {
        if (preg_match($nameTpl, $node)) {
            $last_group = $node;
        }
    }

    $group_index = (String)(((int)substr($last_group, -1, 2)) + 1);
    if (strlen($group_index) == 1) {
        $group_index = "0" . $group_index;
    }

    $newGroupName = "group-" . $group_index;

    mkdir(__DIR__ . "/../data/" . $newGroupName);
    $f = fopen(__DIR__ . "/../data/" . $newGroupName . "/group.txt", "w");
    fwrite($f, "New; ; ");
    fclose($f);
    header('Location: ../index.php?group=' . $newGroupName);