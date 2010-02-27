function initialize() {
	if (GBrowserIsCompatible()) {
		var map = new GMap2(document.getElementById("map"));
		map.setCenter(new GLatLng(lat, long), 13);
		map.setUIToDefault();
	}
}

$(function(){
	$(".map-trigger").click(function(){
		$("#map").css('display', 'block');
		initialize();
		return false;
	})
})