<?php 
	$f=fopen(__DIR__ . "/students.txt","r");
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