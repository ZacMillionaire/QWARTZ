'use strict'

document.addEventListener("DOMContentLoaded", function(event) {


	var playerID = $("select[id=player-name-selection]")[0].selectedIndex;
	
	function bindButtonListeners() {

		// $("button[id=remove-player]").each(function(){
		// 	$(this).on("click",removePlayer);

		// });

		$("select[id=player-name-selection]").each(function(){
			$(this).on("change",updatePlayerData);
		});
		$("select[id=exercise-dropdown]").each(function(){
			$(this).on("change",fetchPlayersRecentData);
		});


		// $("input[id=reps-input]").each(function(){

		// 	$(this).on("change keyup",update1RM);

		// });
		// $("input[id=weight-input]").each(function(){

		// 	$(this).on("change keyup",update1RM);

		// });

		// $("#category-input").each(function(){
		// 	$(this).on("keyup",updateCategoryName);
		// });

		// // These inputs don't really require bindings to mirror or update something,
		// // but they're here to save typing later if the need arises
		// /*
		
		// $("select[id=exercise-dropdown]").each(function(){
		// 	// no event
		// });


		// $("input[id=est-1rm]").each(function(){

		// });
		// */

	}

	$("button[id=add-exercise]").on("click",duplicateExerciseTable);

	bindButtonListeners();
	initTable();

	function initTable() {

		function randomString(len){
			var string = "";
	        var letterDict = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890-_";

	        for (var i = 0; i < len; i++) {

	            var letter = Math.floor(Math.random() * (letterDict.length));
	            string += letterDict[letter];

	        }

	        return string;
		}

		var tableToClone = $("table#exercise-table").last();
		var categoryID = randomString(8);

		tableToClone.find("[data-category-set]").each(function(){

			this.attributes["data-category-set"].value = categoryID;

			if(this.name != undefined) {

				var re = /(.*?)\[(.*?)\](\[\])?/;
				var str = this.name;
				str = str.replace(re,"$1["+categoryID+"]$3");
				this.name = str;

			}

		});

	}

	function updatePlayerData(e) {

		e.preventDefault();

		if(e.target.selectedIndex > 0) {

			playerID = e.target.selectedIndex;

			$("table").each(function(){

				$(this).find("input, select, textarea, button").each(function(){

					this.disabled = false;

				});

			});

			$("#submit-template-button")[0].disabled = false;

			$("#table-container #exercise-table").each(function(){
				
				var thisCategoryID = $(this).find("#exercise-dropdown")[0].attributes["data-category-set"].value;
				var thisExerciseID = $(this).find("#exercise-dropdown")[0].selectedIndex;

				var repsInput = $("#reps-input[data-category-set=\""+thisCategoryID+"\"]")[0];
				var input1RM = $("#oneRM-input[data-category-set=\""+thisCategoryID+"\"]")[0];
				var sessionTarget = $("#target-session-input[data-category-set=\""+thisCategoryID+"\"]")[0];

				$.get(
					"data/player_data.php",
					{
						"a" : "playerLatestTestData",
						"exerciseID" : thisExerciseID,
						"playerID" : playerID
					},
					function(data){

						if(data[0]){
							repsInput.value = data[0].Reps;
							sessionTarget.value = data[0].Reps;
							input1RM.value = data[0].EST1RM;		
						} else {
							repsInput.value = null;
							sessionTarget.value = null;
							input1RM.value = null;		
						}

					}
				);
				
			});

		} else {

			$("table").each(function(){

				$(this).find("input, select, textarea, button").each(function(){

					if(this.id != "player-name-selection") {
						this.disabled = true;
					}

				});

			});

			$("#submit-template-button")[0].disabled = true;

		}



	}


	function duplicateExerciseTable(e) {

		e.preventDefault();

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

		var tableToClone = $("table#exercise-table").last();
		var clonedTable = $(tableToClone[0]).clone(true);
		var categoryID = randomString(8);

		clonedTable.find("[data-category-set]").each(function(){

			this.attributes["data-category-set"].value = categoryID;

			if(this.name != undefined) {

				var re = /(.*?)\[(.*?)\](\[\])?/;
				var str = this.name;
				str = str.replace(re,"$1["+categoryID+"]$3");
				this.name = str;

			}

		});

		$(tableToClone).after(clonedTable);

	}


	function fetchPlayersRecentData(e){

		var thisCategoryID = e.target.attributes["data-category-set"].value;

		var repsInput = $("#reps-input[data-category-set=\""+thisCategoryID+"\"]")[0];
		var input1RM = $("#oneRM-input[data-category-set=\""+thisCategoryID+"\"]")[0];
		var sessionTarget = $("#target-session-input[data-category-set=\""+thisCategoryID+"\"]")[0];

		$.get(
			"data/player_data.php",
			{
				"a" : "playerLatestTestData",
				"exerciseID" : e.target.selectedIndex,
				"playerID" : playerID
			},
			function(data){

				if(data[0]){
					repsInput.value = data[0].Reps;
					sessionTarget.value = data[0].Reps;
					input1RM.value = data[0].EST1RM;		
				} else {
					repsInput.value = null;
					sessionTarget.value = null;
					input1RM.value = null;		
				}

			}
		);

	}
});
