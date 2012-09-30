<?php /**/ ?><div id="links" class="col">
<h3>Recent Meter Problems</h3>
	<ul>
		<?php foreach($ServiceProblems as $sp) { ?>
		<?php $issue = substr($sp->SERVICE_CODE_DESC,16); ?>
		<li><?php echo anchor('/meter/issues/'.$sp->METERNUM, $sp->METERNUM.' ['.$issue.']'); ?></li>
		<?php } ?>
	</ul>
</div>

<div id="content" class="double_col">
	<h3><div id="meter-headline"><b>Meter Number: </b><?php echo anchor('/meter/'.$MeterNumber, $MeterNumber); ?></div></h3>
	<div id="indv-meter-info">
	<p>Is this meter broken? 	<a href="http://forms.dc.gov/lfserver/35c22fz10d050e619bzx7dcd1x2x111x52?DFS__FormType=crp" target="_blank">Report a Problem</a></p>
	<?php foreach($IssueData as $sp) { ?>
	<table>
		<tr> <td>Status:</td> <td><?php echo $sp->SERVICE_ORDER_STATUS; ?></td> </tr>
		<tr> <td>Description:</td> <td><?php echo $sp->SERVICE_CODE_DESC; ?></td> </tr>
		<tr> <td>Number of Calls:</td> <td><?php echo $sp->CALL_COUNT; ?></td> </tr>
		<tr> <td>Priority:</td> <td><?php echo $sp->SERVICE_PRIORITY ?></td> </tr>
		<tr> <td>Reported:</td> <td><?php echo $sp->SERVICE_ORDER_DATE ?></td> </tr>
		<tr> <td>Fix By:</td> <td><?php echo $sp->SERVICE_DUE_DATE; ?></td> </tr>
		<tr> <td>Notes:</td> <td><?php echo $sp->SERVICE_NOTES; ?></td> </tr>
		<tr> <td>Location:</td> <td><?php echo anchor('address/'.$sp->LATITUDE.'/'.$sp->LONGITUDE, $sp->LOCATION); ?></td> </tr>
		<tr> <td>Ward</td> <td><?php echo $sp->WARD ?></td> </tr>
		<tr> <td>Resolved on:</td> <td><?php echo $sp->RESOLUTION_DATE; ?></td> </tr>
		<tr> <td>Resolution:</td> <td><?php echo $sp->RESOLUTION; ?></td> </tr>
	</table>
	<br />	
	<?php } ?>
	  <p><?php echo anchor('meter/view', 'View all parking meter issues &amp; problems'); ?></p>
		</div>
	
	<div id="service-data" style="display:none;">
		<h3><div id="meter-service-header"></div></h3>
		<div id="meter-service-info"></div>
	</div>
</div>
