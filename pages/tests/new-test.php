<h3>Create New Test</h3>

<form action="sys/exec/submit_test_results.php" method="POST">

	<input type="date" id="date-picker" name="testDate" placeholder="Testing Date" required/>

	<button id="add-row">
		Add Player
	</button>

	<button id="add-category">
		Add Category
	</button>

	<div id="table-container">

		<div class="test-fauxtable" data-template-table data-category-set="default">
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">
					New Category Name
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell" colspan="5">
					<input style="width: 100%" type="text" id="category-input" name="categoryName[default]" placeholder="Category Name" data-category-set="default" required/>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">Player</div>
				<div class="test-fauxtable-header">Exercise</div>
				<div class="test-fauxtable-header">Weight</div>
				<div class="test-fauxtable-header">reps</div>
				<div class="test-fauxtable-header">Estimated 1RM</div>
			</div>
		<?php

			$players = $System->GetDataCollectionSystem()->GetPlayerList();

			$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

			foreach ($players as $gkey => $gvalue) {

				?>
			<div class="test-fauxtable-tablerow" data-template-row>
				<div class="test-fauxtable-tablecell">
					<!-- <input type="text" id="player-name-entry" data-input-index="0" name="player[default][]" placeholder="Player Search" data-category-set="default" required/> -->
					<select name="players[default][]" data-input-index="<?php echo $gkey; ?>"  data-category-set="default" id="player-name-entry">
						<option value=""> --- Ignore this row --- </option>
						<?php
						
							foreach ($players as $key => $value) {

								if($key == $gkey){
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
				</div>
				<div class="test-fauxtable-tablecell">
					<select name="exercise[default][]" data-input-index="<?php echo $gkey; ?>" id="exercise-dropdown" data-category-set="default">
						<?php
						
							foreach ($exercises as $ekey => $evalue) {

								printf(
									"<option value=\"%s\">%s</option>",
									$evalue["ExerciseID"],
									$evalue["ExerciseName"]
								);

							}

						?>
					</select>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="weight[default][]" id="weight-input" data-input-index="<?php echo $gkey; ?>" placeholder="Weight" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="number" value="1" min="1" max="10" step="1" name="reps[default][]" data-input-index="<?php echo $gkey; ?>" id="reps-input" placeholder="reps" data-category-set="default" required/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" value="1" name="est1rm[default][]" data-input-index="<?php echo $gkey; ?>" id="est1rm" placeholder="Estimated 1RM" data-category-set="default"/>
				</div>
			</div>
		<?php
			}
			?>
		</div>

	</div>

	<button type="submit">Submit</button>

</form>

<script type="text/javascript">
	
document.addEventListener("DOMContentLoaded", function(event) {

	var playerJSON;

	$("#date-picker").datepicker();
	
	$.get("data/player_data.php", function(data){

		playerJSON = data;

		console.log(playerJSON);

	});

	var typingEvent;
	var inputIndex = <?php echo count($players); ?>
	
	function updateInputNames(parentElem, oldValue, newValue){

		var elements = parentElem.querySelectorAll("[data-category-set='"+oldValue+"']");

		var re = /(.*?)\[(.*?)\](\[\])?/;

		for(var i = 0; i < elements.length; i++){

			var str = elements[i].name;
			str = str.replace(re,"$1["+newValue+"]$3");

			elements[i].name = str;
			elements[i].attributes["data-category-set"].value = newValue;
			//console.log(elements[i]);

		}

	}

	function update1RM(e) {

		var lookUpTable = {
			1 : 1,
			2 : 1.05,
			3 : 1.08,
			4 : 1.12,
			5 : 1.16,
			6 : 1.2,
			7 : 1.23,
			8 : 1.26,
			9 : 1.29,
			10 : 1.33
		};

		for(var index in lookUpTable){
			if(e.target.value === index){
				var inputIndexID = e.target.attributes["data-input-index"].value;
				var categoryID = e.target.attributes["data-category-set"].value;
				var domToAffect = document.querySelectorAll("input#est1rm[data-input-index='"+inputIndexID+"'][data-category-set='"+categoryID+"']")[0];
				domToAffect.value = lookUpTable[index];
			}
		}

	}

	function categoryChange(e){

		var self = e.target;
		var parentElem = document.querySelectorAll("div[data-category-set='"+self.attributes["data-category-set"].value+"']")[0];

		clearTimeout(typingEvent);
		typingEvent = setTimeout(function(){

			var oldValue = parentElem.attributes["data-category-set"].value;
			var newValue = self.value;

			parentElem.attributes["data-category-set"].value = newValue;

			updateInputNames(parentElem, oldValue,newValue);

		},250);

	}

	function addPlayerName(e){

		var playerInputIndex = parseInt(e.target.attributes["data-input-index"].value);

		var inputsToAffect = document.querySelectorAll("#player-name-entry[data-input-index='"+playerInputIndex+"']");

		for (var i = 0; i < inputsToAffect.length; i++) {
			inputsToAffect[i].value = e.target.value;
		};

	}

	function addPlayerRow(e){

		// Prevents the form from submitting
		e.preventDefault();

		var templateRow = document.querySelectorAll("[data-template-row]")[0].cloneNode(true);
		var tablesInUse = document.querySelectorAll("div[data-category-set]");
		var re = /(.*?)\[(.*?)\](\[\])?/;

		// loop over all children and reset their values to null
		for(var i = 0; i < templateRow.children.length; i++){
			if(templateRow.children[i].children[0].attributes["id"]){
				if(
					templateRow.children[i].children[0].attributes["id"].value == "reps-input" ||
					templateRow.children[i].children[0].attributes["id"].value == "est1rm"
				  ) {
					templateRow.children[i].children[0].value = 1;				
				} else {
					templateRow.children[i].children[0].value = null;
				}			

			}
		}

		// append the fresh row to all tables
		for(var i = 0; i < tablesInUse.length; i++){

			var appendRow = templateRow.cloneNode(true);

			// [screams internally]
			for(var j = 0; j < appendRow.querySelectorAll("input, select").length; j++){
				
				//console.log(appendRow.querySelectorAll("input, select")[j].name)
				appendRow.querySelectorAll("input, select")[j].attributes["data-category-set"].value = tablesInUse[i].attributes["data-category-set"].value;
				appendRow.querySelectorAll("input, select")[j].name = appendRow.querySelectorAll("input, select")[j].name.replace(re,"$1["+tablesInUse[i].attributes["data-category-set"].value+"]$3");
				appendRow.querySelectorAll("input, select")[j].attributes["data-input-index"].value = inputIndex;
			}

			tablesInUse[i].appendChild(appendRow);
		}

		inputIndex += 1;

		for (var i = 0; i < document.querySelectorAll("#player-name-entry, #reps-input").length; i++) {
			document.querySelectorAll("#player-name-entry")[i].addEventListener("change",addPlayerName);
			document.querySelectorAll("#reps-input")[i].addEventListener("change",update1RM);
		};


	}

	function addTableCategory(e) {

		function randomString(len){
			var string = "";
            var letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890-_";

            for (var i = 0; i < len; i++) {

                var letter = Math.floor(Math.random() * (letterDict.length));
                string += letterDict[letter];

            }

            return string;
		}

		e.preventDefault();

		var tableClone = document.querySelectorAll("[data-template-table]")[0].cloneNode(true);


		var tableInputs = tableClone.querySelectorAll(".test-fauxtable-tablecell");
		var oldTableIdentifier = tableClone.attributes["data-category-set"].value;
		var newTableIdentifier = randomString(20);

		tableClone.attributes["data-category-set"].value = newTableIdentifier;

		for(var i = 0; i < tableInputs.length; i++){

			var inputSelf = tableInputs[i].children[0];
			//console.log(inputSelf.attributes["id"].value == "player-name-entry");

			if(inputSelf.attributes["id"]){

				if(
					inputSelf.attributes["id"].value == "reps-input" ||
					inputSelf.attributes["id"].value == "est1rm"
				  ) {
					inputSelf.value = 1;				
				} else if(inputSelf.attributes["id"].value != "player-name-entry"){

					// fuck you clonenode for not being able to copy selectedIndex
					//inputSelf.disabled = true;
					inputSelf.value = null;
				}			

			}


			inputSelf.attributes["data-category-set"].value = newTableIdentifier;
			var re = /(.*?)\[(.*?)\](\[\])?/;
			inputSelf.name = inputSelf.name.replace(re,"$1["+newTableIdentifier+"]$3");
		}

		document.getElementById("table-container").appendChild(tableClone);

		document.querySelectorAll("#category-input[data-category-set='"+newTableIdentifier+"']")[0].addEventListener("keydown",categoryChange);

		for (var i = 0; i < document.querySelectorAll("#player-name-entry, #reps-input").length; i++) {
			document.querySelectorAll("#player-name-entry")[i].addEventListener("change",addPlayerName);
			document.querySelectorAll("#reps-input")[i].addEventListener("change",update1RM);
		};
		

	}

	document.getElementById("add-row").addEventListener("click",addPlayerRow);
	document.getElementById("add-category").addEventListener("click",addTableCategory);

	for (var i = 0; i < document.querySelectorAll("#player-name-entry").length; i++) {
		document.querySelectorAll("#player-name-entry")[i].addEventListener("change",addPlayerName);
	};
	for (var i = 0; i < document.querySelectorAll("#reps-input").length; i++) {
		document.querySelectorAll("#reps-input")[i].addEventListener("change",update1RM);
	};

	document.querySelectorAll("input#category-input")[0].addEventListener("keyup",categoryChange);

});
</script>