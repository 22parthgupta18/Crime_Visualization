<?php
include 'connect.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crime Visualization</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="fusioncharts.js"></script>
</head>

<body>	
<?php
$cr = mysqli_real_escape_string($con, $_GET['crime_category']);
$crimenamequery = "SELECT Type FROM `crime dict` WHERE Id = '$cr'";//*

?>
	
	
	
</body>
</html>