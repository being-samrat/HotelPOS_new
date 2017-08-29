<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include_once("../../db_conn/conn.php");

date_default_timezone_set('Asia/Kolkata');

?>

<html monomarginboxes mozdisallowselectionprint>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Print Sales Report</title>
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
	<script type="text/javascript" src="js/saleReport_print.js"></script>
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
					<div class="col-lg-3"></div>
					
					<div class="col-lg-2 ">
						<label class="">Date From: </label><input class="form-control" type="text" name="print_saleFrom" id="print_saleFrom" value="<?php echo $_GET['sale_fromDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 ">
						<label class="">Date To: </label><input class="form-control" type="text" name="print_saleTo" id="print_saleTo" value="<?php echo $_GET['sale_toDate'] ?>" readonly>
					</div>
					<div class="col-lg-2 " style="margin-top: 20px;">
						<button class="btn w3-button w3-red" name="getSalePrint_btn" id="getSalePrint_btn" >Get Chart</button>
					</div>
					
					<div class="col-lg-3"></div>
				</div>
				<div id="graph_data" class="w3-margin-bottom" style="display: none;">
				<h4 class="w3-center w3-large" id="Report_title"></h4>
				<canvas id="Report_Chart" width="500px" height="200px"></canvas>
				<div id="chart_img" width="500px" height="200px" ></div>
				</div>	
				<label class="w3-large w3-margin-top"><i class="fa fa-money"></i> Sale Per day [<?php echo $_GET['sale_fromDate']." to ".$_GET['sale_toDate'] ?>]</label>
				<table class="table table-bordered table-striped table-responsive col-md-6 " style="font-size: 12px">
				<tr>
              <td class="w3-center" style="font-weight: bold;">Sr.No</td>
              <td class="w3-center" style="font-weight: bold;">Dated</td>
              <td class="w3-center" style="font-weight: bold;">Net Sale (<i class="fa fa-inr"></i>)</td>
            </tr>
					<?php  
					$from=$_GET['sale_fromDate'];
					$to=$_GET['sale_toDate'];
					$date1=date_create($from);
					$date2=date_create($to );
					$diff=date_diff($date1,$date2);
					$between_dates=$diff->format("%a");
					$between_dates += 1;

					$today=date("Y-m-d");

					$totalSale = "0";
					$count=0;
					for($i=0;$i<$between_dates;$i++){						
						$TotalOrderSale_sql="SELECT *,sum(revenue) FROM order_bill WHERE dated='".$from."'" ;
  					$TotalSale=mysqli_query($conn,$TotalOrderSale_sql);//-------------------get total sum of todays sold orders  
  					while($row=mysqli_fetch_array($TotalSale))
  					{
  						if(($row['sum(revenue)'])==NULL){
  							$totalSale=0;

  						}
  						else{
  							$count++;
  							$totalSale=$row['sum(revenue)'];
  							echo '
  							<tr>
  								<td class="w3-center" style="">'.$count.'</td>
  								<td class="w3-center">'.$row['dated'].'</td>

  								<td class="w3-center">'.$totalSale.' <i class="fa fa-inr"></i></td>
  							</tr>
  							';
  						}
  					}

  					$dateincrement = strtotime("+1 day", strtotime($from));
  					$from = date("Y-m-d", $dateincrement);    
  					if($from > $to){
  						break;
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