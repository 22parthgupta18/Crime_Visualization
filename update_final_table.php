<?php
//this file is to convert data coming from database to json format manually .

ini_set('max_execution_time', 86400); // 1 - day
ini_set('memory_limit', '2048M');
echo 'Start - 0.00s<br/>';
$time = microtime(true);

include 'connect.inc.php';

//ALTER TABLE `final_table_2` ADD `state_id` INT(11) NOT NULL ;
//SELECT COUNT(`State_Id`) FROM `final_table_2` WHERE `State_Id` > 0
$query_final2="SELECT  `Loc_Id`,`State_Id` FROM `final_table_2`";//where clause in mysql 
$query_final2_run=mysqli_query($con, $query_final2);
while ($rowFinal2 = mysqli_fetch_assoc($query_final2_run))
{
	$locid=$rowFinal2["Loc_Id"];
	
	$stateid=$rowFinal2["State_Id"];//0
	// if($locid < 37)
	// {
	// 	echo "<br/>".$locid."<br/>";
	// }
	if($stateid==0)
	{
	if($locid < 37)
	{
		$stateid=$locid;
		$query_stateid_update ="UPDATE  final_table_2 SET State_Id='$stateid' WHERE Loc_Id='$locid'";
		mysqli_query($con, $query_stateid_update);
	}
	else
	{
		$query="SELECT `State` FROM `location` WHERE Id='$locid'";//where clause in mysql 
		$query_query=mysqli_query($con, $query);
		if ($rowQuery = mysqli_fetch_assoc($query_query))
		{
			$state=$rowQuery["State"];
			$query_crime_state="SELECT `Id` FROM `crime_state` WHERE State='$state'";//where clause in mysql 
			$query_crime_state_run=mysqli_query($con, $query_crime_state);
			if ($rowCrime = mysqli_fetch_assoc($query_crime_state_run))
			{
				$stateid=$rowCrime["Id"];
				$query_stateid_update ="UPDATE  final_table_2 SET State_Id='$stateid' WHERE Loc_Id='$locid'";
				mysqli_query($con, $query_stateid_update);
			}
		}
	}
	}
}





echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";
?>