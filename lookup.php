<?php
    

    $pageTitle = "Lookup";

	ob_start();

	include "inc/header.php";

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

            <article id="page-header">
                <h1>Record Lookup</h1>

        </article>
        <article>
            <?php

                // I really miss angular...
                
                // All pages for this are handled in the below directories,
                // this page is just a template file really.
                switch(@$_GET["a"]){

                    case "lookup":
                        include "pages/lookup/lookup-results.php";
                        break;

                    default:
                        include "pages/lookup/lookup-form.php";
                        break;
                        
                }

            ?>
        </article>
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>