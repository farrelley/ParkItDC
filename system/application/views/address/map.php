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

	<div id="map_canvas" style="width: 700px; height: 400px"></div>
</div>

<div id="wrapper-address">
	<div style="margin:5px 0px">
	Address:&nbsp;<input type="text" id="addressInput" style="font-size:12px; color:#444; padding:4px;"/>
     
    &nbsp;Radius:&nbsp;<select id="radiusSelect" style="font-size:12px; color:#444; padding:4px;">

      <option value=".2" selected>.2 Miles</option>
      <option value=".3">.4 Miles</option>
      <option value=".6">.6 Miles</option>
      <option value="1">1 Mile</option>
    </select>

    <input type="button" onclick="searchLocations()" value="Search" class="button"/>
   
</div>