<?php /**/ ?><div id="page-header">
	<div style="position:absolute; background-color:#fff; right:0; top:0; z-index:99; border:2px solid #666;">
		<table>
			<tr> <td colspan="2">	<b>Legend</b></td></tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/red_15.png" alt="Red Dot"></td> <td>Cost Money</td> </tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/yellow_15.png" alt="yello Dot"></td> <td>Free in < 1Hr</td> </tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/green_15.png" alt="green Dot"></td> <td>Free!</td> </tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/parking.gif" alt="parking"></td> <td>Parking Garage</td> </tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/black_15.png" alt="black Dot"></td> <td>Auto Crime</td> </tr>
			<tr> <td><img src="<?php echo base_url(); ?>media/images/meter.png" height="15" width="15" alt="Red Dot"></td> <td>Meter Cluster</td> </tr>
			<tr> <td><span style="color:blue; font-weight:bold;">---</span></td> <td>RPP Parking Only</td> </tr>
		</table>
	</div>
	<div id="map_canvas" style="width: 700px; height: 300px"></div>
</div>

<div id="wrapper-meter">
	<div style="margin:5px 0px">	
		Meter Number:&nbsp;<input style="font-size:12px; color:#444; padding:4px;" type="text" name="meter_number" id="meter_number" /> &nbsp;
		<input type="button" onclick="searchByMeterNumber();" class="button" value="Search" />
	</div>