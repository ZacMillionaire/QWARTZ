<?php
    

    $pageTitle = "Tests - Overview";

	ob_start();

	include "inc/header.php";

	if(!$userLoggedIn){
        die();
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
                <h1>Lookup</h1>
            </article>

            <!--

                TODO: Style this sub navigation element

            -->

            <nav id="sub-nav">
                <ul>
                    <li><a href="tests.php?a=new">Create New</a></li>
                    <li><a href="tests.php?a=view">View Previous</a></li>
                </ul>               
            </nav>
        
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>