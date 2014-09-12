<?php

	require "inc/header.php";

	if(!$userLoggedIn){
		header("Location: index.php");
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
			$Users->LogUserOut();

	?>
		<h1>You are now logged out</h1>
		<a href="index.php">Go back</a>

	<?php

		} else {

	?>

		<h1>You are not logged in</h1>
		<a href="index.php">Go back</a>
	<?php

		}

	?>
	
</body>
</html>