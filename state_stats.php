<?php
//this file is to convert data coming from database to json format manually .

ini_set('max_execution_time', 86400); // 1 - day
ini_set('memory_limit', '2048M');
echo 'Start - 0.00s<br/>';
$time = microtime(true);

include 'connect.inc.php';

//ALTER TABLE `final_table_2` ADD `state_id` INT(11) NOT NULL ;
//SELECT COUNT(`State_Id`) FROM `final_table_2` WHERE `State_Id` > 0
$query_final2="SELECT `Loc_Id`,SUM(`Counter`) AS `Total_Crime` FROM `final_table_2`WHERE `Counter` > 0 GROUP BY `Loc_Id` ";//where clause in mysql 
$query_final2_run=mysqli_query($con, $query_final2);
while ($rowFinal2 = mysqli_fetch_assoc($query_final2_run))
{
	$locid=$rowFinal2["Loc_Id"];
	
	$counter=$rowFinal2["Total_Crime"];
	//echo "<br/>".$locid."--->".$counter."<br/>";
	$query="SELECT `State` FROM `location` WHERE Id=".$locid."";//where clause in mysql 
	$query_query=mysqli_query($con, $query);
	if ($rowQuery = mysqli_fetch_assoc($query_query))
	{
		//$state='"'.trim($rowQuery["State"]).'"';
		//echo "<br/>".$locid."--->".$counter."--->".$state."<br/>";
		$state=trim($rowQuery["State"]);
		$query_stateid_update ="UPDATE  crime_state SET Total_Crime=Total_Crime+".$counter." WHERE State='".$state."'";
		mysqli_query($con, $query_stateid_update);
	}
}





echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>