<?php /**/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Park It DC</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Shaun J. Farrell" />
	<meta name="copyright" content="Copyright Goes Here" />
	<meta name="description" content="Description Goes Here" />
	<meta name="keywords" content="And, Finally, Keywords Go Here." />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>media/css/screen.css" />
	<!--[if lt ie 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>media/css/ie-win.css" /><![endif]-->
</head>

<body id="bmission">
	<div id="container">
		<div id="header">
			<div class="logo"></div>
			<h1><?php echo anchor('','Park It DC'); ?></h1>	
			<div id="search">
				<img src="<?php echo base_url(); ?>media/images/apps_logo.gif" alt="apps logo" />
			</div>
		</div>
		<div id="navigation">
			<ul>
				<li id="home" <?php if($segment == "home") { echo "class='active'"; } ?>><?php echo anchor('', 'Home'); ?></li>
				<li id="about" <?php if($segment == "about") { echo "class='active'"; } ?>><?php echo anchor('about', 'About'); ?></li>
				<li><a href="http://www.clearspring.com/widgets/491756e4a71fbf38">Widget</a></li>
				<li id="support" <?php if($segment == "support") { echo "class='active'"; } ?>><?php echo anchor_popup('http://code.google.com/p/parkitdc/', 'Support'); ?></li>
				<li id="contact" <?php if($segment == "contact") { echo "class='active'"; } ?>><?php echo anchor('contact', 'Contact'); ?></li>
			</ul>
		</div>