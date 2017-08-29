<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once("../../db_conn/conn.php");

date_default_timezone_set('Asia/Kolkata');

?>

<html monomarginboxes mozdisallowselectionprint>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Print Menu Item Report</title>
	<link rel="stylesheet" href="../../assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/font awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../../assets/css/font awesome/font-awesome.css">
	<link rel="stylesheet" href="../../assets/css/w3.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/alert/jquery-confirm.css">
	<script type="text/javascript" src="../../assets/css/bootstrap/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/Chart.min.js"></script>
	<script type="text/javascript" src="js/chartist.min.js"></script>
	<script type="text/javascript" src="js/itemReport.js"></script>
	<script type="text/javascript" src="js/itemReport_print.js"></script>
	<script type="text/javascript" src="js/Chart.js"></script>
	<script type="text/javascript" src="../../assets/css/bootstrap/bootstrap.min.js"></script>
	<style type="text/css" media="print">
		body { blue;margin: 10mm 8mm 10mm 8mm;
		}
		html {background-color: #FFFFFF;margin: 0px; 
		}


		@page {size:auto letter; 
			margin: 0mm; }

		</style>

		<script>

			function printdiv(printpage)
			{
				var headstr = "<html><head></head><body>";

				var footstr = "</body>";

				var newstr = document.all.item(printpage).innerHTML;

				var oldstr = document.body.innerHTML;
				document.body.innerHTML = headstr+newstr+footstr;
				window.print();
				document.body.innerHTML = oldstr;
				return false;


			}
		</script>

	</head>

	<body style="font-family:Segoe UI;letter-spacing:1px;">		
		<div>           
			<div class = "col-sm-1 col-lg-2 col-md-1 "> 
			<a name="dashboard" id="dashboard" type="btn" title="return to Dashboard" onclick="location.href = '../admin_index.php';" class="w3-button w3-text-red w3-card w3-large w3-margin-top fa fa-print"> Back</a>
			</div>

			<div class = "col-sm-12 col-lg-8 col-md-3 w3-padding" id ="container">
				<div class="col-lg-12 w3-light-grey w3-margin w3-padding-small" id="report_info">
					<div class="col-lg-2"></div>
					
					<div class="col-lg-2 ">
						<label class="">Menu Item: </label><input class="form-control" type="text" name="print_item" id="print_item" value="<?php echo $_GET['Report_menu'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date From: </label><input class="form-control" type="text" name="print_itemFrom" id="print_itemFrom" value="<?php echo $_GET['item_fromDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date To: </label><input class="form-control" type="text" name="print_itemTo" id="print_itemTo" value="<?php echo $_GET['item_toDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 " style="margin-top: 20px;">
						<button class="btn w3-button w3-red" name="getItemPrint_btn" id="getItemPrint_btn" >Get Chart</button>
					</div>
					
					<div class="col-lg-2"></div>
				</div>
				<div id="graph_data" class="w3-margin-bottom" style="display: none;">
					<h4 class="w3-center w3-large" id="Report_title"></h4>
					<canvas id="Report_Chart" width="500px" height="200px"></canvas>
					<div id="chart_img" width="500px" height="200px" ></div>
				</div>	
				<label class="w3-large w3-margin-top"><i class="fa fa-money"></i> Menuitem (<?php echo $_GET['Report_menu'] ?>) Ordered Per day [<?php echo $_GET['item_fromDate']." to ".$_GET['item_toDate'] ?>]</label>
				<table class="table table-bordered table-striped table-responsive col-md-6 " style="font-size: 12px">
					<tr>
						<td class="w3-center" style="font-weight: bold;">Sr.No</td>
						<td class="w3-center" style="font-weight: bold;">Dated</td>
						<td class="w3-center" style="font-weight: bold;">Ordered Count</td>
					</tr>
					<?php
					$from = $_GET['item_fromDate'];
					$to  = $_GET['item_toDate'];
					$item = $_GET['Report_menu'];

					$date1=date_create($from);
					$date2=date_create($to );
					$diff=date_diff($date1,$date2);
					$between_dates=$diff->format("%a");
					$between_dates += 1;


					$count = "0";
					$srno="0";
					$items_array = array();

					for($i=0;$i<$between_dates;$i++){

						$sql1 = "SELECT * FROM order_table WHERE  date_time = '$from'";
						$result1 = mysqli_query($conn,$sql1);
						while($row1 = mysqli_fetch_array($result1)){
               // echo $row1['date_time'];

							$ordered_items  = $row1['ordered_items'];
							$order_array=json_decode($ordered_items,true);

							foreach($order_array as $k)
							{  
								if($k['item_name'] == $item)
								{
									$count = $count + $k['quantity'];

								} 
							}
						}
						$items_array[] = array(
							'date'=>$from,
							'count'=>$count
							);
						$count = "0";

						$dateincrement = strtotime("+1 day", strtotime($from));
						$from = date("Y-m-d", $dateincrement);    
						if($from > $to){
							break;
						}

					}
					foreach ($items_array as $key) {
						if($key['count']==0){}
							else{
								$srno++;
								echo '
								<tr>
									<td class="w3-center" style="">'.$srno.'</td>
									<td class="w3-center">'.$key['date'].'</td>

									<td class="w3-center">'.$key['count'].' <i>times</i></td>
								</tr>
								';
							}
						}
						?>

					</table>			
				</div>

				<div class = "col-sm-1 col-lg-2 col-md-1" id="print_action" style="display: none;">

					<a name="sale_print" id="sale_print" type="btn btn-default" title="Print Report" onclick="javascript:printdiv('container');" class="w3-button w3-text-red w3-card w3-large w3-margin-top fa fa-print"> Print</a>

				</div>
			</div>
			<?php
			mysqli_close($conn);
			?>

		</body>
		</html>