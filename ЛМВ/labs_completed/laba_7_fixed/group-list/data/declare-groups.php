<?php
    $nameTpl = '/^group-\d\d\z/';
    $path =__DIR__;
    $conts = scandir($path);

    $i=0;
    foreach ($conts as $node) {
        if (preg_match($nameTpl, $node)) {
            $groupFolder = $node;
            require(__DIR__ . '/declare-group.php');
            $data['groups'][$i]['number'] = $data['group']['number'];
            $data['groups'][$i]['file'] = $groupFolder;
            $i++;
        }
    }