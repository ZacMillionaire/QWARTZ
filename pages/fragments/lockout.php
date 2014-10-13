	<!-- TODO: style this -->
	<div id="edit-warning">
		<h3>Read Only Message (needs styling > pages/fragments/lockout.php)</h3>
		This Page is readonly for another <?php echo ($timeTillUnlock > 1) ? $timeTillUnlock." minutes" : "minute"; ?>.
		<?php 
			if($editOwner) {
		?>
			<div id="edit-owner-message">
				However, you are the owner of this edit and are not restricted by this lockout.
			</div>
		<?php
			}
		?>
	</div>