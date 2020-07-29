<?php
	if(isset($_POST['cancel'])){
		header("Location: index.php");
		return;
	}
	$salt='XyZzy12*_';
	$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //password is php123
	$fail = false;
	$check=hash('md5', $salt.$_POST['pass']);
			
	if(isset($_POST['who'])&&isset($_POST['pass'])){
		//empty field
		if(strlen($_POST['who'])<1||strlen($_POST['pass'])<1){
			$fail = "Email and password are required";
		}
		else if($check!==$stored_hash){
			$fail ="Incorrect password";
		}
		else{
			$flag=strpos($_POST['who'],'@');
			if($flag===false || strlen($_POST['who'])===1){
				$fail="Email must have an at-sign (@)";
			}
			else{
				error_log("Login success ".$_POST['who']);
				header("Location: autos.php?name=".urldecode($_POST['who']));
			return;
			}	
		}
		

	}

?>

<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php";?>
<title>Ishika Mitra's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
	if($fail!==false){
		error_log("Login fail ".$_POST['who']." $check");
		echo('<p style="color:red;">'.htmlentities($fail)."</p>\n");
	}
?>

<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is php123. -->
</p>
</div>
</body>
