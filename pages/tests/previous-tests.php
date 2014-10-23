<?php
	
	$dateStart = (isset($_GET["f"])) ? $_GET["f"] : strtotime("-1 week",time());
	$dateEnd = (isset($_GET["t"])) ? $_GET["t"] : time();

	$previousTests = $System->GetFitnessTestSystem()->GetPreviousTestList($dateStart,$dateEnd);

	$presetTimes = array(
		"thisWeek" => array(
			"start" => strtotime("-1 week",time()),
			"end" => time()
		),
		"thisMonth" => array(
			"start" => strtotime("first day of this month",time()),
			"end" => strtotime("last day of this month",time())
		),
		"lastMonth" => array(
			"start" => strtotime("first day of last month",time()),
			"end" => strtotime("last day of last month",time())
		)
	);


?>

<div class="time-span-container">
	<a class="button" href="tests.php?a=view&amp;f=<?php echo $presetTimes["thisWeek"]["start"]; ?>&amp;t=<?php echo $presetTimes["thisWeek"]["end"]; ?>">Past Week</a>
	<a class="button" href="tests.php?a=view&amp;f=<?php echo $presetTimes["thisMonth"]["start"]; ?>&amp;t=<?php echo $presetTimes["thisMonth"]["end"]; ?>">This Month</a>
	<a class="button" href="tests.php?a=view&amp;f=<?php echo $presetTimes["lastMonth"]["start"]; ?>&amp;t=<?php echo $presetTimes["lastMonth"]["end"]; ?>">Last Month</a>
	<a class="button" href="lookup.php">Custom</a>
</div>

<div class="previous-test-list">
	<table>
		<tr>
			<th colspan="5" class="table-title">Previous Tests: <?php echo date('d/m/Y',$dateStart); ?> - <?php echo date('d/m/Y',$dateEnd); ?></th>
		</tr>
		<tr>
			<th>Date</th>
			<th>Logged By</th>
			<th>Exercises</th>
			<th>Actions</th>
		</tr>
		<?php 
			if($previousTests == null){
		?>
		<tr>
			<td colspan="4">
				No test results to display for this period
			</td>
		</tr>
		<?php
			}
		?>
		<?php
			foreach($previousTests as $key => $value) {
		?>
		<tr>
			<td>
				<?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?>
			</td>
			<td>
				<?php echo $value["author"]; ?>
			</td>
			<td>
				<?php

					foreach ($value["exercises"] as $ekey => $evalue) {
						
						echo $evalue;
						if(($ekey+1) != count($value["exercises"])) {
							echo ", ";
						}

					}

				?>
			</td>
			<td>
				<a class="button" href="tests.php?a=view&amp;id=<?php echo $key; ?>"><span aria-hidden="true" class="icon-eye"></span>View</a>
			</td>
		</tr>
		<?php	
			}
		?>
	</table>
</div>