            <div id="logo"><img src="images/logo.png" alt="Queensland Reds" /></div>
            <div id="search">
            	<form action="lookup.php?a=search" method="POST">
	                <input type="text" name="search" placeholder="Search" />
	            </form>
            </div>
            <div id="profile">
                <img src="images/<?php echo $userData["profilePicture"] ?>" />
                Welcome <a href="#"><?php echo $userData["firstName"] ?> <?php echo $userData["lastName"] ?><br /><a href="logout.php">Logout</a>
