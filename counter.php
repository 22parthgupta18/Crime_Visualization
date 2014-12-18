<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');

include 'connect.inc.php';
echo 'Start - 0.00s<br/>';
$time = microtime(true);


$query_main = "SELECT * FROM main_table";
$query_main_run = mysqli_query($con, $query_main);
while ($rowMain = mysqli_fetch_assoc($query_main_run))
{
	//$headline=strtolower($rowMain["Headline"]);
	$location=trim(strtolower($rowMain["Location"]));
	$crime=strtolower($rowMain["Crime"]);
	//echo "<br/>--".$location."---->".$crime."<br/>";
	//$loc=$rowMain["Location"];
	//echo "--->".$loc;

	$query_location = "SELECT Id FROM location WHERE Name='$location'";//case insensitive in mysql by default except for binary comparison
	$query_location_run = mysqli_query($con, $query_location);

	if($rowLocation = mysqli_fetch_assoc($query_location_run));
	{
		//echo "Hi!".$rowLocation["Id"]. "<br/>";
		$location_id=$rowLocation["Id"];
		$query_crime = "SELECT Id FROM `crime dict` WHERE Type='$crime'";//case insensitive in mysql by default except for binary comparison
		$query_crime_run = mysqli_query($con, $query_crime);
		if($rowCrime = mysqli_fetch_assoc($query_crime_run))
		{
			$crime_id=$rowCrime["Id"];
			$query_counter = "UPDATE  final_table_2 SET Counter=Counter+1 WHERE Loc_Id='$location_id' AND Crime_Id='$crime_id'";//case insensitive in mysql by default except for binary comparison
			mysqli_query($con, $query_counter);
			//echo "<br/>".$crime_id."---->".$location_id."---> 5<br/>";
		}

	}


}

echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>