<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');

include 'connect.inc.php';
echo 'Start - 0.00s<br/>';
$time = microtime(true);


$query_boilerpipe = "SELECT `Id`,`Location` FROM `headline_boilerpipe_location`";
$query_boilerpipe_run = mysqli_query($con, $query_boilerpipe);
while ($rowBoilerpipe = mysqli_fetch_assoc($query_boilerpipe_run))
{
	$headline="";
	$crime_word="";
	$headline_id = $rowBoilerpipe["Id"];
	$headline_location = $rowBoilerpipe["Location"];
	$query_crime = "SELECT `headline`,`headline_id` FROM `headline_crimes_2` WHERE `id`=".$headline_id."";
	$query_crime_run = mysqli_query($con, $query_crime);
	if ($rowCrime = mysqli_fetch_assoc($query_crime_run))
	{
		$actual_id=$rowCrime["headline_id"];
		$headline= strtolower($rowCrime["headline"]);
		$query_word = "SELECT `Crime_Word` FROM `headline_crime_word` WHERE `Id`=".$headline_id."";
		$query_word_run = mysqli_query($con, $query_word);
		if ($rowWord = mysqli_fetch_assoc($query_word_run))
		{
			$crime_word= strtolower($rowWord["Crime_Word"]);
			$headline='"'.$headline.'"';
			$headline_location='"'.$headline_location.'"';
			$crime_word='"'.$crime_word.'"';
			
			$query_post = "SELECT `StartTime`,`EndTime`,`SourceId` FROM `post` WHERE `HeadlineId`=".$actual_id."";
			$query_post_run = mysqli_query($con, $query_post);
			if ($rowPost = mysqli_fetch_assoc($query_post_run))
			{
				$start_time="'".$rowPost["StartTime"]."'";
				$end_time="'".$rowPost["EndTime"]."'";
				$source_id=$rowPost["SourceId"];
				$query_insertion ="INSERT INTO  main_table(Headline,Location,Crime,StartTime,EndTime,SourceId) VALUES ($headline,$headline_location,$crime_word,$start_time,$end_time,$source_id)";
				mysqli_query($con, $query_insertion);
				//echo $headline."-->".$crime_word."--->".$headline_location."--->".$start_time."--->".$end_time."--->".$source_id;
				//break;
			}
			
			
		}		
	}
	//break;
}




















?>