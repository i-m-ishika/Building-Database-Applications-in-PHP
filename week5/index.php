<?php
	session_start();
	require_once "pdo.php";
	$stmt= $pdo->query("select * from autos");
	$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Ishika Mitra's Index Page</title>
<?php require_once "bootstrap.php";?>
</head>
<body>

<div class="container">
<h2>Welcome to the Automobiles Database</h2>
<?php
	if(isset($_SESSION['name'])){
	if(isset($_SESSION['success'])){
		echo('<p style="color:green;">'.$_SESSION['success']."</p>\n");
		unset($_SESSION['success']);
	}
	if(isset($_SESSION['error'])){
		echo('<p style="color:red;">'.$_SESSION['error']."</p>\n");
		unset($_SESSION['error']);	
	}
	if(count($rows)===0){
		echo '<p>No rows found</p>';
	}
	else{
		

		echo('<table border="1">'."\n");
		echo('<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>');
		foreach($rows as $row){
			echo '<tr><td>';
			echo(htmlentities($row['make']));
			echo '</td><td>';
			echo(htmlentities($row['model']));
			echo '</td><td>';
			echo(htmlentities($row['year']));
			echo '</td><td>';
			echo(htmlentities($row['mileage']));
			echo '</td><td>';
			echo('<a href="edit.php?autos_id='.$row['auto_id'].'">Edit</a> / ');
	    	echo('<a href="delete.php?autos_id='.$row['auto_id'].'">Delete</a>');
	    	echo('</td></tr>');
		}
	echo '</table>';


	}
	echo '<p><a href="add.php">Add New Entry</a></p>';
	echo '<p><a href="logout.php">Logout</a></p>';

	}
	else{
		echo '<p><a href="login.php">Please log in</a></p>
<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
	}
?>


</p>
</div>
</body>
</html>
