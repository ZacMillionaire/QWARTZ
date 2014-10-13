<?php

$Users = $System->GetUserSystem();

// $userList = $Users->GetUserByID($_GET["id"]);

?>

<h2>User Management</h2>
<?php 
switch ($_GET["m"]) {

	case 'c':
		include "pages/users/user-create.php";
		break;

	case 'u':
		include "pages/users/user-update.php";
		break;

	case 'd':
		include "pages/users/user-delete.php";
		break;
	
	default:
		include "pages/users/user-list.php";
		break;
		
}
?>