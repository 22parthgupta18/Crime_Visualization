<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');

include 'connect.inc.php';
echo 'Start - 0.00s<br/>';
$time = microtime(true);
	

$query_location = "SELECT `Id` FROM `location`";
$query_location_run = mysqli_query($con, $query_location);
while ($rowLocation = mysqli_fetch_assoc($query_location_run))
{
	$locId=$rowLocation["Id"];
	$query_crime = "SELECT `Id` FROM `crime dict`";
	$query_crime_run = mysqli_query($con, $query_crime);
	while ($rowCrime = mysqli_fetch_assoc($query_crime_run))
	{
		$crimeId=$rowCrime["Id"];
		$counter=0;
		$query_insertion ="INSERT INTO  `final_table_2`(Loc_Id,Crime_Id,Counter) VALUES ($locId,$crimeId,$counter)";
		mysqli_query($con, $query_insertion);

	}
}


//update counter left !!! see counter file