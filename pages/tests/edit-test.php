<?php

    $TestSystem = $System->GetFitnessTestSystem();
	$selectedTest = $TestSystem->GetSpecificFitnessTestData($_GET['tid']);
    $players = $System->GetDataCollectionSystem()->GetPlayerList();
    $exercises = $System->GetDataCollectionSystem()->GetExerciseList();

?>
<style>
    
    tr:target {
        background-color: hsla(50, 100%, 80%, 1);
    }

</style>
    <h2>
        Editing Test Data For <?php echo $selectedTest["FirstName"]." ".$selectedTest["LastName"]; ?>
         in <?php echo $selectedTest["ExerciseCategoryName"]; ?>
         on <?php echo date("d/m/Y",strtotime($selectedTest["DateEntered"])); ?>
    </h2>
<?php

    $lockData = $System->GetDataLockSystem()->GetTestDataLockStatus($_GET['tid']);
    $lockDuration = $System->GetDataCollectionSystem()->GetReadOnlyDuration();
    $rowUnlocks = strtotime("+".$lockDuration." minutes", strtotime($lockData["lastEditDateTime"]));

    // hack to make PHP use the right time. Don't even ask.
    $literallyRightNow =  strtotime(date("g:i:s",time()));

    $editOwner = ($userData["userID"] == $lockData["lastEditOwner"]);
    $pageReadOnly =($literallyRightNow < $rowUnlocks);


    if($pageReadOnly){

        $timeTillUnlock = number_format(($rowUnlocks - $literallyRightNow)/60,0);

        include "pages/fragments/lockout.php";

    }

?>

    <div id="table-container">
        <form action="sys/exec/update-test-data.php" method="POST">

            <input type="hidden" name="categoryName[<?php echo $selectedTest["ExerciseCategoryName"]; ?>]" value="<?php echo $selectedTest["ExerciseCategoryName"]; ?>">
            <input type="hidden" name="testDate" value="<?php echo $selectedTest["DateEntered"]; ?>">
            <input type="hidden" name="testID" value="<?php echo $_GET["tid"]; ?>">
            <input type="hidden" name="groupID" value="<?php echo $selectedTest["fitnessTestGroupID"]; ?>">

            <table>
                <tr>
                    <th>Player</th>
                    <th>Exercise</th>
                    <th>Weight</th>
                    <th>reps</th>
                    <th>Estimated 1RM</th>
                </tr>
                <tr data-input-index="0">
                    <td>
                        <select
                            style="width:100%;"
                            name="players[<?php echo $selectedTest["ExerciseCategoryName"]; ?>][]"
                            data-category-set="<?php echo $selectedTest["ExerciseCategoryName"]; ?>"
                            id="player-name-entry"
                            <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>
                        >
                            <option value=""> --- Select Player --- </option>
                            <?php
                            
                                foreach ($players as $key => $value) {

                                    if($value["PlayerID"] == $selectedTest["PlayerID"]){
                                        printf(
                                            "<option value=\"%s\" selected=\"selected\">%s</option>",
                                            $value["PlayerID"],
                                            $value["FirstName"]." ".$value["LastName"]
                                        );
                                    } else {
                                        printf(
                                            "<option value=\"%s\">%s</option>",
                                            $value["PlayerID"],
                                            $value["FirstName"]." ".$value["LastName"]
                                        );
                                    }

                                }

                            ?>
                        </select>
                    </td>
                    <td>
                        <select
                            style="width:100%"
                            name="exercise[<?php echo $selectedTest["ExerciseCategoryName"]; ?>][]"
                            id="exercise-dropdown"
                            data-category-set="<?php echo $selectedTest["ExerciseCategoryName"]; ?>"
                            <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>
                        >
                            <option value=""> --- Select Exercise --- </option>
                            <?php
                            
                                foreach ($exercises as $key => $value) {

                                    if($value["ExerciseID"] == $selectedTest["ExerciseID"]){
                                        printf(
                                            "<option value=\"%s\" selected>%s</option>",
                                            $value["ExerciseID"],
                                            $value["ExerciseName"]
                                        );
                                    } else {
                                        printf(
                                            "<option value=\"%s\">%s</option>",
                                            $value["ExerciseID"],
                                            $value["ExerciseName"]
                                        );
                                    }

                                }

                            ?>
                        </select>
                    </td>
                    <td>
                        <input
                            style="width:100%"
                            type="text"
                            name="weight[<?php echo $selectedTest["ExerciseCategoryName"]; ?>][]"
                            value="<?php echo $selectedTest["testWeight"]; ?>"
                            id="weight-input"
                            placeholder="Weight"
                            data-category-set="<?php echo $selectedTest["ExerciseCategoryName"]; ?>"
                            <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>
                        />
                    </td>
                    <td>
                        <input
                            style="width:100%"
                            type="number"
                            value="<?php echo $selectedTest["Reps"]; ?>"
                            min="1"
                            max="10"
                            step="1"
                            name="reps[<?php echo $selectedTest["ExerciseCategoryName"]; ?>][]"
                            id="reps-input"
                            placeholder="reps"
                            data-category-set="<?php echo $selectedTest["ExerciseCategoryName"]; ?>"
                            required
                            <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>
                        />
                    </td>
                    <td>
                        <input
                            style="width:100%"
                            type="text"
                            value="<?php echo $selectedTest["EST1RM"]; ?>"
                            name="est1rm[<?php echo $selectedTest["ExerciseCategoryName"]; ?>][]"
                            id="est-1rm"
                            placeholder="Estimated 1RM"
                            data-category-set="<?php echo $selectedTest["ExerciseCategoryName"]; ?>"
                            <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <button type="submit" class="button" <?php echo ($pageReadOnly && !$editOwner) ? "disabled" : ""; ?>><span aria-hidden="true" class="icon-checkmark"></span>Update</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</form>

<script src="js/fitnessTest.js"></script>