<div class="previous-test-list">
	<table>
        <pre>
<?php

	$previousTests = $System->GetFitnessTestSystem()->GetPreviousTestList();

?>

 <tr>
        <th colspan="5" class="table-title">Previous Tests</th>
    </tr>
    <tr>
        <th>Date</th>
        <th>Logged By</th>
        <th>Exercises</th>
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
			NYI
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
			<a class="button" href="tests.php?a=view&amp;id=<?php echo $key; ?>">View Test</a>
        </td>

    </tr>


<?php
	
}
?>

</tab
</div>