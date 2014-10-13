<?php

$Users = $System->GetUserSystem();

$userList = $Users->GetUserList();

?>
<style>
    
    tr:target {
        background-color: hsla(50, 100%, 80%, 1);
    }

</style>

<h3>User List</h3>

	<div id="table-container">
		<table>
			<tr>
				<th>Username</th>
				<th colspan="2">Action</th>
			</tr>
			<?php
				foreach($userList as $key => $value){
			?>
			<tr id="user-<?php echo $value["username"]; ?>">
				<td><?php echo $value["username"]; ?></td>
				<td><a href="settings.php?a=users&amp;m=u&amp;id=<?php echo $value["userID"]; ?>">Edit User</a></td>
				<td><a href="settings.php?a=users&amp;m=d&amp;id=<?php echo $value["userID"]; ?>">Remove User</a></td>
			</tr>
			<?php
				}
			?>
		</table>