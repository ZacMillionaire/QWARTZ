<?php
	include "sys/system.php";

	$System = new System();

	$Users = $System->GetUserSystem();
	$userLoggedIn = $Users->CheckIsLoggedIn();
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
        <link rel="stylesheet" href="http://i.icomoon.io/public/temp/c475fbc8ef/UntitledProject1/style.css">
        <link rel="stylesheet" href="style.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
        
    </head>
