(function(){


	document.getElementById("login-action").addEventListener("click",ClientLogin);

	function ClientLogin(e){

		e.preventDefault()

		var formData = {
			'username' : $('input[name=username]').val(),
			'password' : $('input[name=password]').val(),
			'method'   : "json"
		};

		$(document).ajaxStart(function() {
			$( "#system-thinking-indicator" ).fadeIn(300);
		});
		$("#error-message").hide();

		$.ajax({
			url: "sys/exec/doLogin.php",
			context: document.body,
			type : "POST",
			data : formData,
			success : function(){
				$( "#system-thinking-indicator" ).fadeOut(300);
			}
		}).done(function(data){
			$("#error-message").delay(300).fadeIn(300);
			if(!data.error){
				window.location = "index.php";
				return;			
			}
			if(data.error){
				$("#error-message").html("Error: "+data.error);
				return;
			}
		}).fail(function(){
			$("#error-message").delay(300).fadeIn(300);
			$("#error-message").html("System Error");
		});

	}

})();