<?php /**/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAl_Aitbh_FmAMmvuNExykuhQJPoRzckwdVZ_VnTpDeZYkiJkVRBQl20-cmo1GecqU4VGJbwSjN-7I1A" type="text/javascript"></script>
<script src="http://www.acme.com/javascript/Clusterer2.jsm" type="text/javascript"></script>
<script type="text/javascript">
    //<![CDATA[
    var map;
    var geocoder;
    var clusterer;

    var meterIcon = new GIcon();
    meterIcon.image = "../media/images/meter.png";
    meterIcon.iconSize = new GSize(20, 36);
    meterIcon.iconAnchor = new GPoint(10, 10);
    meterIcon.shadowSize = new GSize(0, 0);
    meterIcon.infoWindowAnchor = new GPoint(5, 5);
      
    var greenIcon = new GIcon();
    greenIcon.image = "../media/images/green_15.png";
    greenIcon.iconSize = new GSize(10, 10);
    greenIcon.iconAnchor = new GPoint(5, 5);
    greenIcon.shadowSize = new GSize(0, 0);
    greenIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsGreen = { icon:greenIcon };
    
    var garageIcon = new GIcon();
    garageIcon.image = "../media/images/parking.gif";
    garageIcon.iconSize = new GSize(20, 20);
    garageIcon.iconAnchor = new GPoint(10, 10);
    garageIcon.shadowSize = new GSize(0, 0);
    garageIcon.infoWindowAnchor = new GPoint(10, 10);
	markerOptionsGarage = { icon:garageIcon };

    var redIcon = new GIcon();
    redIcon.image = "../media/images/red_15.png";
    redIcon.iconSize = new GSize(10, 10);
    redIcon.iconAnchor = new GPoint(5, 5);
    redIcon.shadowSize = new GSize(0, 0);
    redIcon.infoWindowAnchor = new GPoint(5, 5);
	markerOptionsRed = { icon:redIcon };
  
    var yellowIcon = new GIcon();
    yellowIcon.image = "../media/images/yellow_15.png";
    yellowIcon.iconSize = new GSize(10, 10);
    yellowIcon.iconAnchor = new GPoint(5, 5);
    yellowIcon.shadowSize = new GSize(0, 0);
    yellowIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsYellow = { icon:yellowIcon };


    var blackIcon = new GIcon();
    blackIcon.image = "../media/images/black_15.png";
    blackIcon.iconSize = new GSize(10, 10);
    blackIcon.iconAnchor = new GPoint(5, 5);
    blackIcon.shadowSize = new GSize(0, 0);
    blackIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsBlack = { icon:blackIcon };
    
	function load(type) {
    	if(GBrowserIsCompatible()) {
        	geocoder = new GClientGeocoder();
        	map = new GMap2(document.getElementById('map_canvas'));
			map.enableScrollWheelZoom();
			map.enableDoubleClickZoom();
        	clusterer = new Clusterer(map);
        	clusterer.SetIcon(meterIcon);
        	map.addControl(new GSmallMapControl());
			if(!type)
				map.setCenter(new GLatLng(38.904927,-77.023773), 11);
      	}
    }
    
	//SEarch by location
   	function searchLocations() {
    	var address = document.getElementById('addressInput').value;
     	geocoder.getLatLng(address, function(latlng) {
       		if (!latlng) {
				document.getElementById("Widget-Info").innerHTML = 'Address Not Found';
       		} else {
        	 	searchLocationsNear(latlng, address);
       		}
     	});
   	}


	function searchLocationsNear(center, theAddress) {
		if(theAddress == "iPhone") {
			var radius = ".3";
		} else {
			var radius = document.getElementById('radiusSelect').value;
		}
	  	var searchUrl = '../xml/parkingmeters.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     	GDownloadUrl(searchUrl, function(data) {
       		var xml = GXml.parse(data);
       		
       		var markers = xml.documentElement.getElementsByTagName('marker');
			
       		var bounds = new GLatLngBounds();
       		for (var i = 0; i < markers.length; i++) {  
         		var METERNUM = markers[i].getAttribute('METERNUM');
         		var STREET = markers[i].getAttribute('STREET');
         		var iconColor = markers[i].getAttribute('ICON');
       			var BLOCK = markers[i].getAttribute('BLOCK');
       			var SIDE = markers[i].getAttribute('SIDE');
       			var HOUR_FROM = markers[i].getAttribute('HOUR_FROM');
       			var HOUR_TO = markers[i].getAttribute('HOUR_TO');
       			var DAY_FROM = markers[i].getAttribute('DAY_FROM');
       			var DAY_TO = markers[i].getAttribute('DAY_TO');
       			var LIMIT = markers[i].getAttribute('LIMIT');
       			var RATE = markers[i].getAttribute('RATE');
				var WARD = markers[i].getAttribute('WARD');
       			var COMMENTS = markers[i].getAttribute('COMMENTS');
         		var distance = parseFloat(markers[i].getAttribute('distance'));
         		var point = new GLatLng(parseFloat(markers[i].getAttribute('LATITUDE')),
                                 		parseFloat(markers[i].getAttribute('LONGITUDE')));
                         
                if(iconColor == 'R') {
            		var color = markerOptionsRed;
        			var status = 'Meter Cost Money';
        		}
        		if(iconColor == 'G') {
            		var color = markerOptionsGreen;
        			var status = 'Meter is Free';
        		}
        		if(iconColor == 'Y') {
            		var color = markerOptionsYellow;
        			var status = 'Meter will be Free in > 1 Hour';
				}
				var html = '<table>' +
				'<tr> <td>Status:</td> <td>' + status + '</td> </tr>' +
				'<tr> <td>Meter:</td> <td><a href="http://www.parkitdc.com/index.php/meter/' + METERNUM + '">' + METERNUM + '</a></td> </tr>' +
				'<tr> <td>Address:</td> <td>' + BLOCK + ' ' + STREET + '</td> </tr>' +
				'<tr> <td>Hours:</td> <td>' + HOUR_FROM + ' - ' + HOUR_TO + '</td> </tr>' + 
				'<tr> <td>Days:</td> <td>' + DAY_FROM + ' - ' + DAY_TO + '</td> </tr>' + 
				'<tr> <td>Limit:</td> <td>' + LIMIT + '</td> </tr>' + 
				'<tr> <td>Cost (hr):</td> <td>$' + RATE + '</td> </tr></table>';
				
         		var marker = createMeterMarker(point, html, color, METERNUM);
         		clusterer.AddMarker(marker, METERNUM);
         		bounds.extend(point);
       		}
			
			
			searchCrimeNear(center);
     		addpoly(center);
     		searchParkingGaragesNear(center);
     		
     		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
    	}); 
	}
	
	function searchParkingGaragesNear(center) {
    	var radius = document.getElementById('radiusSelect').value;
     	var searchUrl = '../xml/garageparking.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     	GDownloadUrl(searchUrl, function(data) {
       		var xml = GXml.parse(data);
       		var markers = xml.documentElement.getElementsByTagName('marker');
       		//var bounds = new GLatLngBounds();
       	
       		for (var i = 0; i < markers.length; i++) {
       			var COMPANY = markers[i].getAttribute('COMPANY');
       			var GARAGENUM = markers[i].getAttribute('GARAGENUM');
       			var LOCATION = markers[i].getAttribute('LOCATION');
         		var ICON = markers[i].getAttribute('ICON');
         		var distance = parseFloat(markers[i].getAttribute('distance'));
         		var point = new GLatLng(parseFloat(markers[i].getAttribute('LATITUDE')),
										parseFloat(markers[i].getAttribute('LONGITUDE')));
				
				
				if(COMPANY == "Parking Management, Inc.") {
					var url = "http://locations.pmi-parking.com/LocationDetail.aspx?GarageID=" + GARAGENUM;
				} else {
					var url = "http://ecolonial.com/location.pl?location="+GARAGENUM;
				}
				var GarageInfo = "<table>" +
				"<tr> <td>Company:</td> <td>" + COMPANY + "</td> </tr>" +
				"<tr> <td>Location:</td> <td>" + LOCATION + "</td> </tr>" +				
				"<tr> <td colspan=2><a href='" + url + "' target='_blank'>More info on Garage Number " + GARAGENUM + "</a></td> </tr>"
				"</table>";
				
				var html = '<b>Company: </b>' + COMPANY + '<br /><b>Info: </b> <a href="' + url + '" target="_blank">Garage Information</a>';
         		var marker = createGarageMarker(point, html, GarageInfo, COMPANY);
         		clusterer.AddMarker(marker, COMPANY);
       		}
		});
		
    }
    
	function searchCrimeNear(center) {
		map.clearOverlays();
    	var radius = document.getElementById('radiusSelect').value;
     	var searchUrl = '../xml/crime.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     	GDownloadUrl(searchUrl, function(data) {
       		var xml = GXml.parse(data);
       		var markers = xml.documentElement.getElementsByTagName('marker');
       	
       		for (var i = 0; i < markers.length; i++) {
       			var NAME = markers[i].getAttribute('NAME');
       			var DATE = markers[i].getAttribute('DATE');
       			var SHIFT = markers[i].getAttribute('SHIFT');
       			var WARD = markers[i].getAttribute('WARD');
       			var METHOD = markers[i].getAttribute('METHOD');
         		var LOCATION = markers[i].getAttribute('LOCATION');
       			var NARRATIVE = markers[i].getAttribute('NARRATIVE');
         		var ICON = markers[i].getAttribute('ICON');
         		var distance = parseFloat(markers[i].getAttribute('distance'));
         		var LAT = markers[i].getAttribute('LATITUDE');
         		var LNG = markers[i].getAttribute('LONGITUDE');
         		var point = new GLatLng(parseFloat(markers[i].getAttribute('LATITUDE')),
										parseFloat(markers[i].getAttribute('LONGITUDE')));
				var html = "<table>" +
				"<tr> <td>Crime: </td> <td>" + NAME + "</td></tr>" +
				"<tr> <td>Date:</td> <td>" + DATE + "</td></tr>" +				
				"<tr> <td>Location: </td> <td><a href='http://www.parkitdc.com/index.php/address/"+LAT+"/"+LNG+"'>" + LOCATION + "</a></td></tr>" +
				"<tr> <td>Narrative: </td> <td>" + NARRATIVE + "</td></tr></table>";
				
         		var marker = createCrimeMarker(point, html);
         		clusterer.AddMarker(marker, NAME);
       		}
		});
		
    }
    
	function addpoly(center) {
		var radius = document.getElementById('radiusSelect').value;
	   	var searchUrl = '../xml/RPPLines.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
	   	
	   	GDownloadUrl(searchUrl, function(data) {
	        var xml = GXml.parse(data);
	        var lines = xml.documentElement.getElementsByTagName('line');
			var html_poly = [];
	        for (var a = 0; a < lines.length; a++) {
	            // get any line attributes
	            var colour = lines[a].getAttribute("Color");
	            var width  = parseFloat(lines[a].getAttribute("Width"));
	            var Ward = lines[a].getAttribute("Ward");
	            var Street_Side = lines[a].getAttribute("Street_Side");
	           	var Location = lines[a].getAttribute("Location");
	           	
	           	
	           	html_poly[a] = '<table>' +
	           	'<table> <tr> <td colspan=2><b>Residential Parking Permit (RPP)</b></td></tr>' +
	           	'<tr><td>Location:</td><td>'+Location+'</td></tr>' +
	           	'<tr> <td>Side of Street:</td><td>' + Street_Side + '</td></tr>' + 
	           	'<tr> <td>Ward:</td> <td>' + Ward + '</td></tr></table>';

	            // read each point on that line
	            var points = lines[a].getElementsByTagName("point");
	            var pts = [];
	            for (var i = 0; i < points.length; i++) {
	            	pts[i] = new GLatLng(parseFloat(points[i].getAttribute("latitude")),
										 parseFloat(points[i].getAttribute("longitude")));
	            }

	            var poly = new GPolyline(pts,colour,width); 
	            map.addOverlay(poly);
	            addit(poly, html_poly[a]);
        	}
		});
	}

	function addit(x, html) {
   		GEvent.addListener(x,'click',function(data) {
   			document.getElementById("Widget-Info").innerHTML = html;
   		});
    }
        
	function createMeterMarker(point, html, color, MeterNum) {
		var marker = new GMarker(point, color);		
		GEvent.addListener(marker, 'click', function() {
			document.getElementById("Widget-Info").innerHTML = html;
       	});
      	return marker;
	}
	
	function createGarageMarker(point, html, Info, GarageName) {
		var marker = new GMarker(point, markerOptionsGarage);		
		GEvent.addListener(marker, 'click', function() {
        	document.getElementById("Widget-Info").innerHTML = Info;
        });
      	return marker;
	}
	
	
	function createCrimeMarker(point, html) {
		var marker = new GMarker(point, markerOptionsBlack);		
		GEvent.addListener(marker, 'click', function() {
        	document.getElementById("Widget-Info").innerHTML = html;
        });
      	return marker;
	}
	
	function iPhoneGPS(lat, lng) {
		var addressPoint = new GLatLng(parseFloat(lat),parseFloat(lng));
		var address = "iPhone";
		searchLocationsNear(addressPoint, address);
	}
	
