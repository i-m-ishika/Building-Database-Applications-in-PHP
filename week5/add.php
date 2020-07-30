<?php
	require_once "pdo.php";
	session_start();
	if(!isset($_SESSION['name'])){
		die('ACCESS DENIED');
	}
	if(isset($_POST['cancel'])){
		header('Location: index.php');
		return;
	}
	
	if(isset($_POST['make'])&&isset($_POST['model'])&&isset($_POST['mileage'])&&isset($_POST['year'])){
		$fail=false;

		if(strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1){
			$fail = "All fields are required";
		}
		else if(!is_numeric($_POST['year'])){
			$fail = "Year must be numeric";
		}
		else if(!is_numeric($_POST['mileage'])){
			$fail = "Mileage must be numeric";
		}

		else{
			$stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :make, :model, :year, :mileage)');
        	$stmt->execute(array(
                ':make' => $_POST['make'],
                ':model'=> $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'])
        	);
        	$success = 'Record added';
        	$_SESSION['success']=$success;
        	header('Location: index.php');
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

<input type="text" name="make" size="40"/></p>
<p>Model:

<input type="text" name="model" size="40"/></p>
<p>Year:

<input type="text" name="year" size="10"/></p>
<p>Mileage:

<input type="text" name="mileage" size="10"/></p>
<input type="submit" name='add' value="Add">
<input type="submit" name="cancel" value="Cancel">
</form></div></body></html>
