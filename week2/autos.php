
<?php
	
	if(!isset($_GET['name'])){
		die('Name parameter missing');
	}
	if(isset($_POST['logout'])){
		header('Location: index.php');
		return;
	}

	// $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','root','potterhead');
	// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	require_once "pdo.php";
	$fail=false;
	$pass=false;
	if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){

		if(strlen($_POST['make'])<1){
			$fail="Make is required";
		}
		else if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
			$fail="Mileage and year must be numeric";
		}
		else{
			
			$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :make, :year, :mileage)');
        	$stmt->execute(array(
                ':make' => $_POST['make'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'])
        	);
        	$pass = 'Record inserted';
		}
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
	if(isset($_REQUEST['name'])){
		
		echo "<h1>Tracking Autos for ";
		echo htmlentities($_REQUEST['name']);
		echo "</h1>\n";

	}
?>
<?php
	if($fail!==false){
		echo('<p style="color:red;">'.htmlentities($fail)."</p>\n");
	}
	else{
		echo('<p style="color:green;">'.htmlentities($pass)."</p>\n");
	}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
<p>
<ul>
	<?php
		foreach($rows as $row){
			echo '<li>';
			echo $row['year']." ".htmlentities($row['make'])." / ".$row['mileage'];
			echo "</li><br\>";
		};
		
	?>
</ul></p></div></body></html>
