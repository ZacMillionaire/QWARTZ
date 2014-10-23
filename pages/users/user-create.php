<?php

$Users = $System->GetUserSystem();

$userList = $Users->GetUserList();

?>

<h3>New User</h3>
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
	<form class="settings-form" action="sys/exec/create-new-user.php" method="POST">
	<div id="table-container">
		<table>
			<tr>
				<th>First Name*</th>
				<td><input style="width:100%" type="text" name="firstName" pattern="[a-zA-Z\s-]*" placeholder="First Name" required/></td>
			</tr>
			<tr>
				<th>Last Name*</th>
				<td><input style="width:100%" type="text" name="lastName" pattern="[a-zA-Z\s-]*" placeholder="Last Name" required/></td>
			</tr>
			<tr>
				<th>Username*</th>
				<td><input style="width:100%" type="text" name="username" pattern="[a-zA-Z.-_0-9]{5,}" placeholder="Username" required/></td>
			</tr>
			<tr>
				<td colspan="2">Any combination of letters, numbers, - (dash), . (period), or _ (underscore), with a minimum length of 5</td>
			</tr>
			<tr>
				<th>Password*</th>
				<td><input style="width:100%" name="password1" type="password" placeholder="Password" pattern=".{8,}" required></td>
			</tr>
			<tr>
				<td colspan="2">Minimum length of 8</td>
			</tr>
			<tr>
				<th>Password Again*</th>
				<td><input style="width:100%" name="password2" type="password" placeholder="Password Again" pattern=".{8,}" required></td>
			</tr>
			<tr>
				<td colspan="2">Must match the previous password</td>
			</tr>
			<tr>
				<td colspan="2">
					<button class="button" type="submit"><span aria-hidden="true" class="icon-checkmark"></span>Create User</button>
					<a class="cancel" href="settings.php?a=users">Cancel</a>
				</td>
			</tr>
		</table>
	</form>