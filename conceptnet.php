<?php
ini_set('max_execution_time', 86400);
ini_set('memory_limit', '2048M');

include 'connect.inc.php';
echo 'Start - 0.00s<br/>';
$time = microtime(true);
// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);

$context = stream_context_create($opts);
// Open the file using the HTTP headers set above
$new_crime_words=array();

$query_crime = "SELECT `Type` FROM `crime_dict_normalised`";
$query_crime_run = mysqli_query($con, $query_crime);
while ($rowCrime = mysqli_fetch_assoc($query_crime_run))
{
	$crime = strtolower($rowCrime["Type"]);
	//$crime ="background check";
	$crime = str_replace(" ", "_", $crime);
	$url='http://conceptnet5.media.mit.edu/data/5.3/search?rel=/r/Synonym&start=/c/en/'.$crime.'/';
    //$url='http://conceptnet5.media.mit.edu/data/5.3/search?rel=/r/Synonym&start=/c/en/background_check/';
	$file = json_decode(file_get_contents($url, false, $context),true);//to get an associative array back
	//echo $file;
	//var_dump($file);
	//echo $file['edges'][0]['end']."<br/>";
	//echo $file['numFound']."<br/>";
	echo $crime."====>"."<br/>";
	for ($i=0; $i < $file['numFound'] ; $i++)
	 { 
		# code...
		$str=explode("/",$file['edges'][$i]['end']);
		$str=$str[3];
		//make list of things to be replaced
		$str= str_replace("_", " ", $str);
		$str= str_replace("-", " ", $str);
		//echo $str."<br/>";
		$flag=0;
		$query= "SELECT `Type` FROM `crime_dict_normalised`";
		$query_run = mysqli_query($con, $query);
		while ($row = mysqli_fetch_assoc($query_run))
		{
			if (strcmp($row["Type"],$str)==0) {
				# code...
				//that is both string are same
				$flag=1;
				break;
			}
			else{
				
				continue;
			}
		}
		if($flag==0){
			 $str='"'.$str.'"';
			 $insertion ="INSERT INTO  conceptnet_dict_modified(Type) VALUES ($str)";
           	 mysqli_query($con, $insertion);
			//echo $str."<br/>";

		}
		
		//array_push($new_crime_words, $str);
		//match to crime_dict_normalised and if not found then write to a file
	}
	// echo "<pre>";
	// print_r($file);
	// echo "</pre>";
	//echo "==================="."<br/>";
	//break;
	//echo $url."<br/>";
}

echo "<br/>Time Elapsed: ".(microtime(true) - $time)."s";


?>