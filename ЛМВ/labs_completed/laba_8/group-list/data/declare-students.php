<?php
    $nameTpl = '/^student-\d\d.txt\z/';
    $path = __DIR__ . "/" . $groupFolder;
    $conts = scandir($path);
    
    $i = 0;
    foreach ($conts as $node) {
        if (preg_match($nameTpl, $node)) {
            $data['students'][$i] = require __DIR__ . '/declare-student.php';
            $i++;
        }
    }


    // $f = fopen(__DIR__. "/students.txt","r");
    // $i = 0;
    // while (!feof($f)) {
    //     $rowStr = fgets($f);
    //     $rowArr = explode(";", $rowStr);
    //     $data['students'][$i]["name"]=$rowArr[0];
    //     $data['students'][$i]["gender"]=$rowArr[1];
    //     $data['students'][$i]["year"]=$rowArr[2];
    //     $i++;
    // }
    // fclose($f);
