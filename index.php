<?php
include 'connect.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crime Visualization</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=geometry,visualization"></script>
	<!-- Google Maps JavaScript API v3 , loads all of the main Javascript objects and
	symbols for use in the Maps API. Some Maps API features are also available in self-contained libraries which are not loaded unless you specifically request them
	visualization provides visual representations of data, including heatmaps and Google Maps Engine data. 
	Once loaded, libraries are accessed via the google.maps.libraryName namespace. -->
	
	<!--The Heatmap Layer is part of the google.maps.visualization library, and is not loaded by default. The Visualization classes are a self-contained library, separate
	from the main Maps API JavaScript code. To use the functionality contained within this library, you must first load it using the libraries parameter in the Maps API bootstrap URL -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script>
	//To display a heatmap, we'll make use of the visualization library, which contains a HeatmapLayer class
	
	  // Handler for .ready() called.

	var crime_selected = "";
	var state_selected = "";

	/*                -----------------------    GOOGLE MAPS CODE ------------------------------            */
	var map, heatmap;

	
	function initialize() {
		
		var mapOptions = {
			zoom: 5,
			center: new google.maps.LatLng(21.1289956, 82.7792201),
			mapTypeId: google.maps.MapTypeId.HYBRID
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		//alert(1);
		google.load("visualization", "1", {packages:["geochart"], callback: visuCall});//what this does ??
		//alert(2);

	} //function initialise ends here 

	function visuCall(){
		//alert('Loaded!');
		
		//alert("visuCall");
	}

	function getLocations(){

		var mapOptions = {
			zoom: 5,
			center: new google.maps.LatLng(21.1289956, 82.7792201),
			mapTypeId: google.maps.MapTypeId.HYBRID
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var heatMapData = [];//something like ths default heatmapData array in the MAP API
		
		//below is an AJAX call to fetch data from RequestHandler.php to be used in heatmap creation
		//it also sends some extra data along the request Pop_Crim_Loc to get popular crime location from database which will be fetched in RequestHnadler.php
		$.get("RequestHandler.php", { param : 'Pop_Crim_Loc' }, function(data){

			var lat_lngs = jQuery.parseJSON(data);//Takes a well-formed JSON string and returns the resulting JavaScript value.

			//console.log(lat_lngs);
			for (var key in lat_lngs) {
				var latLng = new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng);
				var magnitude = lat_lngs[key].counter;
				var weightedLoc = {
									location: latLng,
									weight: magnitude//api error!!!
								};
			    heatMapData.push(latLng);
				//same array which is created in the eqfeed_callback in the default MAP API example
				//console.log({location: new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng), weight: lat_lngs[key].counter});
			}
			//console.log(heatMapData);
			//var pointArray = new google.maps.MVCArray(heatMapData);
			heatmap = new google.maps.visualization.HeatmapLayer({
				data: heatMapData
			});
			heatmap.setMap(map);//can do it inside

		});
		
	}

	// function getStates(){

	// 	$.get("RequestHandler.php", { param : 'Pop_Crim_State' }, function(data){

	// 		var state_object = jQuery.parseJSON(data);

	// 		var states = new google.visualization.DataTable();
	// 		states.addColumn('string', 'States');
	// 		states.addColumn('number', 'Crimes');
	// 		states.addColumn('number', 'Area');
	// 		for (var key in state_object) {
	// 			states.addRow(state_object[key]);
	// 		}

			

	// 		var options = {
	// 			region : '034',
	// 			displayMode: 'markers',
	// 			colorAxis: {colors: ['green', 'blue']}
	// 		};

	// 		var chart = new google.visualization.GeoChart(document.getElementById('map-canvas'));

	// 		chart.draw(states, options);
	// 	});

	// }

	function toggleHeatmap() {
		heatmap.setMap(heatmap.getMap() ? null : map);
	}

	function changeGradient() {
		var gradient = [
		'rgba(0, 255, 255, 0)',
		'rgba(0, 255, 255, 1)',
		'rgba(0, 191, 255, 1)',
		'rgba(0, 127, 255, 1)',
		'rgba(0, 63, 255, 1)',
		'rgba(0, 0, 255, 1)',
		'rgba(0, 0, 223, 1)',
		'rgba(0, 0, 191, 1)',
		'rgba(0, 0, 159, 1)',
		'rgba(0, 0, 127, 1)',
		'rgba(63, 0, 91, 1)',
		'rgba(127, 0, 63, 1)',
		'rgba(191, 0, 31, 1)',
		'rgba(255, 0, 0, 1)'
		]
		heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
	}

	function changeRadius() {
		heatmap.set('radius', heatmap.get('radius') ? null : 20);
	}

	function changeOpacity() {
		heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
	}

	google.maps.event.addDomListener(window, 'load', initialize)	;//Add an event listener to the window object that will call the initialize function once the page has loaded.
	/*
	Calling initialize before the page has finished loading will cause problems, since the div it's looking for may not have been created yet;
	this function waits until the HTML elements on the page have been created before calling initialize.
	*/


</script>

</head>

<body>	

	<div id="panel1">
		<button class="btn" onclick="getLocations()">Popular Criminal Locations</button>
		<!--<button class="btn" onclick="getStates()">Popular Criminal States</button>-->
		<select class="crimes btn">
			<option value="0">Select a Crime</option>
			<?php 
			$query= "SELECT `Type` FROM `crime dict`";
			$query_run = mysqli_query($con, $query);
			while ($row = mysqli_fetch_assoc($query_run))
			{
				$value=$row["Type"];
				?>
				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
			?>				
		</select>
		<select class="states btn">
			<option value="0">Select a State</option>
			<?php 
			$query= "SELECT `Id`,`Name` FROM `location` ORDER BY Id ASC LIMIT 0,36";
			$query_run = mysqli_query($con, $query);
			while ($row = mysqli_fetch_assoc($query_run))
			{
				$value=$row["Name"];
				?>
				<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
				<?php
			}
			?>				
		</select>
	</div>

	<div id="panel2">
		<button class="btn" onclick="toggleHeatmap()">Toggle Heatmap</button>
		<button class="btn" onclick="changeGradient()">Change gradient</button>
		<button class="btn" onclick="changeRadius()">Change radius</button>
		<button class="btn" onclick="changeOpacity()">Change opacity</button>
	</div>

	<div id="map-canvas"></div>

	<script type="text/javascript">

	$('.states').on('change', function(){
		if($(this).val() != 0){

			state_selected = $(this).val();

			var parameter = { param : 'Crime_State_Specific' };
			if(state_selected.length > 0){
				parameter['state'] = state_selected;
			}
			if(crime_selected.length > 0 ){
				parameter['crime'] = crime_selected;
			}
				//console.log(parameter);
				
				var mapOptions = {
					zoom: 5,
					center: new google.maps.LatLng(21.1289956, 82.7792201),
					mapTypeId: google.maps.MapTypeId.SATELLITE
				};

				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				var cityGeocode = [];

				$.get("RequestHandler.php", parameter , function(data){

					console.log(data);
					var lat_lngs = jQuery.parseJSON(data);

					//cityGeocode.push(new google.maps.LatLng(lat_lngs[i].lat, lat_lngs[i].lng));
					for (var key in lat_lngs) {
						cityGeocode.push(new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng));
					}

					var pointArray = new google.maps.MVCArray(cityGeocode);
					heatmap = new google.maps.visualization.HeatmapLayer({
						data: pointArray
					});
					heatmap.setMap(map);

				});
			} else {
				state_selected = "";
			}
		});

	$('.crimes').on('change', function(){
		if($(this).val() != 0){

			crime_selected = $(this).val();

			var parameter = { param : 'Crime_State_Specific' };
			if(state_selected.length > 0){
				parameter['state'] = state_selected;
			}
			if(crime_selected.length > 0 ){
				parameter['crime'] = crime_selected;
			}

			var mapOptions = {
				zoom: 5,
				center: new google.maps.LatLng(21.1289956, 82.7792201),
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};

			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			var cityGeocode = [];

			$.get("RequestHandler.php", parameter, function(data){

				var lat_lngs = jQuery.parseJSON(data);

						//cityGeocode.push(new google.maps.LatLng(lat_lngs[i].lat, lat_lngs[i].lng));
						for (var key in lat_lngs) {
							cityGeocode.push(new google.maps.LatLng(lat_lngs[key].lat, lat_lngs[key].lng));
						}

						var pointArray = new google.maps.MVCArray(cityGeocode);
						heatmap = new google.maps.visualization.HeatmapLayer({
							data: pointArray
						});
						heatmap.setMap(map);

					});
		} else {
			crime_selected = "";
		}
	});

</script>
</body>
</html>