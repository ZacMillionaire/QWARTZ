<h3>Create New Test</h3>

<form action="sys/exec/submit_test_results.php" method="POST">

	<input type="text" name="testDate" placeholder="Testing Date" />

	<button id="add-row">
		Add new row
	</button>

	<button id="add-category">
		Add new category
	</button>

	<div id="table-container">

		<div id="new-test-table" data-template-table data-category-set="default">
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">
					Category Name
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell" colspan="5">
					<input style="width: 100%" type="text" name="categoryName[default]" placeholder="Category Name" data-category-set="default" />
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">Player</div>
				<div class="test-fauxtable-header">Exercise</div>
				<div class="test-fauxtable-header">Weight</div>
				<div class="test-fauxtable-header">reps</div>
				<div class="test-fauxtable-header">Estimated 1RM</div>
			</div>
			<div class="test-fauxtable-tablerow" data-template-row>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="player[default][]" placeholder="Player Search" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<select name="exercise[default][]" id="exercise-dropdown" data-category-set="default">
						<option value="0">Thing 1</option>
						<option value="1">Thing 2</option>
						<option value="2">Thing 3</option>
					</select>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="weight[default][]" placeholder="Weight" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="reps[default][]" placeholder="reps" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="est1rm[default][]" placeholder="Estimated 1RM" data-category-set="default"/>
				</div>
			</div>
		</div>

	</div>

	<button type="submit">Submit</button>

</form>

<script type="text/javascript">
	
	var testTable = document.getElementById("new-test-table");

	document.getElementById("add-row").addEventListener("click",addTableRow);
	document.getElementById("add-category").addEventListener("click",addTableCategory);

	document.querySelectorAll("[data-category-set='default']")[0].addEventListener("keydown",categoryChange);
	
	function updateInputNames(oldValue, newValue){

		var elements = document.querySelectorAll("[data-category-set='"+oldValue+"']");

		var re = /(.*?)\[(.*?)\](\[\])?/;

		for(var i = 0; i < elements.length; i++){

			var str = elements[i].name;
			str = str.replace(re,"$1["+newValue+"]$3");

			elements[i].name = str;
			elements[i].attributes["data-category-set"].value = newValue;
			console.log(elements[i]);

		}

	}

	function categoryChange(e){

		var self = e.target;

		setTimeout(function(){

			var oldValue = self.attributes["data-category-set"].value;
			var newValue = self.value;

			document.querySelectorAll("[data-template-table]")[0].attributes["data-category-set"].value = newValue;

			updateInputNames(oldValue,newValue);

		},250);

	}

	function addTableRow(e){

		// Prevents the form from submitting
		e.preventDefault();


		// Get the template row as defined by its data attribute
		var newRow = testTable.querySelectorAll('[data-template-row]')[0].cloneNode(true);

		// loop over all children and reset their values to null
		for(var i = 0; i < newRow.children.length; i++){
			newRow.children[i].children[0].value = null;
		}

		// append the fresh row to the table
		testTable.appendChild(newRow);
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

		var tableClone = testTable.cloneNode(true);

		console.log(tableClone);

		var tableInputs = tableClone.querySelectorAll(".test-fauxtable-tablecell");
		var oldTableIdentifier = tableClone.attributes["data-category-set"].value;
		var newTableIdentifier = randomString(20);

		tableClone.attributes["data-category-set"].value = newTableIdentifier;

		for(var i = 0; i < tableInputs.length; i++){

			var inputSelf = tableInputs[i].children[0];

			if(!inputSelf.name.match(/(player)/)){
				inputSelf.value = null;
			}

			inputSelf.attributes["data-category-set"].value = newTableIdentifier;
			var re = /(.*?)\[(.*?)\](\[\])?/;
			inputSelf.name = inputSelf.name.replace(re,"$1["+newTableIdentifier+"]$3");
		}

		document.getElementById("table-container").appendChild(tableClone);

		document.querySelectorAll("[data-category-set='"+newTableIdentifier+"']")[0].addEventListener("keydown",categoryChange);

	}

</script>