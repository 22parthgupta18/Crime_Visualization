<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');


include 'connect.inc.php';

//echo "Hi!!!";
echo 'Start - 0.00s<br/>';
$time = microtime(true);

// $total_headline_rows = 0;
// $query = "SELECT COUNT(`Id`) AS `H` FROM `Headline`"; 
// if($query_run = mysqli_query($con, $query)){
// 	if(mysqli_num_rows($query_run)>0){
// 		$total_headline_rows = mysqli_fetch_assoc($query_run)['H'];
// 	}
// }

// $total_crime_rows = 0;
// $query = "SELECT COUNT(`Id`) AS `C` FROM `Location`"; 
// if($query_run = mysqli_query($con, $query)){
// 	if(mysqli_num_rows($query_run)>0){
// 		$total_crime_rows = mysqli_fetch_assoc($query_run)['C'];
// 	}
// }

// $total_location_rows = 0;
// $query = "SELECT COUNT(`Id`) AS `L` FROM `Crime Dict`"; 
// if($query_run = mysqli_query($con, $query)){
// 	if(mysqli_num_rows($query_run)>0){
// 		$total_location_rows = mysqli_fetch_assoc($query_run)['L'];
// 	}
// }


//write efficient query processing  (see check.php)
// $query_headline = "SELECT `Id`,`Title` FROM `Headline`";
// $query_headline_run = mysqli_query($con, $query_headline);
// while ($rowHeadline = mysqli_fetch_assoc($query_headline_run))
// {
// 	$headline = strtolower($rowHeadline["Title"]);
// 	$headline_id = $rowHeadline["Id"];
// 	$query_crime = "SELECT `Id`,`Type` FROM `Crime Dict`";
// 	$query_crime_run = mysqli_query($con, $query_crime);
// 	while ($rowCrime = mysqli_fetch_assoc($query_crime_run))
// 	{
// 		$crime = strtolower($rowCrime["Type"]);
// 		$crime = " ".$crime." ";
// 		$crime_id= $rowCrime["Id"];	
// 		if(strpos($headline, $crime))
// 		{
// 			$query_location = "SELECT `Id`,`Name` FROM `Location`";
// 			$query_location_run = mysqli_query($con, $query_location);
// 			while ($rowLocation = mysqli_fetch_assoc($query_location_run))
// 			{
// 				$location=strtolower($rowLocation["Name"]);
// 				$location=" ".$location." ";
// 			    $location_id=$rowLocation["Id"];
// 				if(strpos($headline, $location))
// 				{
// 					$crime='"'.$crime.'"';
// 					$location='"'.$location.'"';
// 					$query_insertion ="INSERT INTO  crime_details(headline,crime,location) VALUES ($headline,$crime ,$location)";
// 				    mysqli_query($con, $query_insertion);
// 					break 1;
// 				}
					
// 			}
													
// 		}
// 	}
// }



$query_headline = "SELECT `Id`,`Title`,`Url` FROM `Headline`";
$query_headline_run = mysqli_query($con, $query_headline);
while ($rowHeadline = mysqli_fetch_assoc($query_headline_run))
{
	$headline = strtolower($rowHeadline["Title"]);
	$headline_id = $rowHeadline["Id"];
	$url = $rowHeadline["Url"];
	$query_crime = "SELECT `Id`,`Type` FROM `Crime Dict`";
	$query_crime_run = mysqli_query($con, $query_crime);
	while ($rowCrime = mysqli_fetch_assoc($query_crime_run))
	{
		$crime = strtolower($rowCrime["Type"]);
		$crime = " ".$crime." ";
		$crime_id= $rowCrime["Id"];	
		if(strpos($headline, $crime))
		{
			
			
				
					
					
					$query_insertion ="INSERT INTO  headline_crimes_2(headline,url,headline_id) VALUES ($headline,$url,$headline_id)";
				    mysqli_query($con, $query_insertion);
					break;
				
					
			
													
		}
	}
}






/*
echo "<pre>";
print_r($location);
echo "</pre>";
*/

echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>