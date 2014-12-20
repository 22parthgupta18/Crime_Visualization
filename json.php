<?php
//this file is to convert data coming from database to json format manually .
header('Content-Type: application/json');//The MIME media type for JSON text is application/json.
ini_set('max_execution_time', 86400); // 1 - day
ini_set('memory_limit', '2048M');
//echo 'Start - 0.00s<br/>';
$time = microtime(true);

include 'connect.inc.php';

$total_rows = 0;
$query = "SELECT COUNT(`Id`) AS `C` FROM `final_table_2` WHERE `Counter` > 0";//2210
if($query_run = mysqli_query($con, $query)){
	if(mysqli_num_rows($query_run)>0){
		$total_rows = mysqli_fetch_assoc($query_run)['C'];
	}
}



$response='eqfeed_callback({
	"type":"FeatureCollection",
	"features":[';


//access by following url
//http://127.0.0.1/crime_visualization/json.php?param=Pop_Crim_Loc
if(isset($_GET['param']) && !empty($_GET['param']))
{
	$param = $_GET['param'];
	$tag='Pop_Crim_Loc';
	if(!strcasecmp($param,$tag))
	{


for($i=0; $i<$total_rows/1000; $i++){
			//SELECT SUM(`Counter`) AS `Quantity` FROM `final_table_2` GROUP BY `Loc_Id` HAVING `Quantity` > 0 ORDER BY SUM(`Counter`) DESC
			$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `final_table_2` GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
			if($query_run = mysqli_query($con, $query)){
				if(mysqli_num_rows($query_run)>0){
					while ($row = mysqli_fetch_assoc($query_run)){
						$loc_id = $row['Loc_Id'];
						$counter = $row['Quantity'];//weights of crime counter
						$query2 = "SELECT `Name`, `Lat`, `Lng` FROM `location` WHERE `Id`=".$loc_id."";
						if($query_run2 = mysqli_query($con, $query2)){
							if(mysqli_num_rows($query_run2)>0){
								while ($row2 = mysqli_fetch_assoc($query_run2)){
									$location = $row2['Name'];
									$lat = $row2['Lat'];
									$lng = $row2['Lng'];//no use of crime counter as weights
									$response .= '{"type":"Feature","properties":{"mag":'.$counter.'},"geometry":{"type":"Point","coordinates":['.$lng.','.$lat.']}},';
									//$response .= '"'.$ctr++.'" : {"lat" : "'.$lat.'", "lng" : "'.$lng.'","counter" : "'.$counter.'"},';//$response contains data in JSON format and also we are updating ctr.
								}
							}
						}
					}
					//$response = substr($response, 0, strlen($response)-1);//removing the last comma of the json

				}
			}
		}
}
}
$response = substr($response, 0, strlen($response)-1);
$response .=']});';
$response=preg_replace("@[\\r|\\n|\\t]+@", "", $response);
echo $response;//json encode adding / before "
//json_encode is a convenience method to convert an array into JSON format  <- remember



//echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>