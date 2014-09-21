<h3>Previous tests</h3>

<div class="previous-test-list">
<?php

	$previousTests = $System->GetFitnessTestSystem()->GetPreviousTestList();

	foreach($previousTests as $key => $value) {
	?>
	<div class="previous-test-row">
		<div class="previous-test-date">
			<a href="tests.php?a=view&amp;id=<?php echo $value["fitnessTestGroupID"]; ?>"><?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?></a>
		</div>
	</div>
<?php
	}

?>
</div>