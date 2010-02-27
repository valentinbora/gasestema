$(document).ready(function(){

	$('#searchInput input').click(function(){
		if ( $(this).attr("value")==$(this).attr("title" ) ){
			$(this).attr("value","");	
		}
	})
	$('#searchInput input').blur(function(){
		if ( $(this).attr("value").trim()=="" ){
			$(this).attr("value",$(this).attr("title"));	
		}
	})
	
	$('#searchForm form').submit(function(){
		searchInput = $('#searchInput input')
		if ( searchInput.attr("value") == searchInput.attr("title" ) ||  searchInput.attr("value") =="") {
			alert(searchErrorMessage)
			return false;
		}

	})
	
	
	


});
