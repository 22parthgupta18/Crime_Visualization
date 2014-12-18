<?php
//this file is to convert data coming from database to json format manually .

ini_set('max_execution_time', 86400); // 1 - day
ini_set('memory_limit', '2048M');


include 'connect.inc.php';
//include 'locations.php';
//include 'crimes.php'; 

$total_rows = 0;
$query = "SELECT COUNT(`Id`) AS `C` FROM `final_table_2` WHERE `Counter` > 0";
if($query_run = mysqli_query($con, $query)){
	if(mysqli_num_rows($query_run)>0){
		$total_rows = mysqli_fetch_assoc($query_run)['C'];
	}
}

$crime_id = 0;
if(isset($_GET['crime']) && !empty($_GET['crime'])){
	$crime = mysqli_real_escape_string($con, htmlentities($_GET['crime']));
	if(strlen($crime) > 0){
		$query = "SELECT `Id` FROM `crime dict` WHERE `Type` = '".$crime."'";
		if($query_run = mysqli_query($con, $query)){
			if(mysqli_num_rows($query_run)>0){
				$crime_id = mysqli_fetch_assoc($query_run)['Id'];
			}
		}
	}
}

$state = "";
if(isset($_GET['state']) && !empty($_GET['state'])){
	$state = mysqli_real_escape_string($con, htmlentities(urldecode($_GET['state'])));
}

//below for handling ajax call for param parameter
if(isset($_GET['param']) && !empty($_GET['param'])){
	
	$param = $_GET['param'];
	$response = '{';//since we need to send the data in JSON Format
	$ctr = 0;
	switch ($param) {

		case 'Pop_Crim_Loc'://see in Map API heat map generating function  like getLocation()

		for($i=0; $i<$total_rows/1000; $i++){
			$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `final_table_2` GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
			if($query_run = mysqli_query($con, $query)){
				if(mysqli_num_rows($query_run)>0){
					while ($row = mysqli_fetch_assoc($query_run)){
						$loc_id = $row['Loc_Id'];
						$counter = $row['Quantity'];//weights of crime counter
						$query2 = "SELECT `Name`, `Lat`, `Lng` FROM `location` WHERE `Id`='".$loc_id."' AND `Id` > 36";//only non states ,why?
						if($query_run2 = mysqli_query($con, $query2)){
							if(mysqli_num_rows($query_run2)>0){
								while ($row2 = mysqli_fetch_assoc($query_run2)){
									$location = $row2['Name'];
									$lat = $row2['Lat'];
									$lng = $row2['Lng'];//no use of crime counter as weights
									$response .= '"'.$ctr++.'" : {"lat" : "'.$lat.'", "lng" : "'.$lng.'","counter" : "'.$counter.'"},';//$response contains data in JSON format and also we are updating ctr.
								}
							}
						}
					}
					$response = substr($response, 0, strlen($response)-1);//removing the last comma of the json
				}
			}
		}

		break;

		// case 'Pop_Crim_State':

		// for($i=0; $i<$total_rows/1000; $i++){
		// 	$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `final_table_2` GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
		// 	if($query_run = mysqli_query($con, $query)){
		// 		if(mysqli_num_rows($query_run)>0){
		// 			while ($row = mysqli_fetch_assoc($query_run)){
		// 				$loc_id = $row['Loc_Id'];
		// 				$counter = $row['Quantity'];
		// 				$query2 = "SELECT `Name`, `Lat`, `Lng`, `State` FROM `location` WHERE `Id`='".$loc_id."' AND `Id` <= 36";
		// 				if($query_run2 = mysqli_query($con, $query2)){
		// 					if(mysqli_num_rows($query_run2)>0){
		// 						while ($row2 = mysqli_fetch_assoc($query_run2)){
		// 							$location = $row2['Name'];
		// 							$lat = $row2['Lat'];
		// 							$long = $row2['Lng'];
		// 							$state = $row2['State'];
		// 							$response .= ('"'.$ctr++.'" : [ "'.$state.'", '.$counter.', 100 ],');
		// 						}
		// 					}
		// 				}
		// 			}
		// 			$response = substr($response, 0, strlen($response)-1);
		// 		}
		// 	}
		// }

		// break;

		case 'Crime_State_Specific':

		for($i=0; $i<$total_rows/1000; $i++){
			if( $crime_id > 0) {
				$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `final_table_2` WHERE `Crime_Id` = '".$crime_id."' GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
			} else {
				$query = "SELECT `Loc_Id`,SUM(`Counter`) AS `Quantity` FROM `final_table_2` GROUP BY `Loc_Id` HAVING `Quantity` > 0 LIMIT ".($i*1000).", 1000";
			}
			if($query_run = mysqli_query($con, $query)){
				if(mysqli_num_rows($query_run)>0){
					while ($row = mysqli_fetch_assoc($query_run)){
						$loc_id = $row['Loc_Id'];
						$counter = $row['Quantity'];
						if(strlen($state) > 0){
							$query2 = "SELECT `Name`, `Lat`, `Lng`, `State` FROM `location` WHERE `Id`='".$loc_id."' AND `Id` > 36 AND `State`='".$state."'";
						} else {
							$query2 = "SELECT `Name`, `Lat`, `Lng`, `State` FROM `location` WHERE `Id`='".$loc_id."' AND `Id` > 36";
						}
						
						
						if($query_run2 = mysqli_query($con, $query2)){
							if(mysqli_num_rows($query_run2)>0){
								while ($row2 = mysqli_fetch_assoc($query_run2)){
									$location = $row2['Name'];
									$lat = $row2['Lat'];
									$lng = $row2['Lng'];
									$response .= '"'.$ctr++.'" : {"lat" : "'.$lat.'", "lng" : "'.$lng.'"},';
								}
							}
						}
					}
					$response = substr($response, 0, strlen($response)-1);
				}
			}
		}

		break;
		
		default:
			# code...
		break;
	}
	$response .= '}';
	echo $response;//send as ajax response
	//http://127.0.0.1/crime_visualization/RequestHandler.php?param=Pop_Crim_Loc
}

//header("Content-Type: text/plain");

?>