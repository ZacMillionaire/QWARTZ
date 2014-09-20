<?php 
	
    $pageTitle = "Logout";
	ob_start();
	
    require "inc/header.php";

    if(!$userLoggedIn){
        header("Location: index.php");
        die();
    }

    ob_end_flush();

?>

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
	
<?php 

    include "inc/footer.php";
    
?>