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

        </article>
        <article>
            
            <?php if(@$_GET["a"] != "new" && @$_GET["a"] != "edit") { ?>
            <div id="button-area">
                <a href="players.php?a=new" class="button">New Player</a>

                <?php
                    if(@$_GET["a"] == "view" && isset($_GET["id"])) {


                        $lockData = $System->GetDataLockSystem()->GetPlayerDataLockStatus($_GET["id"]);
                        $lockDuration = $System->GetDataCollectionSystem()->GetReadOnlyDuration();
                        $rowUnlocks = strtotime("+".$lockDuration." minutes", strtotime($lockData["lastEditDateTime"]));

                        $literallyRightNow =  strtotime(date("g:i:s",time()));

                        $editOwner = ($userData["userID"] == $lockData["lastEditOwner"]);
                        $pageReadOnly =($literallyRightNow < $rowUnlocks);

                        if($pageReadOnly){
                            if($editOwner){
                ?>
                <a href="players.php?a=edit&amp;id=<?php echo $_GET["id"]; ?>" class="button">Edit Player</a>
                <?php
                            } else {
                ?>
                <a class="button disabled" style="background:#aaa !important; text-shadow: none;">Edit Player</a>
                <?php 
                            } // end if owner
                        } else { // page isn't read only
                ?>

                <a href="players.php?a=edit&amp;id=<?php echo $_GET["id"]; ?>" class="button">Edit Player</a>

                <?php
                        } // end if page read only
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
                        include "pages/players/view-players.php";
                        break;
                        
                }

            ?>
        </article>
        </div>
    </div>
<?php 

    include "inc/footer.php";

?>