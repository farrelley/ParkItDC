<?php /**/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAl_Aitbh_FmAMmvuNExykuhQJPoRzckwdVZ_VnTpDeZYkiJkVRBQl20-cmo1GecqU4VGJbwSjN-7I1A" type="text/javascript"></script>
<script src="http://www.acme.com/javascript/Clusterer2.jsm" type="text/javascript"></script>
<script type="text/javascript">
    //<![CDATA[
    var map;
    var geocoder;
    var clusterer;

    var meterIcon = new GIcon();
    meterIcon.image = "<?php echo base_url(); ?>media/images/meter.png";
    meterIcon.iconSize = new GSize(20, 36);
    meterIcon.iconAnchor = new GPoint(10, 10);
    meterIcon.shadowSize = new GSize(0, 0);
    meterIcon.infoWindowAnchor = new GPoint(5, 5);
      
    var greenIcon = new GIcon();
    greenIcon.image = "<?php echo base_url(); ?>media/images/green_15.png";
    greenIcon.iconSize = new GSize(10, 10);
    greenIcon.iconAnchor = new GPoint(5, 5);
    greenIcon.shadowSize = new GSize(0, 0);
    greenIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsGreen = { icon:greenIcon };

    var redIcon = new GIcon();
    redIcon.image = "<?php echo base_url(); ?>media/images/red_15.png";
    redIcon.iconSize = new GSize(10, 10);
    redIcon.iconAnchor = new GPoint(5, 5);
    redIcon.shadowSize = new GSize(0, 0);
    redIcon.infoWindowAnchor = new GPoint(5, 5);
	markerOptionsRed = { icon:redIcon };
	
	var garageIcon = new GIcon();
    garageIcon.image = "<?php echo base_url(); ?>media/images/parking.gif";
    garageIcon.iconSize = new GSize(20, 20);
    garageIcon.iconAnchor = new GPoint(10, 10);
    garageIcon.shadowSize = new GSize(0, 0);
    garageIcon.infoWindowAnchor = new GPoint(10, 10);
	markerOptionsGarage = { icon:garageIcon };
  
    var yellowIcon = new GIcon();
    yellowIcon.image = "<?php echo base_url(); ?>media/images/yellow_15.png";
    yellowIcon.iconSize = new GSize(10, 10);
    yellowIcon.iconAnchor = new GPoint(5, 5);
    yellowIcon.shadowSize = new GSize(0, 0);
    yellowIcon.infoWindowAnchor = new GPoint(5, 5);
    markerOptionsYellow = { icon:yellowIcon };


    var blackIcon = new GIcon();
    blackIcon.image = "<?php echo base_url(); ?>media/images/black_15.png";
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
		map.clearOverlays();
    	var address = document.getElementById('addressInput').value;
     	geocoder.getLatLng(address, function(latlng) {
       		if (!latlng) {
				document.getElementById("map-headline").innerHTML = 'Address Not Found';
       		} else {
        	 	searchLocationsNear(latlng, address);
       		}
     	});
   	}

	//search by meter number
   	function searchByMeterNumber(str) {
   	    document.getElementById("service-data").style.display = "none";
        document.getElementById("indv-meter-info").innerHTML = '';

		if(str) {
			var meter_number = str;
	   		var meter_number = document.getElementById('meter_number').value = str;
		} else {
	   		var meter_number = document.getElementById('meter_number').value;
		}

		var searchUrl = '<?php echo base_url(); ?>xml/getMeterData.php?meternumber=' + meter_number;
    	GDownloadUrl(searchUrl, function(data) { 	
	       	var xml = GXml.parse(data);
			var METERNUM = xml.documentElement.getElementsByTagName("METERNUM")[0].childNodes[0].nodeValue;
			
			if(METERNUM != 'NOT FOUND') {
				var BLOCK = xml.documentElement.getElementsByTagName("BLOCK")[0].childNodes[0].nodeValue;
   				var STREET = xml.documentElement.getElementsByTagName("STREET")[0].childNodes[0].nodeValue;
   				var SIDE = xml.documentElement.getElementsByTagName("SIDE")[0].childNodes[0].nodeValue;
   				var HOUR_FROM = xml.documentElement.getElementsByTagName("HOUR_FROM")[0].childNodes[0].nodeValue;
   				var HOUR_TO = xml.documentElement.getElementsByTagName("HOUR_TO")[0].childNodes[0].nodeValue;
   				var DAY_FROM = xml.documentElement.getElementsByTagName("DAY_FROM")[0].childNodes[0].nodeValue;
				var DAY_TO = xml.documentElement.getElementsByTagName("DAY_TO")[0].childNodes[0].nodeValue;
				var LIMIT = xml.documentElement.getElementsByTagName("LIMIT")[0].childNodes[0].nodeValue;
				var RATE = xml.documentElement.getElementsByTagName("RATE")[0].childNodes[0].nodeValue;
				var WARD = xml.documentElement.getElementsByTagName("WARD")[0].childNodes[0].nodeValue;
				var ICON = xml.documentElement.getElementsByTagName("ICON")[0].childNodes[0].nodeValue;

				var bounds = new GLatLngBounds();
				var LATITUDE = xml.documentElement.getElementsByTagName("LATITUDE")[0].childNodes[0].nodeValue;
				var LONGITUDE = xml.documentElement.getElementsByTagName("LONGITUDE")[0].childNodes[0].nodeValue;
				var point = new GLatLng(parseFloat(LATITUDE),
										parseFloat(LONGITUDE));

				var map_info_data = "<table>" +
				"<tr> <td>Meter Number:</td> <td>" + METERNUM + "</td> </tr>" +
				"<tr> <td>Block:</td> <td>" + BLOCK + "</td> </tr>" +
				"<tr> <td>Street:</td> <td><a href='<?php echo site_url();?>/address/"+LATITUDE+"/"+LONGITUDE+"'>" + STREET + "</a></td> </tr>" +
				"<tr> <td>Side of Street:</td> <td>" + SIDE + "</td> </tr>" +
				"<tr> <td>Hour of Operation:</td> <td>" + HOUR_FROM + " - " + HOUR_TO + "</td> </tr>" +
				"<tr> <td>Days in Operation:</td> <td>" + DAY_FROM + " - " + DAY_TO + "</td> </tr>" +
				"<tr> <td>Parking Time Limit:</td> <td>" + LIMIT + "</td> </tr>" +
				"<tr> <td>Cost Per Hour:</td> <td>$" + RATE + "</td> </tr>" +
				"<tr> <td>DC Ward:</td> <td>" + WARD + "</td> </tr>" +
				"</table>" +
				"<p><a href='http://forms.dc.gov/lfserver/35c22fz10d050e619bzx7dcd1x2x111x52?DFS__FormType=crp' target='_blank'>Report a Problem with this Meter.</a></p>";
				
			}

			if(METERNUM == 'NOT FOUND') {
				var MeterHeadline = '<b>Meter Number: </b> Not Found';
				document.getElementById("meter-headline").innerHTML = MeterHeadline;
			}
			else {
				var MeterHeadline = '<b>Meter Number: </b>' + METERNUM;
				document.getElementById("meter-headline").innerHTML = MeterHeadline;
				trackMeterSearch(METERNUM);
			}
					
	        var service = xml.documentElement.getElementsByTagName('service');
	     	var service_data = '';
	     	var hasServiceData = false;
       		for (var i = 0; i < service.length; i++) {
				hasServiceData = true;
       			var ID = service[i].getAttribute('ID');
       		  	var SERVICE_PRIORITY = service[i].getAttribute('SERVICE_PRIORITY');
        	 	var SERVICE_CODE_DESC = service[i].getAttribute('SERVICE_CODE_DESC');
        	 	var SERVICE_ORDER_DATE = service[i].getAttribute('SERVICE_ORDER_DATE');
        	 	var SERVICE_ORDER_STATUS = service[i].getAttribute('SERVICE_ORDER_STATUS');
        	 	var CALL_COUNT = service[i].getAttribute('CALL_COUNT');
        	 	var RESOLUTION_DATE = service[i].getAttribute('RESOLUTION_DATE');
        	 	var RESOLUTION = service[i].getAttribute('RESOLUTION');
        	 	var SERVICE_DUE_DATE = service[i].getAttribute('SERVICE_DUE_DATE');
        	 	var SERVICE_NOTES = service[i].getAttribute('SERVICE_NOTES');  

        	 	service_data = service_data +
        	 	"<table> <tr> <td>ID:</td> <td>" + ID + "</td> </tr>" +
        	 	"<tr> <td>Service Description:</td> <td>" + SERVICE_CODE_DESC + "</td> </tr>" +
        	 	"<tr> <td>Service Priority:</td> <td>" + SERVICE_PRIORITY + "</td> </tr>" +
        	 	"<tr> <td>Service Date:</td> <td>" + SERVICE_ORDER_DATE + "</td> </tr>" +
        	 	"<tr> <td>Service Status:</td> <td>" + SERVICE_ORDER_STATUS + "</td> </tr>" +
        	 	"<tr> <td># of Calls on Problem:</td> <td>" + CALL_COUNT + "</td> </tr>" +
        	 	"<tr> <td>Service Due on:</td> <td>" + SERVICE_DUE_DATE + "</td> </tr>" +
        	 	"<tr> <td>Service Notes:</td> <td>" + SERVICE_NOTES + "</td> </tr>" +
        	 	"</table><br >"+
        	 	"<a href='<?php echo site_url(); ?>/meter/issues/" + METERNUM + "'>View All Open and Closed Issues on this Meter</a>";
       		}
       		
   		  	if(ICON == 'R') {
           		var color = markerOptionsRed;
       			var status = 'Meter Cost Money';
        	}
        	if(ICON == 'G') {
            	var color = markerOptionsGreen;
        		var status = 'Meter is Free';            
        	}
        	if(ICON == 'Y') {
            	var color = markerOptionsYellow;
        		var status = 'Meter will be Free in > 1 Hour';
			}
		
			var html = '<b>Status: </b>' + status + '<br /><b>Meter: </b>' + METERNUM + '<br/><b>Address: </b>' + STREET + '<br />';
       		var servicemarker = createSingleMeterMarker(point, html, color);
         	map.addOverlay(servicemarker);
        	bounds.extend(point);
			
		
			
      		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
            document.getElementById("indv-meter-info").innerHTML = map_info_data;
            
            if(hasServiceData == true) {
	          	document.getElementById("service-data").style.display = "";
	            document.getElementById("meter-service-info").innerHTML = service_data;
                document.getElementById("meter-service-header").innerHTML = "<b>OPEN Service Issues</b>";
            }
		});

   	}


	function searchLocationsNear(center, theAddress) {
		load('reload');
		document.getElementById("map-info").style.display = "none";
     	var radius = document.getElementById('radiusSelect').value;
      	     	
	  	var searchUrl = '<?php echo base_url(); ?>xml/parkingmeters.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
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
				var html = '<b>Status: </b>' + status + '<br /><b>Meter: </b>' + METERNUM + '<br/><b>Address: </b>' + STREET + '<br />';
				
				var MapInfo = "<table>" +
				"<tr> <td>Meter Number:</td> <td>" + METERNUM + "</td> </tr>" +
				"<tr> <td>Status:</td> <td>" + status + "</td> </tr>" +				
				"<tr> <td>Block:</td> <td>" + BLOCK + "</td> </tr>" +
				"<tr> <td>Street:</td> <td>" + STREET + "</td> </tr>" +
				"<tr> <td>Side of Street:</td> <td>" + SIDE + "</td> </tr>" +
				"<tr> <td>Hour of Operation:</td> <td>" + HOUR_FROM + " - " + HOUR_TO + "</td> </tr>" +
				"<tr> <td>Days in Operation:</td> <td>" + DAY_FROM + " - " + DAY_TO + "</td> </tr>" +
				"<tr> <td>Parking Time Limit:</td> <td>" + LIMIT + "</td> </tr>" +
				"<tr> <td>Cost Per Hour:</td> <td>$" + RATE + "</td> </tr>" +
				"<tr> <td>DC Ward:</td> <td>" + WARD + "</td> </tr>" +
				"<tr> <td>Comments:</td> <td>" + COMMENTS + "</td> </tr>" +
				"</table>" +
				"<p><a href='http://forms.dc.gov/lfserver/35c22fz10d050e619bzx7dcd1x2x111x52?DFS__FormType=crp' target='_blank'>Report a Problem with this Meter.</a></p>";

         		var marker = createMeterMarker(point, html, color, METERNUM, MapInfo);
         		clusterer.AddMarker(marker, METERNUM);
         		bounds.extend(point);
       		}
			
			
			searchCrimeNear(center);
			searchParkingGaragesNear(center);
     		addpoly(center);

			if(bounds.getCenter() == '(0, 180)') {
				document.getElementById("map-headline").innerHTML = 'No Meters Found in this Location';
				map.setCenter(new GLatLng(center.lat(),center.lng()), 16);
			} else {
				trackSearch(theAddress, center.lat(), center.lng());
				document.getElementById("map-headline").innerHTML = 'Select a Marker';	       		
     			map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
			}
     	}); 
	}
	

	function searchCrimeNear(center) {
		map.clearOverlays();
    	var radius = document.getElementById('radiusSelect').value;
     	var searchUrl = '<?php echo base_url(); ?>xml/crime.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     	GDownloadUrl(searchUrl, function(data) {
       		var xml = GXml.parse(data);
       		var markers = xml.documentElement.getElementsByTagName('marker');
       		//var bounds = new GLatLngBounds();
       	
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
         		var point = new GLatLng(parseFloat(markers[i].getAttribute('LATITUDE')),
										parseFloat(markers[i].getAttribute('LONGITUDE')));
				
				var CrimeInfo = "<table>" +
				"<tr> <td>Crime:</td> <td>" + NAME + "</td> </tr>" +
				"<tr> <td>Date:</td> <td>" + DATE + "</td> </tr>" +				
				"<tr> <td>Location:</td> <td>" + LOCATION + "</td> </tr>" +
				"<tr> <td>Shift:</td> <td>" + SHIFT + "</td> </tr>" +
				"<tr> <td>Ward:</td> <td>" + WARD + "</td> </tr>" +
				"<tr> <td>Method of Crime:</td> <td>" + METHOD + "</td> </tr>" +
				"<tr> <td>Narrative:</td> <td>" + NARRATIVE + "</td> </tr>" +
				"</table>";
				
				var html = '<b>Crime: </b>' + NAME + '<br /><b>Date: </b>' + DATE + '<br /><b>Location: </b>' + LOCATION;
         		var marker = createCrimeMarker(point, html, CrimeInfo, NAME);
         		clusterer.AddMarker(marker, NAME);
         		//bounds.extend(point);
       		}
       		//map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
		});
    }
    
    
    function searchParkingGaragesNear(center) {
    	var radius = document.getElementById('radiusSelect').value;
     	var searchUrl = '<?php echo base_url(); ?>xml/garageparking.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
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
    

	function addpoly(center) {
		var radius = document.getElementById('radiusSelect').value;
	   	var searchUrl = '<?php echo base_url(); ?>xml/RPPLines.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
	   	
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
	           	html_poly[a] = '<b>Residential Parking Permit (RPP)</b><br /><b>Location: </b>'+Location+'<br /> <b>Side of Street: </b>' + Street_Side + '<br /> <b>Ward: </b>' + Ward;

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
   			map.openInfoWindowHtml(data, html, data)
   		});
    }
    
    function createSingleMeterMarker(point, html, color) {
		var marker = new GMarker(point, color);		
		GEvent.addListener(marker, 'click', function() {
        	marker.openInfoWindowHtml(html);
        });
      	return marker;
	}
    
	function createMeterMarker(point, html, color, MeterNum, infoHTML) {
		var marker = new GMarker(point, color);		
		GEvent.addListener(marker, 'click', function() {
        	marker.openInfoWindowHtml(html);
        	document.getElementById("map-headline").innerHTML = '<b>Parking Meter: </b>' + MeterNum;
			document.getElementById("map-info").style.display = "";
        	document.getElementById("map-info").innerHTML = infoHTML;
        	
        	var problemurl = '<?php echo base_url(); ?>xml/MeterProblemCount.php?Meter=' + MeterNum;
     		GDownloadUrl(problemurl, function(data) {
       			var xmlproblem = GXml.parse(data);
       			var markers = xmlproblem.documentElement.getElementsByTagName('marker');
				var theCount = markers[0].getAttribute('METER_COUNT');
				if(theCount > 0)
			       	document.getElementById("map-meterProblems").innerHTML = "<br />This Meter has had <b>"+ theCount +"</b> issue(s) in the Past.  <a href='#'>Check Meter Issues</a>";
			    else
			    	document.getElementById("map-meterProblems").innerHTML = "";
       		});   
        });
      	return marker;
	}
	
	function createCrimeMarker(point, html, CrimeInfo, CrimeName) {
		var marker = new GMarker(point, markerOptionsBlack);		
		GEvent.addListener(marker, 'click', function() {
        	marker.openInfoWindowHtml(html);
        	document.getElementById("map-headline").innerHTML = '<b>Crime: </b>' + CrimeName;
			document.getElementById("map-info").style.display = "";
        	document.getElementById("map-info").innerHTML = CrimeInfo;
        });
      	return marker;
	}
	
	function createGarageMarker(point, html, Info, GarageName) {
		var marker = new GMarker(point, markerOptionsGarage);		
		GEvent.addListener(marker, 'click', function() {
        	marker.openInfoWindowHtml(html);
        	document.getElementById("map-headline").innerHTML = '<b>' + GarageName + '</b>';
			document.getElementById("map-info").style.display = "";
        	document.getElementById("map-info").innerHTML = Info;
        });
      	return marker;
	}



	function getMeterMetadata(MeterNumber) {
    	var MeterDataHTML = [];
   		var meterUrl = '<?php echo base_url(); ?>xml/MeterMetadata.php?meternum=' + MeterNumber;
    	GDownloadUrl(meterUrl, function(data) {
    		var xml = GXml.parse(data);
   			var meter = xml.documentElement.getElementsByTagName('meter');
   			for (var i = 0; i < meter.length; i++) {
        	    var METERNUM = meter[i].getAttribute('METERNUM');
        	    var SERVICE_CODE_DESC = meter[i].getAttribute('SERVICE_CODE_DESC');
        	    var SERVICE_PRIORITY = meter[i].getAttribute('SERVICE_PRIORITY');
        	    var SERVICE_ORDER_DATE = meter[i].getAttribute('SERVICE_ORDER_DATE');
        	    var SERVICE_ORDER_STATUS = meter[i].getAttribute('SERVICE_ORDER_STATUS');
        	    var CALL_COUNT = meter[i].getAttribute('CALL_COUNT');
        	    var RESOLUTION_DATE = meter[i].getAttribute('RESOLUTION_DATE');
        	    var RESOLUTION = meter[i].getAttribute('RESOLUTION');
        	    var SERVICE_DUE_DATE = meter[i].getAttribute('SERVICE_DUE_DATE');
        	    var SERVICE_NOTES = meter[i].getAttribute('SERVICE_NOTES');
        	    var LOCATION = meter[i].getAttribute('LOCATION');
        	    var WARD = meter[i].getAttribute('WARD');
        	    
        	    MeterDataHTML[i] = METERNUM + '<br />' + SERVICE_CODE_DESC + '<br />' + SERVICE_PRIORITY + '<br />' + SERVICE_ORDER_DATE + '<br />' + SERVICE_ORDER_STATUS + '<br />' 
        	    + CALL_COUNT + '<br />' + RESOLUTION_DATE + '<br />' + RESOLUTION + '<br />' + SERVICE_DUE_DATE + '<br />' + SERVICE_NOTES + '<br />' + LOCATION + '<br />'
        	    + WARD + '<br />';
   			}
   		});
		return MeterDataHTML;
    }

	var xmlhttp;
	function trackSearch(address, lat, lng) {
		if(address != '') {
			var newAddress = address.replace(',', "");
			xmlhttp=null;
			if (window.XMLHttpRequest){
				// code for IE7, Firefox, Opera, etc.
				xmlhttp=new XMLHttpRequest();
			}
			else if (window.ActiveXObject) {
				// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			if (xmlhttp!=null) {
				var url = '<?php echo site_url(); ?>/tracking/address/' + newAddress + '/' + lat + '/' + lng;
				xmlhttp.open("GET",url,true);
				xmlhttp.send(null);
			}
			else {
				alert("Your browser does not support XMLHTTP.");
			}
		}
	}

	function trackMeterSearch(meter) {
		xmlhttp=null;
		if (window.XMLHttpRequest){
			// code for IE7, Firefox, Opera, etc.
			xmlhttp=new XMLHttpRequest();
		}
		else if (window.ActiveXObject) {
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		if (xmlhttp!=null) {
			var url = '<?php echo site_url(); ?>/tracking/meter/' + meter;
			xmlhttp.open("GET",url,true);
			xmlhttp.send(null);
		}
		else {
			alert("Your browser does not support XMLHTTP.");
		}
	}
	
	function shaunsaddress(lat, lng, address) {
		var addressPoint = new GLatLng(parseFloat(lat),parseFloat(lng));
		searchLocationsNear(addressPoint, address);
	}


//]]>
</script>

<head>
	<title>Park It DC</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Shaun J. Farrell" />
	<meta name="copyright" content="Copyright Goes Here" />
	<meta name="description" content="Description Goes Here" />
	<meta name="keywords" content="And, Finally, Keywords Go Here." />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>media/css/screen.css" />
	<!--[if lt ie 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>media/css/ie-win.css" /><![endif]-->
</head>


<?php 

	
	
	$searchbyMeter = '';
	if(isset($meterNumber) && $meterNumber != '') { 
		$searchbyMeter = "searchByMeterNumber('$meterNumber');";
	} 
	
	
	$searchByAddress = '';
	if(isset($lat) && $lat!= '') {
		$searchByAddress = "shaunsaddress('".$lat."', '".$lng."', '');";
	}
?>



<body onload="load(); <?php if($searchbyMeter != '') echo $searchbyMeter; ?> <?php if($searchByAddress != '') echo $searchByAddress; ?>" onunload="GUnload()" id="bmission">
	<div id="container">
		<div id="header">
			<div class="logo"></div>
			<h1><?php echo anchor('','Park It DC'); ?></h1>	
			<div id="search">
				<img src="<?php echo base_url(); ?>media/images/apps_logo.gif" alt="apps logo" />
				<!--form id="SearchForm" method="post" action="#01">
					<p>
						<input type="text" name="KeywordsTextBox" size="20" value="Search" />
					</p>
				</form-->
			</div>
		</div>
		<div id="navigation">
			<ul>
				<li id="home" <?php if($segment == "home") { echo "class='active'"; } ?>><?php echo anchor('', 'Home'); ?></li>
				<li id="about" <?php if($segment == "about") { echo "class='active'"; } ?>><?php echo anchor('about', 'About'); ?></li>
				<li><a href="http://www.clearspring.com/widgets/491756e4a71fbf38">Widget</a></li>
				<li id="support" <?php if($segment == "support") { echo "class='active'"; } ?>><?php echo anchor_popup('http://code.google.com/p/parkitdc/', 'Support'); ?></li>
				<li id="contact" <?php if($segment == "contact") { echo "class='active'"; } ?>><?php echo anchor('contact', 'Contact'); ?></li>
			</ul>
		</div>
