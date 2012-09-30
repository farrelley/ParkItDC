<?php /**/ ?><div id="links" class="col">
<h3>Recent Auto Crimes</h3>
	<ul>
		<?php foreach($AutoCrime as $ac) { ?>
		<li><?php echo anchor('/crime/casenumber/'.$ac->ID, ucwords(strtolower($ac->LOCATION)).' ['.ucwords(strtolower($ac->NAME)).']'); ?></li>
		<?php } ?>
	</ul>
</div>

<div id="content" class="double_col">
	<h3><div id="meter-headline"><b>Auto Crime: </b> <?php echo $CrimeData[0]->NAME; ?></div></h3>
	<div id="indv-meter-info">
	
	<table>
		<tr> <td>Date:</td> <td><?php echo $CrimeData[0]->DATE; ?></td> </tr>
		<tr> <td>Location:</td> <td><?php echo anchor('/address/'.$CrimeData[0]->LATITUDE.'/'.$CrimeData[0]->LONGITUDE, $CrimeData[0]->LOCATION); ?></a></td> </tr>
		<tr> <td>Ward:</td> <td><?php echo $CrimeData[0]->WARD ?></td> </tr>
		<tr> <td>Shift:</td> <td><?php echo $CrimeData[0]->SHIFT ?></td> </tr>
		<tr> <td>Method:</td> <td><?php echo $CrimeData[0]->DESCRIPTION; ?> </td> </tr>
		<tr> <td>Narrative:</td> <td><?php echo $CrimeData[0]->NARRATIVE; ?></td> </tr>
	</table>
	<p><?php echo anchor('crime/view', 'View all auto crimes'); ?></p>
</div>
	
	<div id="service-data" style="display:none;">
		<h3><div id="meter-service-header"></div></h3>
		<div id="meter-service-info"></div>
	</div>
</div>