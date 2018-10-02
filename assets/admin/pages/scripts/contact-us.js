var ContactUs = function () {

    return {
        //main function to initiate the module
        init: function () {
			var map;
			$(document).ready(function(){
			  map = new GMaps({
				div: '#map',
				lat: 41.069192,
				lng: 28.809543
			  });
			   var marker = map.addMarker({
		            lat: 41.069192,
					lng: 28.809543,
		            title: 'Grup Ar-Ge Enerji ve Kontrol Sistemleri',
		            infoWindow: {
		                content: "<b>Grup Ar-Ge Enerji ve Kontrol Sistemleri</b>"
		            }
		        });

			   marker.infoWindow.open(map, marker);
			});
        }
    };

}();