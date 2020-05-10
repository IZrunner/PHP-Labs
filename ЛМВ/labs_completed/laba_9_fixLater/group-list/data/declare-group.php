<?php
    $f = fopen(__DIR__. "/" . $groupFolder ."/group.txt","r");
    $grStr =fgets($f);
    $grArr = explode(";", $grStr);
    fclose($f);

    $data['group'] = array(
        'number' => $grArr[0],
        'starosta' => $grArr[1],
        'department' => $grArr[2],
    );  
?>