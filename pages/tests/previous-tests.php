<div class="previous-test-list">
	<table>
<?php

	$previousTests = $System->GetFitnessTestSystem()->GetPreviousTestList();


	?>

 <tr>
        <th colspan="5" class="table-title">Previous Tests</th>
    </tr>
    <tr>
        <th>Date</th>
        <th>Logged By</th>
        <th>Groups</th>
        <th>Actions</th>
    </tr>

    <?php foreach($previousTests as $key => $value) { ?>
    <tr>
    <?php
    		
    ?>

        <td>
			<?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?>
        </td>
        <td>
			Thomas McCarthy
        </td>
        <td>
			Upper Body, Hammies
        </td>
        <td>
			<a class="button" href="tests.php?a=view&amp;id=<?php echo $value["fitnessTestGroupID"]; ?>">View Test</a>
        </td>

    </tr>


<?php
	
}
?>

</tab
</div>