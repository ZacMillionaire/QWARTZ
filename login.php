<?php 

	require "inc/header.php";

	if($userLoggedIn){
		header("Location: index.php");
		die();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login &bull; QWARTZ</title>
</head>
<body>

	<div class="module-login">

		<div class="full-width">
			<h1>Login</h1>
		</div>

		<form action="sys/exec/doLogin.php" method="POST">

			<div class="login input-row">
				<input type="text" name="username"/>
			</div>

			<div class="login input-row">
				<input type="password" name="password"/>
			</div>

			<div class="login input-row">
				<button class="button" type="submit">Login</button>			
			</div>

		</form>

	</div>

</body>
</html>