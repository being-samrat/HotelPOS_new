<?php
include_once("db_conn/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>HOTEL POS</title>
	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="assets/css/w3.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<script type="text/javascript" src="assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="Chart.js"></script>
	<script type="text/javascript" src="assets/css/bootstrap/bootstrap.min.js"></script>
	<style type="text/css">
		.table_view{
			background-image: url(admin/adminImg/empty.png);
			background-size: 40px;
			background-repeat: no-repeat;
			background-position: left;
			background-origin: content-box;
			padding-top:15px;
		}
	</style>

</head>
<body style="background-color: #E4E4E4">
	<!-- Top container -->
	<select class="form-control w3-col 4 w3-margin-bottom" name="menuitem" style="width:100px;" id="menuitem">
		<option class="w3-red" selected><b>Select Table</b></option>
		<?php                 
		$sqlmenu="SELECT * FROM menu_items WHERE visible=1";
		$menuresult=mysqli_query($conn,$sqlmenu);

		while($menuresultrow = mysqli_fetch_array( $menuresult))
		{
			echo '<option value="'.$menuresultrow['item_name'].'">'.$menuresultrow['item_name'].'</option>';
		}   
		?>  
	</select>
	<input type="date" name="from" id="from"> TO 
	<input type="date" name="to" id="to"> 
	<input type="submit" name="getrep" id="getrep">
	<input type="text" name="values" id="values" >
	<canvas id="myChart" width="400px" height="400px"></canvas>

	<div id="dates"></div>
	<div id="values"></div>

<!-- 	<script>
// SELECT BOX DEPENDENCY CODE
$(document).ready(function()
{
	$("#getrep").click(function(){  
		var from = $("#from").val();  
		var to = $("#to").val();  
		var menuitem = $("#menuitem").val();  
		var data = {
			from:from,
			to:to,
			menuitem:menuitem
		};

		$.ajax({  
			url:"insert.php",  
			method:"POST",  
			cache:false,
			data:data,  
			success:function(data)  
			{  
            //$('#search_foodList').fadeIn();  
            $("#values").val(data);

			var chartdata={
				labels: 'Item count',
				datasets: [{
				label: '# of Votes',
				data: [4,5,5],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
			};
			var ctx = document.getElementById("myChart").getContext('2d');
			var Graph=new Chart(ctx,{
				type:'line',
				data:chartdata
			});
        }  
    });  

	});
});
</script> -->
<script>
function chart(yaxis){
	var ctx = document.getElementById("myChart").getContext('2d');
	//var y = $("#values").val(); 
	alert(yaxis); 
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["Red", "Blue", "Yellow"],
			datasets: [{
				label: '# of Votes',
				data: yaxis,
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
}
	
</script>

</body>
</html>
