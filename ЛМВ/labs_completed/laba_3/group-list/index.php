<?php
	require('/data/declare-data.php'); 
 ?>
<!DOCTYPE html>
<html>
<head> 
	<title> Список группы </title>
	<link rel="stylesheet" href="css/main-style.css">
	<link rel="stylesheet" href="css/gender-style.css">
</head>
<body>
<header>
	<h1> Список группи <span class='group-number'><?php echo $data['group']['number']; ?></span></h1>
	<h3> Староста: <span class='group-starosta'><?php echo $data['group']['starosta']; ?></span></h3>
	<h3> Факультет <span class='group-department'><?php echo $data['group']['department']; ?></span></h3></header>
	<a href="forms/edit-group.php">Редагувати групу</a>
	<section> 
		<table> 
			<thead>
			 <tr> 
			 	<th>№ п.п.</th> 
			 	<th>Прізвище </th> 
			 	<th>Стать </th> 
			 	<th>Рік народження</th> 
			 </tr> 
		</thead>
		<tbody>
			<?php foreach ($data['students'] as $key => $student): ?>
				<?php 
					$row_class ='row';

					if($student['gender']=='чол') {
						$row_class ='student-boy';
					}
					if($student['gender'] =='жін') {
						$row_class = 'student-girl';
					} ?>

			<tr class="<?php echo $row_class; ?>"> 
			 	<td><?php echo ($key + 1); ?></td> 
			 	<td><?php echo $student['name']; ?></td>
			 	<td><?php echo $student['gender']; ?></td>
			 	<td><?php echo $student['year']; ?></td>
			 </tr>
			 <?php endforeach; ?>
			 </tbody>
			</table>
		</section>
	</body>
</html>