/*****************convert the JSON to Array and check the validity of events**************************/
function check_address(){
	initialize();
	
	for(var j=0;j<json_facebook1.data.length;j++){
	/***********************************geocoder******************************************************/
		//alert(json_facebook1.data[j].location + "number:" + j);
		
		if (json_facebook1.data[j].location){
		//alert(j);
			var str="Name: <a href=http://www.facebook.com/event.php?eid=" + json_facebook1.data[j].id.toString() + ">" + 
											json_facebook1.data[j].name + "</a><br>"+"Location: " + 
											json_facebook1.data[j].location + "<br>Start time: " + 
											json_facebook1.data[j].start_time.toLocaleString() + "<br>End time: "
											+ json_facebook1.data[j].end_time.toLocaleString();
			geo(json_facebook1.data[j].location, str, j);
		}
	}
}

function geo(address, str, j){
						geocoder.geocode( {'address': address}, 
							  function(results, status) { 
								if (status == google.maps.GeocoderStatus.OK) {
									//map.setCenter(results[0].geometry.location);
								/**********************Map the events on google map**********************/	
									var marker = new google.maps.Marker({
																	map: map, 
																	position: results[0].geometry.location
																	});
									/**********************Store the information in the maker**********************/
									var infowindow = new google.maps.InfoWindow({ content: str});
									
									google.maps.event.addListener(marker, 'click', function() {
										infowindow.open(map,marker);});
								} else {
									//alert(status + " number=" + j);
								}
							});
}