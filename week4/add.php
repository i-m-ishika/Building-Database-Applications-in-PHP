<?php
	require_once "pdo.php";
	session_start();
	if(!isset($_SESSION['name'])){
		die('Not logged in');
	}
	if(isset($_POST['cancel'])){
		header('Location: view.php');
		return;
	}
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
        	$_SESSION['success']=$pass;
        	header('Location: view.php');
        	return;
		}
		$_SESSION['fail']=$fail;
		header('Location: add.php');
		return;
	}
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
		
		echo "<h1>Tracking Autos for ";
		echo htmlentities($_SESSION['name']);
		echo "</h1>\n";

	}
	
	if(isset($_SESSION['fail'])){
		echo('<p style="color:red;">'.htmlentities($_SESSION['fail'])."</p>\n");
		unset($_SESSION['fail']);
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
<input type="submit" name="cancel" value="Cancel">
</form>
</div></body></html>
