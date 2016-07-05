<?php
header('Content-type: text/html; charset=utf-8');
include("diverse.php");
include("auth.php");
include("db.php");
include("content.php");
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="headmenu">
		<?php
			loginbar();
		?>
	</div>
	<div id="header">
		<img src="https://sharptickets.net/images/sharptickets-hero.png" alt="Mountain View" style="width:100%;height:300px;">
	</div>
	<div id="wrapper">
		<div id="sidemenu"><?php sidemenu(); ?></div>
		<div id="sidebar"></div>
		<div id="content">
			<?php
				printer(); //figures out what to do
			?>
		</div>
	</div>
</body>
</html>
