<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script type="text/javascript">
$(function() {
    //console.log( "ready!" );
    $.get("json.php", { param : 'Pop_Crim_Loc' }, function(data){
    var data=jQuery.parseJSON(data);
    
    //document.write(data);
    console.log(data);
	//$(document.body).append(data);
	$('#write').append('some new text')
});//bracket proper close

});

</script>
</head>
<body>
<div id="write"></div>

</body>
</html>