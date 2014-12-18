<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');

include 'connect.inc.php';
echo 'Start - 0.00s<br/>';
$time = microtime(true);

// $query ="SELECT  `Id`,`Headline` FROM `final_table` WHERE id=1";
// $query_run=mysqli_query($con, $query);
// $row=  mysqli_fetch_assoc($query_run);
// $id=$row["Id"];
// $headline='"'.strtolower($row["Headline"]).'"';
// $query_insertion ="INSERT INTO  `unique_headlines`(Headline,Headline_Id) VALUES ($headline,$id)";
// mysqli_query($con, $query_insertion);

$query_final="SELECT  `Id`,`Headline` FROM `final_table`";//where clause in mysql 
$query_final_run=mysqli_query($con, $query_final);
//$f=0;
while ($rowFinal = mysqli_fetch_assoc($query_final_run))
{
	$j=0;
	$id_final=$rowFinal["Id"];
	$headline_final=strtolower($rowFinal["Headline"]);
	$query_unique = "SELECT `Headline` FROM `unique_headlines`";
	$query_unique_run = mysqli_query($con, $query_unique);
	//echo "<br/>-------->".++$f."<br/>";
	while ($rowUnique = mysqli_fetch_assoc($query_unique_run))
	{
		$headline_unique=$rowUnique["Headline"];
		//$length=max(strlen($headline_unique),strlen($headline_final));
		//echo $headline_unique;
		similar_text($headline_final, $headline_unique,$percent);//try other related to levenshetin ie similar_text
		if(($percent)>50)
		{	
			$j=1;
		}
		
	}
	if($j==0)
	{
		$headline_final='"'.$headline_final.'"';
		$query_unique_insertion ="INSERT INTO  `unique_headlines`(Headline,Headline_Id) VALUES ($headline_final,$id_final)";
		mysqli_query($con, $query_unique_insertion);
		//echo "<br/>insert ".$f."<br/>";
	}
}

echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";

?>