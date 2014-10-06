<?php
    

    $pageTitle = "Players - Overview";

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
                <h1>Players</h1>

            <!--

                TODO: Style this sub navigation element

            -->

            <nav id="sub-nav">
                <ul>
                    <li <?php if (@$_GET["a"] == null) echo 'class="active"'; ?>><a href="players.php">Overview</a></li>
                    <li <?php if (@$_GET["a"] == "list") echo 'class="active"'; ?>><a href="players.php?a=list">Player List</a></li>
                </ul>  
                         
            </nav>

        </article>
        <article>
            
            <?php if(@$_GET["a"] != "new" && @$_GET["a"] != "edit") { ?>
            <div id="button-area">
                <a href="players.php?a=new" class="button">New Player</a>

                <?php
                    if(@$_GET["a"] == "view" && isset($_GET["id"])) {
                ?>

                <a href="players.php?a=edit&amp;id=<?php echo $_GET["id"]; ?>" class="button">Edit Player</a>

                <?php
                    }
                ?>

            </div>
            <?php } ?>

            <?php

                // I really miss angular...
                
                // All pages for this are handled in the below directories,
                // this page is just a template file really.
                switch(@$_GET["a"]){

                    case "new":
                        include "pages/players/new-player.php";
                        break;
                    case "list":
                        include "pages/players/view-players.php";
                        break;
                    case "edit":
                        if(isset($_GET["id"]) || isset($_GET["playerID"])) {
                            include "pages/players/edit-player.php";
                        } else {
                            include "pages/players/view-players.php";
                        }
                        break;
                    case "view":
                        if(isset($_GET["id"])) {
                            include "pages/players/player-overview.php";
                        } else {
                            include "pages/players/view-players.php";
                        }
                        break;
                    default:
                        include "pages/players/overview.php";
                        break;
                        
                }

            ?>
        </article>
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>