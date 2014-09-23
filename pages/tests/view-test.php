<pre>
<?php

	$selectedTest = $System->GetFitnessTestSystem()->GetPreviousFitnessTestData($_GET['id']);

?>
</pre>
<h2>Previous Test Data For <?php echo date("d/m/Y",strtotime($selectedTest["testDate"])); ?></h2>
<table id="test-table">
    <?php

    	foreach ($selectedTest["data"] as $key => $value) {
    ?>
        <thead>
    <tr>
        <th colspan="5" class="table-title"><?php echo $key; ?></th>
    </tr>

    <tr>
        <th class="sorter" data-sort="string">Player</th>
        <th class="sorter" data-sort="string">Exercise</th>
        <th class="sorter" data-sort="float">Weight</th>
        <th class="sorter" data-sort="int">Reps</th>
        <th class="sorter" data-sort="float">Est 1RM</th>
    </tr>
</thead>
    <tbody>
    <?php
    		foreach ($value as $skey => $svalue) {
    ?>

    <tr>
        <td>
			<?php
				echo $svalue["FirstName"]." ".$svalue["LastName"];
			?>
        </td>
        <td>
			<?php
				echo $svalue["ExerciseName"];
			?>
        </td>
        <td>
			<?php
				echo $svalue["testWeight"];
			?>
        </td>
        <td>
			<?php
				echo $svalue["Reps"];
			?>
        </td>
        <td>
			<?php
				echo $svalue["EST1RM"];
			?>
        </td>
    </tr>

    <?php
    	}
    }
    ?>
    </tbody>
</table>
