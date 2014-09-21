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
                <h1>Tests</h1>
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
            
            <?php

                // I really miss angular...
                
                // All pages for this are handled in the below directories,
                // this page is just a template file really.
                switch(@$_GET["a"]){

                    case "new":
                        include "pages/tests/new-test.php";
                        break;
                    case "view":
                        if(isset($_GET["id"])){
                            include "pages/tests/view-test.php";                           
                        } else {
                            include "pages/tests/previous-tests.php";                           
                        }
                        break;
                    default:
                        include "pages/tests/overview.php";
                        break;
                        
                }

            ?>
        
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>