            <div id="logo"><img src="images/logo.png" alt="Queensland Reds" /></div>
            <div id="search">
                <input type="text" placeholder="Search" />
            </div>
            <div id="profile">
                <img src="images/<?php echo $userData["profilePicture"] ?>" />
                Welcome <a href="#"><?php echo $userData["firstName"] ?> <?php echo $userData["lastName"] ?><br /><a href="logout.php">Logout</a>
