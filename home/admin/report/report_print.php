<?php
//error_reporting(E_ERROR | E_PARSE);
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
	<script type="text/javascript" src="js/Chart.js"></script>

	<script type="text/javascript" src="js/itemReport_print.js"></script>
	<script type="text/javascript" src="js/saleReport_print.js"></script>

	<script type="text/javascript" src="../../assets/css/bootstrap/bootstrap.min.js"></script>
	<style type="text/css" media="print">
		body { blue;margin: 10mm 8mm 10mm 8mm;
		}
		html {background-color: #FFFFFF;margin: 0px; 
		}
		.menu_table{
			padding:2px;
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
				<a name="dashboard" id="dashboard" type="btn" title="return to Dashboard" onclick="location.href = '../admin_index.php';" class="w3-button w3-text-red w3-card w3-large w3-margin-top fa fa-arrow-left"> Back</a>
			</div>

			<div class = "col-sm-12 col-lg-8 col-md-3 w3-padding" id ="container">
				<div class="col-lg-12 w3-light-grey w3-margin w3-padding-small" id="item_report_info">
					<div class="col-lg-2"></div>
					
					<div class="col-lg-2 ">
						<label class="">Menu Item: </label><input class="form-control" type="text" name="print_item" id="print_item" value="<?php echo $_GET['ReportPrint_menu'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date From: </label><input class="form-control" type="text" name="print_itemFrom" id="print_itemFrom" value="<?php echo $_GET['report_fromDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date To: </label><input class="form-control" type="text" name="print_itemTo" id="print_itemTo" value="<?php echo $_GET['report_toDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 " style="margin-top: 20px;">
						<button class="btn w3-button w3-red" name="getItemPrint_btn" id="getItemPrint_btn" >Get Item Chart</button>
					</div>
					
					<div class="col-lg-2"></div>
				</div>
				<div class="col-lg-12 w3-light-grey w3-margin w3-padding-small" id="sale_report_info">
					<div class="col-lg-2"></div>					
					<div class="col-lg-2"></div>					
					
					<div class="col-lg-2 ">
						<label class="">Date From: </label><input class="form-control" type="text" name="print_saleFrom" id="print_saleFrom" value="<?php echo $_GET['report_fromDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date To: </label><input class="form-control" type="text" name="print_saleTo" id="print_saleTo" value="<?php echo $_GET['report_toDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 " style="margin-top: 20px;">
						<button class="btn w3-button w3-red" name="getSalePrint_btn" id="getSalePrint_btn" >Get Sale Chart</button>
					</div>
					
					<div class="col-lg-2"></div>
				</div>
				<div id="Item_graph_data" class="w3-margin-bottom" style="display: none;">
					<h4 class="w3-center w3-large" id="Item_Report_title"></h4>
					<canvas id="Item_Report_Chart" width="500px" height="150px"></canvas>
					<div id="Item_chart_img" width="500px" height="100px" ></div>
				</div>
				<div id="Sale_graph_data" class="w3-margin-bottom" style="display: none;">
					<h4 class="w3-center w3-large" id="Sale_Report_title"></h4>
					<canvas id="Sale_Report_Chart" width="500px" height="150px"></canvas>
					<div id="Sale_chart_img" width="500px" height="100px" ></div>
				</div>

				<div class="col-lg-12" style="">
					<label class="w3-large"><i class="fa fa-money"></i> Menuitem Ranks</label>
					<div >
						<div class="w3-col l6 s6" style="padding: 0 10px 0 10px">
							<label class="w3-small w3-text-grey"><i class="fa fa-thumbs-up"></i> TOP 5 Items(Non-A/c)</label>
							<?php 
							$sql="SELECT * FROM menu_items WHERE status='0' AND visible='1' ORDER BY ordered_count DESC LIMIT 5";
							$result = mysqli_query($conn,$sql);
							$count=0;    
							echo '<table class="table table-striped w3-white table-bordered table-condensed" style="margin-top: 0px">';   
							while($row = mysqli_fetch_array( $result))
							{
								$count++;
								echo '
								<tr class="w3-small">
									<td class="w3-center">'.$count.'</td>
									<td class="w3-center">'.$row['item_name'].'</td>
									<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
								</tr>
								';
							}
							echo '</table>';
							?>
						</div>
						<div class="w3-col l6 s6" style="padding: 0 10px 0 10px">
							<label class="w3-small w3-text-grey"><i class="fa fa-thumbs-up"></i> TOP 5 Items(A/c)</label>
							<?php 
							$sql="SELECT * FROM menu_items WHERE status='1' AND visible='1' ORDER BY ordered_count DESC LIMIT 5";
							$result = mysqli_query($conn,$sql);
							$count=0;    
							echo '<table class="table table-striped table-condensed w3-white table-bordered" style="margin-top: 0px">';   
							while($row = mysqli_fetch_array( $result))
							{
								$count++;
								echo '
								<tr class="w3-small">
									<td class="w3-center">'.$count.'</td>
									<td class="w3-center">'.$row['item_name'].'</td>
									<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
								</tr>
								';
							}
							echo '</table>'; 
							?>
						</div>
						<div class="w3-col l6 s6" style="padding: 0 10px 0 10px">
							<label class="w3-small w3-text-grey"><i class="fa fa-thumbs-down"></i> LOWEST 5 Items(Non-A/c)</label>
							<?php 
							$sql="SELECT * FROM menu_items WHERE status='0' AND visible='1' ORDER BY ordered_count LIMIT 5";
							$result = mysqli_query($conn,$sql);
							$count=0;    
							echo '<table class="table table-striped w3-white table-condensed table-bordered" style="margin-top: 0px">';   
							while($row = mysqli_fetch_array( $result))
							{
								$count++;
								echo '
								<tr class="w3-small">
									<td class="w3-center">'.$count.'</td>
									<td class="w3-center">'.$row['item_name'].'</td>
									<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
								</tr>
								';
							}
							echo '</table>'; 
							?>
						</div>
						<div class="w3-col l6 s6" style="padding: 0 10px 0 10px">
							<label class="w3-small w3-text-grey"><i class="fa fa-thumbs-down"></i> LOWEST 5 Items(A/c)</label>
							<?php 
							$sql="SELECT * FROM menu_items WHERE status='1' AND visible='1' ORDER BY ordered_count LIMIT 5";
							$result = mysqli_query($conn,$sql);
							$count=0; 
							echo '<table class="table table-striped w3-white table-condensed table-bordered" style="margin-top: 0px">';   
							while($row = mysqli_fetch_array( $result))
							{
								$count++;
								echo '
								<tr class="w3-small">
									<td class="w3-center">'.$count.'</td>
									<td class="w3-center">'.$row['item_name'].'</td>
									<td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
								</tr>
								';
							}
							echo '</table>'; 
							?>
						</div>
					</div>
					

				</div>	
				

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