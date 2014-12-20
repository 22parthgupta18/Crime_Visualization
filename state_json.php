<?php
//this file is to convert data coming from database to json format manually .
header('Content-Type: application/json');//The MIME media type for JSON text is application/json.
ini_set('max_execution_time', 86400); // 1 - day
ini_set('memory_limit', '2048M');
//echo 'Start - 0.00s<br/>';
$time = microtime(true);

include 'connect.inc.php';




$response='[';



			$query = "SELECT `Id`,`Total_Crime` FROM crime_state";
			if($query_run = mysqli_query($con, $query)){
				if(mysqli_num_rows($query_run)>0){
					while ($row = mysqli_fetch_assoc($query_run)){
						$stateid = $row['Id'];
						$counter = '"'.$row['Total_Crime'].'"';//weights of crime counter
						if($stateid<10){
							$stateid =00 . $stateid ;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}
						if($stateid >= 10 AND $stateid <=24)
						{
							$stateid=$stateid+1;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}
						if($stateid >= 26 AND $stateid <=31)
						{
							
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}
						if($stateid==25 )
						{
							$stateid=10;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}
						if($stateid==32 )
						{
							$stateid=36;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}if($stateid==33 )
						{
							$stateid=32;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}if($stateid==34 )
						{
							$stateid=33;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}if($stateid==35 )
						{
							$stateid=34;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}if($stateid==36 )
						{
							$stateid=35;
							$stateid =0 . $stateid;//we get string 
							$response .= '{"id":"'.$stateid.'","value":"'.$counter.'"},';
						}



					}
				}
			}
		
$response = substr($response, 0, strlen($response)-1);
$response .=']';
$response=preg_replace("@[\\r|\\n|\\t]+@", "", $response);
echo $response;//json encode adding / before "
//json_encode is a convenience method to convert an array into JSON format  <- remember



//echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>