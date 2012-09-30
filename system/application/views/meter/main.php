<?php /**/ ?><div id="links" class="col">
	<h3>Recent Searches</h3>
	<ul>
	<?php foreach($RecentSearch as $rs) { ?>
		<li><a onclick="searchByMeterNumber('<?php echo $rs->Value; ?>'); "><?php echo $rs->Value; ?></a></li>
	<?php } ?>
	</ul>
</div>
<div id="content" class="double_col">
	<h3><div id="meter-headline">Input Meter Number</div></h3>
	<div id="indv-meter-info"></div>
	
	<div id="service-data" style="display:none;">
		<h3><div id="meter-service-header"></div></h3>
		<div id="meter-service-info"></div>
	</div>
</div>
