you are viewing a test :V

<pre>
<?php

	$selectedTest = $System->GetFitnessTestSystem()->GetPreviousFitnessTestData($_GET['id']);

?>
</pre>

<table>
    <tr>
        <th colspan="5" class="table-title">Previous Fitness Test Data For <?php echo date("d/m/Y",strtotime($selectedTest["testDate"])); ?></th>
    </tr>
    <?php

    	foreach ($selectedTest["data"] as $key => $value) {
    ?>
    <tr>
        <th colspan="5" class="table-title"><?php echo $key; ?></th>
    </tr>
    <tr>
        <th>Player</th>
        <th>Exercise</th>
        <th>Weight</th>
        <th>Reps</th>
        <th>Est 1RM</th>
    </tr>
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
</table>
