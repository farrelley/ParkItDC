<?php /**/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>About the project</title>
	<link rel="stylesheet" href="stylesheets/iphone.css" />
	<script src="http://prod.pointabout.com/static/javascript/mobile_interface.js"></script>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAl_Aitbh_FmAMmvuNExykuhQJPoRzckwdVZ_VnTpDeZYkiJkVRBQl20-cmo1GecqU4VGJbwSjN-7I1A" type="text/javascript"></script>
	<!-- localhost Key ABQIAAAAl_Aitbh_FmAMmvuNExykuhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTA4srHKSr60kdCXvaYTS3obGYSHQ -->
	<script src="js/Clusterer2.js" type="text/javascript"></script>

<script type="text/javascript">
 var clusterer;

	var meterIcon = new GIcon();
    meterIcon.image = "http://www.parkitdc.com/media/images/meter.png";
    meterIcon.iconSize = new GSize(20, 36);
    meterIcon.iconAnchor = new GPoint(10, 10);
    meterIcon.shadowSize = new GSize(0, 0);
    meterIcon.infoWindowAnchor = new GPoint(5, 5);
    
   	var carIcon = new GIcon();
    carIcon.image = "images/Park_it_Dc/icons/car.png";
    carIcon.iconSize = new GSize(25, 19);
    carIcon.iconAnchor = new GPoint(10, 10);
    carIcon.shadowSize = new GSize(0, 0);
    carIcon.infoWindowAnchor = new GPoint(5, 5);
    
    var greenIcon = new GIcon();
    greenIcon.image = "images/Park_it_Dc/green_15.png";
    greenIcon.iconSize = new GSize(10, 10);
    greenIcon.iconAnchor = new GPoint(5, 5);
    greenIcon.shadowSize = new GSize(0, 0);
    greenIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsGreen = { icon:greenIcon };

    var redIcon = new GIcon();
    redIcon.image = "images/Park_it_Dc/red_15.png";
    redIcon.iconSize = new GSize(10, 10);
    redIcon.iconAnchor = new GPoint(5, 5);
    redIcon.shadowSize = new GSize(0, 0);
    redIcon.infoWindowAnchor = new GPoint(5, 5);
	markerOptionsRed = { icon:redIcon };
	
	var garageIcon = new GIcon();
    garageIcon.image = "http://www.parkitdc.com/media/images/parking.gif";
    garageIcon.iconSize = new GSize(20, 20);
    garageIcon.iconAnchor = new GPoint(10, 10);
    garageIcon.shadowSize = new GSize(0, 0);
    garageIcon.infoWindowAnchor = new GPoint(10, 10);
	markerOptionsGarage = { icon:garageIcon };
  
    var yellowIcon = new GIcon();
    yellowIcon.image = "http://www.parkitdc.com/media/images/yellow_15.png";
    yellowIcon.iconSize = new GSize(10, 10);
    yellowIcon.iconAnchor = new GPoint(5, 5);
    yellowIcon.shadowSize = new GSize(0, 0);
    yellowIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsYellow = { icon:yellowIcon };



    function load() {
    	Device.available = true;
		Device.Location.init();
      	initGap();
    }   
    
    initGap = function() {
    	Device.Location.callback = updateLocation; 
      }
 
     updateLocation = function(lat,lon) {
   	//lat = '37.332307';
     	//lon = '-122.030768';
//37.332307,-122.030768       
	loadMap(lat,lon);
        document.getElementById('lat').innerHTML = lat;
        document.getElementById('lon').innerHTML = lon;
     }
     
	function loadMap(Latitude,Longitude) {
  		if (GBrowserIsCompatible()) {
        	var map = new GMap2(document.getElementById("map"));
        	map.setCenter(new GLatLng(Latitude,Longitude), 18);
        	map.addControl(new GSmallMapControl());
		clusterer = new Clusterer(map);
 		geocoder = new GClientGeocoder();

        	clusterer.SetIcon(meterIcon);

        
        	//map point YOU ARE HERE
        	var point = new GLatLng(Latitude,Longitude);
        	geocoder.getLocations(point, showAddress);

        	map.addOverlay(new GMarker(point, carIcon));
        	MapMeters(Latitude,Longitude);
      	}
	}
	
	function showAddress(response) {
  		//if (!response || response.Status.code != 200) {
    		//	alert("Error Code:" + response.Status.code);
    		//	window.location = 'index.html';
  		//} else {
    			place = response.Placemark[0];
        		var address = place.address;
        		var inDC = address.indexOf('DC');
        		if(inDC == -1) {
        			alert('Park It DC only works for Washington, DC Locations!');
        			window.location = 'index.html';
        		}
  		//}
	}
	
	function MapMeters(lat, lng) {
		var searchUrl = 'http://www.parkitdc.com/iPhone//parkingmeters.php?lat=' + lat + '&lng=' + lng + '&id=3';
    		
		GDownloadUrl(searchUrl, function(data) {
			var xml = GXml.parse(data);
    	   	var markers = xml.documentElement.getElementsByTagName('marker');
       		var bounds = new GLatLngBounds();
    	   	for (var i = 0; i < markers.length; i++) {
    	     	var ICON = markers[i].getAttribute('ICON');
    	     	var point = new GLatLng(parseFloat(markers[i].getAttribute('LATITUDE')),
										parseFloat(markers[i].getAttribute('LONGITUDE')));
					
			if(ICON == 'R') {
            		var color = markerOptionsRed;
        		}
        		if(ICON == 'G') {
            		var color = markerOptionsGreen;
        		}
        		if(ICON == 'Y') {
            		var color = markerOptionsYellow;
				}
				
				var marker = new GMarker(point, color);
				clusterer.AddMarker(marker, 'df');
				
				
       		}
		});
	}
	
	
    </script>
</head>

<body onload="load()" onunload="GUnload()">

<div style="margin-top:5px; text-align:center;"><img src="images/Park_it_Dc/Park_It_DC.gif" style="margin-right:10px;" /></div>
<div id="map" class="test" style="width:300px;height:325px;"></div>
<p style="padding:3px 0px; margin:0px;">
	<img src="http://www.parkitdc.com/media/images/green_15.png"> Free <img src="http://www.parkitdc.com/media/images/red_15.png"> Pay <img 
src="http://www.parkitdc.com/media/images/yellow_15.png"> Free < 1hr <img src="images/Park_it_Dc/icons/car.png"> Location</p>
<ul class="individual">
	<li><a href="gps.php">Refresh</a></li>
	<li><a href="index.html">Back</a></li>	
</ul>
</body>
</html>
