<?php

	$selectedTest = $System->GetFitnessTestSystem()->GetPreviousFitnessTestData($_GET['id']);

?>
<style>
    
    tr:target {
        background-color: hsla(50, 100%, 80%, 1);
    }

</style>
<h2>Previous Test Data For <?php echo date("d/m/Y",strtotime($selectedTest["testDate"])); ?></h2>

    <?php

    	foreach ($selectedTest["data"] as $key => $value) {
    ?>
    <table id="test-table">
    <tr>
        <th colspan="6" class="table-title"><?php echo $key; ?></th>
    </tr>

    <tr>
        <th class="sorter" data-sort="string">Player</th>
        <th class="sorter" data-sort="string">Exercise</th>
        <th class="sorter" data-sort="float">Weight</th>
        <th class="sorter" data-sort="int">Reps</th>
        <th class="sorter" data-sort="float">Est 1RM</th>
        <th>&nbsp;</th>
    </tr>

    <?php
    		foreach ($value as $skey => $svalue) {
    ?>
    
    <tr id="test-row-<?php echo $svalue["playerTestID"]; ?>">
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
        <td>
            <a href="tests.php?a=edit&amp;m=single&amp;tid=<?php echo $svalue["playerTestID"]; ?>">Edit</a>
        </td>
    </tr>

    <?php
    	}
    ?>

    </table>
    <?php
    }
    ?>

