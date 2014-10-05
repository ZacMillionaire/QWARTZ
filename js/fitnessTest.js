'use strict'

document.addEventListener("DOMContentLoaded", function(event) {

	var playerJSON;

	$("#date-picker").datepicker();
	
	$.get("data/player_data.php", function(data){

		playerJSON = data;

		console.log(playerJSON);

	});

	var typingEvent;

	function bindButtonListeners() {

		$("button[id=remove-player]").each(function(){
			$(this).on("click",removePlayer);

		});

		$("select[id=player-name-entry]").each(function(){
			$(this).on("change",updatePlayerNames);
		});


		$("input[id=reps-input]").each(function(){

			$(this).on("change keyup",update1RM);

		});
		$("input[id=weight-input]").each(function(){

			$(this).on("change keyup",update1RM);

		});

		$("#category-input").each(function(){
			$(this).on("keyup",updateCategoryName);
		});

		// These inputs don't really require bindings to mirror or update something,
		// but they're here to save typing later if the need arises
		/*
		
		$("select[id=exercise-dropdown]").each(function(){
			// no event
		});


		$("input[id=est-1rm]").each(function(){

		});
		*/

	}

	$("button[id=add-row]").on("click",addPlayerRow);	
	$("button[id=add-category]").on("click",addTestCategory);

	bindButtonListeners();


	function removePlayer(e) {

		e.preventDefault();

		// get the total count of table rows, the index to affect from the button,
		// and the table row to remove
		var numberOfTableRows = $("#table-container table tr[data-input-index]").length;
		var numberOfTables = $("#table-container table").length;

		var rowIndex = this.attributes["data-input-index"].value;
		var rowToAffect = $("tr[data-input-index=\""+rowIndex+"\"]");

		// if the number of rows across all tables is 1, prevent removal
		// in the case that the button didn't get disabled previously
		// and disable it
		if((numberOfTableRows/numberOfTables) == 1){

			this.disabled = true;
			return;

		}

		$(rowToAffect).remove();

		// check again to see if we only have 1 row, if we do, disable the button
		if(($("#table-container table tr[data-input-index]").length / numberOfTables) == 1){

			$("tr[data-input-index]").each(function(){
				$(this).find("#remove-player")[0].disabled = true;
			});

		}

	}


	function addPlayerRow(e){

		// Prevents the form from submitting
		e.preventDefault();

		$("#table-container table").each(function(){

			// get the last row of the table
			var lastRow = $(this).find("tr[data-input-index]").last();

			// re-enable remove player button if disabled
			if(lastRow.find("#remove-player")[0].disabled){
				lastRow.find("#remove-player")[0].disabled = false;
			}

			// Deep clone the row with event bindings
			lastRow = lastRow.clone(true);

			// set default values
			lastRow.find("#player-name-entry")[0].selectedIndex = 0;
			lastRow.find("#exercise-dropdown")[0].selectedIndex = 0;
			lastRow.find("#weight-input")[0].value = 0;
			lastRow.find("#reps-input")[0].value = 1;
			lastRow.find("#est-1rm")[0].value = 1;

			// set index to + 1 on the previous
			var newInputIndex = 1 + parseInt(lastRow[0].attributes["data-input-index"].value);
			lastRow[0].attributes["data-input-index"].value = newInputIndex;
			$(lastRow[0]).find("#remove-player")[0].attributes["data-input-index"].value = newInputIndex;

			console.log($(this).find("tr[data-input-index]").last());

			// append it to the table
			$(this).find("tr[data-input-index]").last().after(lastRow);

		});

	}


	function addTestCategory(e) {

		e.preventDefault();

		// KNOWN BUG (jQuery can eat a dick):
		// using .clone() will not copy selectedIndexes of select inputs for 'performance reasons'.
		// Fuck off you wankers, what a load of shit.
		// 
		// The following function fixes clone so it isn't a piece of shit.
		// 
		// - Scotch, 26-09-2014
		(function (original) {
			jQuery.fn.clone = function () {
				var result = original.apply(this, arguments),
				my_textareas = this.find('textarea').add(this.filter('textarea')),
				result_textareas = result.find('textarea').add(result.filter('textarea')),
				my_selects = this.find('select').add(this.filter('select')),
				result_selects = result.find('select').add(result.filter('select'));
				for (var i = 0, l = my_textareas.length; i < l; ++i) {
					$(result_textareas[i]).val($(my_textareas[i]).val())
				}
				for (var i = 0, l = my_selects.length; i < l; ++i) {
					for (var j = 0, m = my_selects[i].options.length; j < m; ++j) {
						if (my_selects[i].options[j].selected === true) {
							result_selects[i].options[j].selected = true;
						}
					}
				}
				return result;
			};
		}) (jQuery.fn.clone)

		function randomString(len){
			var string = "";
            var letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890-_";

            for (var i = 0; i < len; i++) {

                var letter = Math.floor(Math.random() * (letterDict.length));
                string += letterDict[letter];

            }

            return string;
		}

		var tableClone = $("#table-container table").last().clone(true);
		var categoryID = randomString(8);

		tableClone.find("[data-category-set]").each(function(){

			this.attributes["data-category-set"].value = categoryID;

			if(this.name != undefined) {

				var re = /(.*?)\[(.*?)\](\[\])?/;
				var str = this.name;
				str = str.replace(re,"$1["+categoryID+"]$3");
				this.name = str;

			}

		});

		tableClone.appendTo("#table-container");

		// rebind our listeners
		bindButtonListeners();
	}


	function updateCategoryName(e) {

		var self = $(this)[0];

		clearTimeout(typingEvent);
		typingEvent = setTimeout(function(){

			var categoryToAffect = self.attributes["data-category-set"].value;

			$("[data-category-set=\""+categoryToAffect+"\"]").each(function(){

				this.attributes["data-category-set"].value = self.value;
				
				// sanity check, the table has a data-category value as well, but no name,
				// without this, the script will break
				// 
				// 05/10/2015 Scotch - Not even sure I need this anymore after
				// changing the layout.
				if(this.name != undefined) {

					var re = /(.*?)\[(.*?)\](\[\])?/;
					var str = this.name;
					str = str.replace(re,"$1["+self.value+"]$3");
					this.name = str;

				}

			});

		},250);

	}


	function updatePlayerNames(e){

		e.preventDefault();

		var playerIndex = e.target.selectedIndex;

		var dataIndexToAffect = $(this).parents("tr")[0].attributes["data-input-index"].value;

		var playerSelectionsToAffect = $("#table-container").find("tr[data-input-index=\""+dataIndexToAffect+"\"] #player-name-entry");

		$(playerSelectionsToAffect).each(function(){

			this.selectedIndex = playerIndex;

		})

	}


	function update1RM(e){

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

		var dataSet = this.attributes["data-category-set"].value;

		var dataIndexToAffect = $(this).parents("tr")[0].attributes["data-input-index"].value;
		var inputWeight = $("[data-input-index=\""+dataIndexToAffect+"\"] #weight-input[data-category-set=\""+dataSet+"\"]")[0].value;

		if(!inputWeight || inputWeight == 0) {
			inputWeight = 0;
		}

		var repValue = $("[data-input-index=\""+dataIndexToAffect+"\"] #reps-input[data-category-set=\""+dataSet+"\"]")[0].value;
		var est1rm = inputWeight * lookUpTable[repValue];

		$("[data-input-index=\""+dataIndexToAffect+"\"] #est-1rm[data-category-set=\""+dataSet+"\"]")[0].value = est1rm.toFixed(2);

	}

	
});
