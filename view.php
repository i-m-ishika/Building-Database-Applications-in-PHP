<?php
	session_start();
	require_once "pdo.php";
	if(!isset($_SESSION['name'])){
		die('Not logged in');
	}
	$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<title>Ishika Mitra's Automobile Tracker</title>
<?php require_once "bootstrap.php";?>
</head>
<body>
<div class="container">
<?php
	if(isset($_SESSION['name'])){
		echo '<h1>Tracking Autos for '.htmlentities($_SESSION['name']).'</h1>';	
	}
	if(isset($_SESSION['success'])){
		echo('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>\n");
		unset($_SESSION['success']);
	}
?>
<h2>Automobiles</h2>
<ul>
<?php
	foreach($rows as $row){
		echo '<li>';
		echo $row['year']." ".htmlentities($row['make'])." / ".$row['mileage'];
		echo "</li><br\>";	
	}
?>
</ul>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</div>
</body></html>
