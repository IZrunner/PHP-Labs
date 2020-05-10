<?php
    $f = fopen($path . "/" . $node, "r");
    $rowStr = fgets($f);
    $rowArr = explode(";", $rowStr);
    $student['file'] = $node;
    $student['name'] = $rowArr[0];
    $student['gender'] = $rowArr[1];
    $student['dob'] = $rowArr[2];
    $student['privilege'] = $rowArr[3];
    fclose($f);
    return $student;
