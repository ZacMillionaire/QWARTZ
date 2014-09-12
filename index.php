<?php

	require "inc/header.php";

	if(!$userLoggedIn){
		header("Location: login.php");
		die();
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home &bull; QWARTZ</title>
</head>
<body>
	<?php
		if($userLoggedIn){
	?>
		<h1>Congrats, you're logged in</h1>
		<a href="logout.php">Logout</a>
	<?php
		} else {
	?>
		<h1>How the hell are you seeing this?</h1>
	<?php
		}
	?>
	
</body>
</html>