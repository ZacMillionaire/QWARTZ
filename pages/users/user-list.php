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
				<th colspan="2">Actions</th>
			</tr>
			<?php
				foreach($userList as $key => $value){
			?>
			<tr id="user-<?php echo $value["username"]; ?>">
				<td class="username"><?php echo $value["username"]; ?></td>
				<td><a class="button" href="settings.php?a=users&amp;m=u&amp;id=<?php echo $value["userID"]; ?>"><span aria-hidden="true" class="icon-pencil"></span>Edit</a>
					<a class="button" href="settings.php?a=users&amp;m=d&amp;id=<?php echo $value["userID"]; ?>"><span aria-hidden="true" class="icon-close"></span>Remove</a></td>
			</tr>
			<?php
				}
			?>
		</table>