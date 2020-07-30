<?php
	session_start();
	if(!isset($_SESSION['name'])){
		die('ACCESS DENIED');
	}
	
	require_once "pdo.php";
	if(isset($_POST['cancel'])){
		header('Location: index.php');
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

			$sql = "UPDATE autos SET make = :make,
            model = :model, year = :year, mileage = :mileage
            WHERE auto_id = :auto_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
			    ':make' => $_POST['make'],
			    ':model' => $_POST['model'],
			    ':year' => $_POST['year'],
			    ':mileage' => $_POST['mileage'],
				':auto_id' => $_POST['autos_id']));
			$_SESSION['success'] = 'Record edited';
			header( 'Location: index.php' ) ;
			return;

		}

		$_SESSION['fail']=$fail;
		header('Location: edit.php?autos_id='.$_POST['autos_id']);
		return;
	}

	$stmt = $pdo->prepare('select * from autos where auto_id = :id');
	$stmt->execute(array(':id'=>$_GET['autos_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(count($row)===0){
		$_SESSION['error'] = 'Bad value for user_id';
    	header( 'Location: index.php' ) ;
    	return;
	}
	$id = $row['auto_id'];
	$make = htmlentities($row['make']);
	$model = htmlentities($row['model']);
	$year = htmlentities($row['year']);
	$mileage = htmlentities($row['mileage']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Ishika Mitra's Automobile Tracker</title>

<?php require_once "bootstrap.php"?>
</head>
<body>
<div class="container">
<h1>Editing Automobile</h1>
<?php
	if ( isset($_SESSION['fail']) ) {
    	echo '<p style="color:red">'.$_SESSION['fail']."</p>\n";
	    unset($_SESSION['fail']);
	}
	
?>
<form method="post">
<p>Make<input type="text" name="make" size="40" value="<?= $make?>"></p>
<p>Model<input type="text" name="model" size="40" value="<?= $model?>"></p>
<p>Year<input type="text" name="year" size="10" value="<?= $year?>"></p>
<p>Mileage<input type="text" name="mileage" size="10" value="<?= $mileage?>"></p>
<input type="hidden" name="autos_id" value="<?= $id?>">
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
</div>
</body>
</html>
