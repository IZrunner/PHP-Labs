<?php
	$data = array();
	$f=fopen("data/group.txt", "r");
	$grStr = fgets($f);
	$grArr = explode(";", $grStr);

	fclose($f);

$data['group'] = array(
	'number' => $grArr[0],
	'starosta' => $grArr[2],
	'department' => $grArr[1],
);

	$f=fopen("data/students.txt","r");
	$i=0;

	while (!feof($f)) {
		$rowStr=fgets($f);
		$rowArr=explode(";", $rowStr);

		$data['students'][$i]["name"] = $rowArr[0];
		$data['students'][$i]["gender"] = $rowArr[1];
		$data['students'][$i]["year"] = $rowArr[2];
	    
	    $i++;
	}

	fclose($f);
	
?>