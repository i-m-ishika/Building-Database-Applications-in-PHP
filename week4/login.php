<?php
	session_start();
	if(isset($_POST['cancel'])){
		header("Location: index.php");
		return;
	}
	if(isset($_POST['name'])){
		unset($_POST['name']);
	}
	$salt='XyZzy12*_';
	$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //password is php123
	$fail = false;
	$check=hash('md5', $salt.$_POST['pass']);
			
	if(isset($_POST['email'])&&isset($_POST['pass'])){
		//empty field
		if(strlen($_POST['email'])<1||strlen($_POST['pass'])<1){
			$fail = "Email and password are required";
		}
		else if($check!==$stored_hash){
			$fail ="Incorrect password";
		}
		else{
			$flag=strpos($_POST['email'],'@');
			if($flag===false || strlen($_POST['email'])===1){
				$fail="Email must have an at-sign (@)";
			}
			else{
				error_log("Login success ".$_POST['email']);
				$_SESSION['name']=$_POST['email'];
				header("Location: view.php");
				return;
			}	
		}
		$_SESSION['error']=$fail;
		header("Location: login.php");
		return;

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
	if(isset($_SESSION['error'])){
		error_log("Login fail ".$_POST['email']." $check");
		echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
		unset($_SESSION['error']);
	}
?>

<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
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
