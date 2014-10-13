<?php

$Users = $System->GetUserSystem();

$userData = $Users->GetUserByID($_GET["id"]);

?>

<h3>Edit User</h3>
	<?php 
		if(isset($_GET["e"])){
	?>
	<div class="error-message">
		<h3>Error</h3>
		<?php echo $_GET["e"]; ?>
	</div>
	<?php
		}
	?>
	<form action="sys/exec/update-user.php" method="POST">
	<div id="table-container">
		<input type="hidden" name="userID" value="<?php echo $_GET["id"]; ?>">
		<input type="hidden" name="oldUsername" value="<?php echo $userData["username"]; ?>">
		<table>
			<tr>
				<th>Username*</th>
				<td><input style="width:100%" type="text" name="username" pattern="[a-zA-Z.-_0-9]{5,}" placeholder="Username" required title="adsfdas" value="<?php echo $userData["username"]; ?>"/></td>
			</tr>
			<tr>
				<td colspan="2">Any combination of letters, numbers, - (dash), . (period), or _ (underscore), with a minimum length of 5.</td>
			</tr>
			<tr>
				<th>New Password*</th>
				<td><input style="width:100%" name="password1" type="password" placeholder="New Password" pattern=".{8,}"></td>
			</tr>
			<tr>
				<td colspan="2">Minimum length of 8. Only required if you wish to change the users password.</td>
			</tr>
			<tr>
				<th>Password Again*</th>
				<td><input style="width:100%" name="password2" type="password" placeholder="Password Again" pattern=".{8,}"></td>
			</tr>
			<tr>
				<td colspan="2">Must match the previous password if previously entered.</td>
			</tr>
			<tr>
				<td colspan="2">
					<button style="width:100%" class="button" type="submit">Update User</button>
				</td>
			</tr>
		</table>
	</form>