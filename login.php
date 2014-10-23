<?php 
    $pageTitle = "Tests - Overview";
	
	ob_start();
	
    require "inc/header.php";

    if($userLoggedIn){
        header("Location: index.php");
        die();
    }

    function GetError($displayError){

		session_start();

    	// This function basically returns the error set in the session
    	if($displayError && isset($_SESSION["error"])){
    		echo "Error: ".$_SESSION["error"];
	    	session_destroy();
    	} elseif(!$displayError && !isset($_SESSION["error"])){
    		echo "hide";
    	}

    } // End GetError

    ob_end_flush();

?>
        <div id="login-logo"><img src="images/logo.png" alt="Queensland Reds" /></div>
        <div id="login-box">
            <h1>Welcome</h1>
            <div id="login-container">
            <form action="sys/exec/doLogin.php" method="POST">
				<div id="system-thinking-indicator">
					<div class="spinner">
						<div class="circle first"></div>
						<div class="circle second"></div>
						<div class="circle third"></div>
					</div>
				</div>
           		<div id="error-message" class="error <?php GetError(0); ?>">
            		<?php
            			// this and the above function call are a fallback for
            			// when javascript is disabled.
            			// Why bother? Why not.
            			GetError(1);
            		?>
            	</div>
                <input type="text" id="login-user" name="username" placeholder="Username"/>
                <input type="password" id="login-pass" name="password" placeholder="Password"/>
                <!--
                    TODO: update the style to copy the anchor tag it was previously
                -->
                <button class="button" id="login-action" type="submit">Login</button>
    	
            </form>
        </div>
        </div>
<?php 

    include "inc/footer.php";
    
?>
