<?php /**/ ?><div id="links" class="col">
	<h3>Recent Meter Problems</h3>
	<ul>
		<?php foreach($ServiceProblems as $sp) { ?>
		<?php $issue = substr($sp->SERVICE_CODE_DESC,16); ?>
		<li><?php echo anchor('/meter/issues/'.$sp->METERNUM, $sp->METERNUM.' ['.$issue.']'); ?></li>
		<?php } ?>
	</ul>
</div>

<div id="content" class="col">
	<h3>Recent Auto Crimes</h3>
	<ul>
		<?php foreach($AutoCrime as $ac) { ?>
		<li><?php echo anchor('/crime/casenumber/'.$ac->ID, ucwords(strtolower($ac->LOCATION)).' ['.ucwords(strtolower($ac->NAME)).']'); ?></li>
		<?php } ?>
	</ul>
</div>

<div id="sidebar" class="col">
	<h3>Recent Searches</h3>
	<ul>
		<?php 
		foreach($ComboSearches as $cs) {
			if($cs->Type == "Meter") {
				echo "<li>".anchor('/meter/'.$cs->Value, '['.$cs->Type.'] '.$cs->Value)."</li>";
			}
			if($cs->Type == "Address") {
				echo "<li>".anchor('/address/'.$cs->LATITUDE.'/'.$cs->LONGITUDE, '['.$cs->Type.'] '.$cs->Value)."</li>";
			}
		} 
		?>
	</ul>
</div>