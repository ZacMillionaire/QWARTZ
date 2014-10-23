<?php
    

    $pageTitle = "Templates";

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
                <h1>Fitness Templates</h1>

        </article>
        <article>
            
            <?php if(@$_GET["a"] == "saved" || !isset($_GET["a"])) { ?>
            <div id="button-area">
                <a href="templates.php?a=new" class="button"><span aria-hidden="true" class="icon-compose"></span>New Template</a>
            </div>
            <?php } ?>

            <?php

                // I really miss angular...
                
                // All pages for this are handled in the below directories,
                // this page is just a template file really.
                switch(@$_GET["a"]){

                    case "new":
                        include "pages/templates/new-fitness-template.php";
                        break;

                    case "saved":
                        include "pages/templates/saved-templates.php";
                        break;

                    case "edit":

                        // Take them to edit the template if given an ID
                        // otherwise take them to the saved templates list
                        if(isset($_GET["id"])){
                            include "pages/templates/edit-template.php";
                        } else {
                            include "pages/templates/saved-templates.php";                           
                        }
                        break;

                    case "clone":

                        // Take them to edit the template if given an ID
                        // otherwise take them to the saved templates list
                        if(isset($_GET["id"])){
                            include "pages/templates/clone-template.php";
                        } else {
                            include "pages/templates/saved-templates.php";                           
                        }
                        break;

                    case "view":
                        include "pages/templates/view-template.php";                           
                        break;

                    default:
                        include "pages/templates/saved-templates.php";
                        break;
                        
                }

            ?>
        </article>
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>