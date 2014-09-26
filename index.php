<?php

    $pageTitle = "Dashboard";

	ob_start();

	require "inc/header.php";

	if(!$userLoggedIn){
		header("Location: login.php");
		die();
	}

	$userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

    ob_end_flush();

?>

    <div id="container">
        <header id="top-header">
            <!-- Layout Header Start -->
            <?php
                include "inc/layout/header.php";
            ?>
            <!-- Layout Header End -->
        </header>
        <nav id="main-nav">
            <!-- Side Nav Start -->
            <?php
                include "inc/side_navigation.php";
                ?>
            <!-- Side Nav End -->
        </nav>
        <div id="content">
            
            <article>
                <h1>Dashboard</h1>
            </article>

            <article class="table-box">
                <table>
                    <tr>
                        <th colspan="3" class="table-title">Latest Test Results</th>
                    </tr>
                    <tr>
                        <th>Player</th><th>Weight</th><th>Action</th>
                    </tr>
                    <tr>
                        <td>231</td><td>123</td><td>123123</td>
                    </tr>
                    <tr>
                        <td>231</td><td>123</td><td>123123</td>
                    </tr>
                    <tr>
                        <td>231</td><td>123</td><td>123123</td>
                    </tr>
                    <tr>
                        <td>231</td><td>123</td><td>123123</td>
                    </tr>
                    <tr>
                        <td>231</td><td>123</td><td>123123</td>
                    </tr>
                </table>
            </article>

            <div id="dashboard-2">

                <article class="table-box">
                    <table>
                        <tr>
                            <th colspan="3" class="table-title">Changelog</th>
                        </tr>
                        <tr>
                            <th>Date</th><th>User</th><th>Action</th>
                        </tr>
                        <tr>
                            <td>8/9/2014</td><td>Tim Cook</td><td>Added Test for Jim Rogers</td>
                        </tr>
                        <tr>
                            <td>7/9/2014</td><td>Jason Chan</td><td>Edited Settings</td>
                        </tr>
                        <tr>
                            <td>4/9/2014</td><td>Thomas McCarthy</td><td>Edited Settings</td>
                        </tr>
                        <tr>
                            <td>4/9/2014</td><td>Thomas McCarthy</td><td>Edited Test for Jim Rogers</td>
                        </tr>
                    </table>
                </article>


                <article id="currently-logged">
                    <h2>Currently Online</h2>

                    <ul>
                    <?php
                    $userList = $Users->GetLoggedInUserList();

                    foreach ($userList as $key => $value) {
                    echo "<li>$value[firstName] $value[lastName]</li>";
                    }

                    ?>
                    </ul>

                </article>
            </div>

            <article>
                <a class="button">Button</a>
            </article>

            <article>
                <p>Pellentesque hendrerit et nisi quis pretium. Nam lacinia libero dui. Curabitur dapibus diam sit amet neque euismod egestas. Nam mattis dignissim ipsum, in bibendum lectus. Mauris vestibulum luctus est. Pellentesque tristique congue enim, at vehicula lorem convallis suscipit. Nullam ut tempor diam. Phasellus pharetra ligula ultricies congue ultrices. Integer eget arcu congue, placerat nulla vel, sodales ligula. Suspendisse in metus ut diam auctor scelerisque nec in eros. Donec ipsum orci, efficitur sed sollicitudin in, efficitur non elit.</p>
            </article>

        </div>
    </div>
<?php 

    include "inc/footer.php";

?>