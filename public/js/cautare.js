$(function() {
	$('#searchInput').click(function(){
		if ( $(this).attr("value") == $(this).attr("title")) {
			$(this).attr("value","");	
		}
	})
	
	$('#searchInput').blur(function(){
		if ( $(this).attr("value").trim() == "" ) {
			$(this).attr("value",$(this).attr("title"));	
		}
	})
	
	$('#searchForm').submit(function() {
		searchInput = $('#searchInput')
		if ( searchInput.attr("value") == searchInput.attr("title" ) ||  searchInput.attr("value") =="") {
			$("#searchForm .message").css("display", "block")
			setTimeout(function() {
				$("#searchForm .message").fadeOut("slow");
			}, 1000);
			
			$("#searchInput").attr("value", "").focus();
			return false;
		}
	})
});
