<?php /**/ ?><div id="links" class="col">

	<h3>Recent Searches</h3>
	<ul>
	<?php foreach($RecentSearch as $rs) { ?>
		<li> <a onclick="shaunsaddress('<?php echo $rs->LATITUDE; ?>', '<?php echo $rs->LONGITUDE; ?>', '<?php echo $rs->Value; ?>');"><?php echo $rs->Value; ?></a></li>
	<?php } ?>


	</ul>
</div>
<div id="content" class="double_col">
	<h3><div id="map-headline">Select Address</div></h3>
	<div id="map-info" style="display:none;"></div>
	<div id="map-meterProblems"></div>

</div>
