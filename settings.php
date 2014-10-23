<?php
    

    $pageTitle = "Settings";

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
                <h1>Settings</h1>

            <!--

                TODO: Style this sub navigation element

            -->

            <nav id="sub-nav">
                <ul>
                    <li <?php if (@$_GET["a"] == null) echo 'class="active"'; ?>><a href="settings.php">Main</a></li>
                    <li <?php if (@$_GET["a"] == "users") echo 'class="active"'; ?>><a href="settings.php?a=users">User Management</a></li>
                </ul>  
                         
            </nav>

        </article>
        <article>
            
            <?php if(@$_GET["a"] == "users") { ?>
            <div id="button-area">
                <a href="settings.php?a=users&amp;m=c" class="button"><span aria-hidden="true" class="icon-compose"></span>New User</a>
            </div>
            <?php } ?>

            <?php

                // I really miss angular...
                
                // All pages for this are handled in the below directories,
                // this page is just a template file really.
                switch(@$_GET["a"]){

                    case "users":
            			include "pages/users/user-management.php";
                        break;

                    default:
                        include "pages/settings/overview.php";
                        break;
                        
                }

            ?>
        </article>
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>