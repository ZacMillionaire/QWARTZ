<?php

$Users = $System->GetUserSystem();

$userData = $Users->GetUserByID($_GET["id"]);

?>

<h3>Delete User</h3>

<!-- TODO: Probably not use tables here but I'm hella tired -->
	<form action="sys/exec/delete-user.php" method="POST">
	<div id="table-container">
		<input type="hidden" name="userID" value="<?php echo $_GET["id"]; ?>" />
		<table>
			<tr>
				<th colspan="2">Really remove this user?</th>
			</tr>
			<tr>
				<td colspan="2"><?php echo $userData["username"]; ?></td>
			</tr>

			<tr>
				<td colspan="2">
					<button style="width:100%" class="button" type="submit">Remove User</button>
				</td>
			</tr>
		</table>
	</form>