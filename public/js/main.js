Cufon('h2, .locatie label, legend', {hover:'true'});

$(function(){
	$("a.login").click(function(){
		$(".login-dropdown").fadeIn();
		$(".login-dropdown .email").focus();
		return false;
	})
	
	$(".login-dropdown form").submit(function(){
		if ($(".login-dropdown .email").attr("value") != "" && $(".login-dropdown .password").attr("value") != "") {
			$.post(baseUrl + '/user/login-ajax', $(this).serialize(), function(resp){
				if (resp == 0) {
					$(".login-dropdown .message").text("Login failed. Please insert coin and try again.");
				} else {
					window.location.reload();
				}
			});
		} else {
			$(".login-dropdown .message").text("Email and password can't be empty.")
		}
		
		return false;
	})
})