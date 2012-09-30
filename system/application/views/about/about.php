<?php /**/ ?>	<div id="content" class="single_col">
		<h3>This is what you need to know!</h3>
		<div id="indv-meter-info">
		<p><b>What is Park It DC? </b><br />
		Park It DC is an application that allows you to check a specific area in the district for parking information.
		Don't you hate when you want to go to Dupont or Adams Morgan and once you get there you find out that all the meters
		still need to be paid for?  Why not check that information before you leave and see what streets you can park on.
		Check what meters cost money and what ones are free. Park It DC will even help you not get a ticket for parking in an RPP zone! </p>
		
		<p><b>How does it Work?</b><br />
		In Short we store all data in a database.  Every 10 mins. we make a call to the crime and service request feed and either update
		the already existing record or insert a new one.  Then we use Google Maps API calls to read XML files that we generate from the 
		database and plot the data on the map.<br /><br />
		Oh yeah each color icon represents something!
		<ul style="list-style-type:none;">
			<li><img src="<?php echo base_url(); ?>media/images/red_15.png" alt="Red Dot"> Red dots mean that the meter is currently in a pay status</li>
			<li><img src="<?php echo base_url(); ?>media/images/yellow_15.png" alt="yello Dot"> Yellow dots mean that the meter is going to be free in 1 hour or less</li>
			<li><img src="<?php echo base_url(); ?>media/images/green_15.png" alt="green Dot"> Green Dots mean that the meter is free</li>
			<li><img src="<?php echo base_url(); ?>media/images/black_15.png" alt="black Dot"> Black dots are were automobile crimes happened</li>
			<li><img src="<?php echo base_url(); ?>media/images/meter.png" height="15" width="15" alt="Red Dot">  Meter Icon means there are more meters if you zoom in</li>
			<li><span style="color:blue; font-weight:bold;">-----</span> Blue Lines are RPP parking only </li>
		</ul>
		Clicking on each icon/line will show data about that item.  Icon colors are displayed based on the current EST timezone!
		So if you check at 1pm on a Monday you will see that most meters are pay only.  However, if you check anything on Sunday
		then all meters will be free!
		</p>
		
		<p><b>Technology</b><br />
		We use the following
		<ul>
			<li><a href="http://code.google.com/apis/maps/">Google Maps &amp; the API</a></li>
			<li><a href="http://codeigniter.com/">CodeIgniter</a></li>
			<li><a href="http://www.php.net/">PHP5</a></li>
			<li><a href="http://www.mysql.org/">MySQL</a></li>
			<li><a href="">SVN</a></li>
		</ul>
		</p>
		
		<p><b>Why?</b><br />
		This application was built for an innovation competition [<a href="http://www.appsfordemocracy.com/">Apps for Democracy</a> &amp; <a href="http://istrategylabs.com/">iStrategyLabs</a>] put on by the DC Government. The DC Gov't 
		has published massive amounts of GIS data for users across  the country to use.  You can find out more information 
		about the project at <a href="http://www.appsfordemocracy.com/">www.appsfordemocracy.com</a>.</p>
		
		<p><b>What Feeds Do you Use?</b><br />
		We use the following feeds put out by the DC Government.
		<ul>
			<li><a href="http://data.octo.dc.gov/Metadata.aspx?id=4">Hansen Service Requests</a> - This is used to get all issues and problems associated with particular parking meters.</li>
			<li><a href="http://data.octo.dc.gov/Metadata.aspx?id=3">Crime Incidents (ASAP)</a> - This is used to get all automobile related Crime.</li>
			<li><a href="http://dcatlas.dcgis.dc.gov/metadata/ParkingMeter.html">Parking Meters</a> - This is used to plot all district parking meters and metadata attached to each meter.</li>
			<li><a href="http://dcatlas.dcgis.dc.gov/metadata/RPPBlocks.html">Residential Parking Permit Blocks</a> - This is used to locate and plot all RPP blocks</li>
		</ul>
		</p>
		
		<p><b>Why is there Missing &amp; Inaccurate  Data?</b><br />
		Yes...you may have seen that some of the data is missing or inaccurate in certain parts of the District.  Data is only as accurate
		as what is available  and published by the DC Gov't.</p>
		
		<p><b>Where can I get this Code?</b><br />
		If you want to download this code you can do so by going to <a href="http://code.google.com/p/parkitdc/">http://code.google.com/p/parkitdc/</a></p>
		
		<p><b>Help Me!</b><br />
		If you need help please <?php echo anchor('contact','contact us'); ?> or visit <a href="http://code.google.com/p/parkitdc/">http://code.google.com/p/parkitdc/</a></p>

		<p><b>Looking Ahead</b><br />
		With the short amount of time that the competition allowed we were only able to do so much.  So here are a couple of future items that may be done
		<ul>
 			<li>Phone Application - Why not be able to check parking status when you are in the area?</li>
			<li>Submit Meter Problems from your Phone -  You're at a meter and it's broke.  Don't move you car or call 311.  Report the problem with your phone!</li>
			<li>Statistics - What is the most dangerous are to park your car?  </li>
			<li>Rush Hour Service - Some streets have a Rush Hour parking restrictions.  There is no data yet for this but would be interesting to see plotted. </li>
		</ul>
		</p>
		</div>
	</div>