//]]>
</script>

	<title>Park It DC [iPhone - PointAbout]</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Shaun J. Farrell" />

	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<style>
		body, html {
			margin:0px; 
			padding:0px;
		}

		td {
			vertical-align:top;
			font: normal 12px "Trebuchet MS", Verdana, "Lucida Grande", Georgia, Sans-Serif;
		}
		.foot a {
			color: #FFF;
		}
		
	</style>
</head>

<body onload="load();" onunload="GUnload()" id="bmission">
<?php if( ((isset($_REQUEST['lat'])) && ($_REQUEST['lat'] != "")) && ((isset($_REQUEST['lng'])) && ($_REQUEST['lng'] != "")) ){ ?>
	<script>iPhoneGPS(<?php echo $_REQUEST['lat']; ?>,<?php echo $_REQUEST['lng']; ?>);</script>
<?php } ?>

<!--img src="http://www.parkitdc.com/media/images/PARKITDC_250.gif" alt="Park It DC Logo" /-->
<div style="padding:0px margin:0px; border:1px solid #666; width: 320px;">
<div id="map_canvas" style="width: 320px; height: 320px"></div>
<div style="width:320px;">
<table style="margin-left:35px;">
	<tr> <td>Address:</td> <td><input type="text" id="addressInput" style="font-size:12px; color:#444; padding:2px;"/></td> </tr>
 	<tr> <td>Radius:</td> <td><select id="radiusSelect" style="font-size:12px; color:#444; padding:2px;">
      <option value=".2" selected>.2 Miles</option>
      <option value=".3">.4 Miles</option>
      <option value=".6">.6 Miles</option>
      <option value="1">1 Mile</option>
    </select>
    &nbsp; <input type="button" onclick="searchLocations()" value="Search" class="button"/></td> </tr>
</table>
<div id="Widget-Info" style="margin-left:35px; margin-top:10px;height:200px; overflow: auto;"></div>
<div class="foot" style="text-align:center; color:#fff; padding:2px; background:#000;">Find more at <a href='http://www.parkitdc.com/'>www.parkitdc.com</a></div>
</div>
</div>
</body>
</html>