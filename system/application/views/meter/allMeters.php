<?php /**/ ?>	<div id="content" class="single_col">
		<h3>Meter Problem Listings</h3>
		<div id="indv-meter-info">
			<div style="float:right;"><?php echo $links; ?></div>
			<br />
			<?php
			foreach($IssueData as $id) {
				
				echo "<b>Meter: </b>";
				if($id->METERNUM != 'N/A') {
					echo anchor('/meter/issues/'.$id->METERNUM, $id->METERNUM);
				} else { 
					echo $id->METERNUM;
				}
				echo " (".$id->SERVICE_ORDER_DATE.")<br />";
				echo "Problem: ".$id->SERVICE_CODE_DESC."<br />";
				echo "Status: ".$id->SERVICE_ORDER_STATUS."<br /><br />";
			}
			?>
			<div style="float:right;"><?php echo $links; ?></div>
		</div>
	</div>