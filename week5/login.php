<?php
	session_start();
	$fail=false;
	if(isset($_POST['email'])&&isset($_POST['pass'])){
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$correct='php123';
		if(strlen($email)<1||strlen($pass)<1){
			$fail= 'User name and password are required';
		}
		else if($pass!==$correct){
			$fail='Incorrect password';
		}
		else{
			//successful LOGIN
			$_SESSION['name']=$email;
			header('Location: index.php');
			return;

		}
		if($fail!==false){
			$_SESSION['fail']=$fail;
			header('Location: login.php');
			return;
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
	if(isset($_SESSION['fail'])){
		echo('<p style="color:red;">'.htmlentities($_SESSION['fail'])."</p>\n");
		unset($_SESSION['fail']);
	}
?>
<form method="POST" action="login.php">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<a href="index.php">Cancel</a></p>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
</div>
</body>