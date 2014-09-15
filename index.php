<?php

	ob_start();
	
	require "inc/header.php";

	if(!$userLoggedIn){
		header("Location: login.php");
		die();
	}

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

    ob_end_flush();

?>
    <body>

        <div id="container">
        <header id="top-header">
            <div id="logo"><img src="images/logo.png" alt="Queensland Reds" /></div>
            <div id="search">
                <input type="text" placeholder="Search" />
            </div>
            <div id="profile">
                <img src="images/<?php echo $userData["profilePicture"] ?>" />
                Welcome <a href="#"><?php echo $userData["firstName"] ?> <?php echo $userData["lastName"] ?><br /><a href="logout.php">Logout</a></header>
            <nav id="main-nav">
                <ul>
                    <li><a href="#"><span aria-hidden="true" class="icon-dashboard"></span>Dashboard</a></li>
                    <li><a href="#"><span aria-hidden="true" class="icon-accessibility"></span>Tests</a></li>
                    <li><a href="#"><span aria-hidden="true" class="icon-search"></span>Lookup</a></li>
                    <li><a href="#"><span aria-hidden="true" class="icon-table"></span>Templates</a></li>
                    <li><a href="#"><span aria-hidden="true" class="icon-users"></span>Players</a></li>
                    <li><a href="#"><span aria-hidden="true" class="icon-cog"></span>Settings</a></li>
                </ul>
            </nav>
            <div id="content">
            <article><h1>Dashboard</h1></article>

            <article class="table-box"><table>
                <tr><th colspan="3" class="table-title">Latest Test Results</th></tr>
                <tr><th>Player</th><th>Weight</th><th>Action</th></tr>
                <tr><td>231</td><td>123</td><td>123123</td></tr>
                <tr><td>231</td><td>123</td><td>123123</td></tr>
                <tr><td>231</td><td>123</td><td>123123</td></tr>
                <tr><td>231</td><td>123</td><td>123123</td></tr>
                <tr><td>231</td><td>123</td><td>123123</td></tr></table></article>

                <div id="dashboard-2">
                        <article class="table-box"><table>
                <tr><th colspan="3" class="table-title">Changelog</th></tr>
                <tr><th>Date</th><th>User</th><th>Action</th></tr>
                <tr><td>8/9/2014</td><td>Tim Cook</td><td>Added Test for Jim Rogers</td></tr>
                <tr><td>7/9/2014</td><td>Jason Chan</td><td>Edited Settings</td></tr>
                <tr><td>4/9/2014</td><td>Thomas McCarthy</td><td>Edited Settings</td></tr>
                <tr><td>4/9/2014</td><td>Thomas McCarthy</td><td>Edited Test for Jim Rogers</td></tr></table></article>


            <article id="currently-logged"><h2>Currently Online</h2>
                <ul><li>Chris Loranger</li>
                    <li>Jason Chan</li>
                    <li>Tim Cook</li>
                    <li>Kevin Rudd</li>
                    <li>Thomas McCarthy</li>
                </ul>
                            </div>
            <article><br /><a class="button">Button</a></article>

                            <article>
<p>Pellentesque hendrerit et nisi quis pretium. Nam lacinia libero dui. Curabitur dapibus diam sit amet neque euismod egestas. Nam mattis dignissim ipsum, in bibendum lectus. Mauris vestibulum luctus est. Pellentesque tristique congue enim, at vehicula lorem convallis suscipit. Nullam ut tempor diam. Phasellus pharetra ligula ultricies congue ultrices. Integer eget arcu congue, placerat nulla vel, sodales ligula. Suspendisse in metus ut diam auctor scelerisque nec in eros. Donec ipsum orci, efficitur sed sollicitudin in, efficitur non elit.</p>
                </article>

        </div>
    </div>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="js/main.js"></script>
    </body>
</html>
