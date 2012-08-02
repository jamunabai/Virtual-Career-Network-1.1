<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
/*
 * google maps for the zip code in the M1-A2 prashanth
 */
?>

<div id="step-1-actvity-2-sidebar-content">

<div id="vcn-gs-map-canvas">
</div>
</div>
<script type="text/javascript"> 
  
	var map;
    var geocoder;
	var mapControl;	

	handleAction(null, true);
	
	function addLangLat(results, status){

		if (!map) { initializeMap(); }

		if (status == google.maps.GeocoderStatus.OK) {
	        map.setCenter(results[0].geometry.location);
	        map.setZoom(7);
	        var marker = new google.maps.Marker({
	            map: map, 
	            position: results[0].geometry.location
	        });
		}
	}
	
	function getCountry(zipcode){  
		$('#job_listing').show();
		displayJobPoints(document.getElementById('job-locations').innerHTML);
	}

	function initializeMap() {
		var options = {
				zoom: 3,
				center: new google.maps.LatLng(39.1, -98.8),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		map = new google.maps.Map(document.getElementById('vcn-gs-map-canvas'), options);
		geocoder = new google.maps.Geocoder();
	}
    function displayJobPoints(address_string) {
		initializeMap();

		if (address_string && address_string != 'undefined' && address_string.length > 0) {
			address_string = address_string + document.getElementById('ziptext').value;
			var address_array =  address_string.split("#");
	   	    
			for (var i = 0; i < address_array.length; i++) { 
				geocoder.geocode( { 'address': address_array[i]}, addLangLat);
			}	
		}
	}
	 
    </script>
