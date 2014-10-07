<?php

$Players = $System->GetPlayerSystem();

$playerList = $Players->GetPlayerList();

?>

<div id="player-card-container">
	<?php 
		foreach ($playerList as $key => $value) {
	?>
	<div class="player-card">

		<div class="player-profile-picture">
			<a style="display:block;width:100%;height:100%;" href="players.php?a=view&amp;id=<?php echo $value["PlayerID"]; ?>">
				<img src="<?php echo ($value["profilePicture"] != null)?$value["profilePicture"]:"images/default_profile.png"; ?>" alt="" />
			</a>
		</div>
		<div class="player-name">
			<a style="display:block;width:100%;height:100%;" href="players.php?a=view&amp;id=<?php echo $value["PlayerID"]; ?>">
				<?php echo $value["FirstName"]." ".$value["LastName"]; ?>
			</a>
		</div>
		<div class="player-position">
			<div class="profile-label">Position</div>
			<div class="profile-value"><?php echo $value["Position"]; ?></div>
		</div>
		<div class="player-weight">
			<div class="profile-label">Weight</div>
			<div class="profile-value"><?php echo $value["Weight"]; ?>KG</div>
		</div>
	</div>
	<?php
		}
	?>
</div>