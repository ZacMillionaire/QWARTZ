<?php
	include "sys/system.php";

	$System = new System();

	$Users = $System->GetUserSystem();
	$userLoggedIn = $Users->CheckIsLoggedIn();
        $userData = $Users->GetUserProfile($Users->GetUserIDFromHash($_COOKIE["loginHash"]));

?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login &bull; QWARTZ</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=Questrial|Open+Sans:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
        
    </head>
<?php if (!isset($isLogin)) { ?>
   <body>

        <div id="main" class="m-scene">
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

<?php }; ?>