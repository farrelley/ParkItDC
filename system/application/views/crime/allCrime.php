<?php /**/ ?>	<div id="content" class="single_col">
		<h3>Auto Crime Listings</h3>
		<div id="indv-meter-info">
			<div style="float:right;"><?php echo $links; ?></div>
			<br />
			<?php
			foreach($CrimeData as $cd) {
				echo "<b>".anchor('crime/casenumber/'.$cd->ID, $cd->ID).": </b>".$cd->NAME." (".$cd->DATE.")<br />";
				echo anchor('address/'.$cd->LATITUDE.'/'.$cd->LONGITUDE,$cd->LOCATION)."<br /><br />";
			}
			?>
			<div style="float:right;"><?php echo $links; ?></div>
		</div>
	</div>