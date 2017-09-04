<?php
error_reporting(E_ERROR | E_PARSE);

session_start();
if(!isset($_SESSION['admin_passwd']))
{
  header("location:../index.php");
}
?>
<?php
include_once("../db_conn/conn.php")
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Dashboard-Hotel POS</title>
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="../assets/css/w3.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="report/js/jquery.min.js"></script>
  <script type="text/javascript" src="report/js/Chart.min.js"></script>
  <script type="text/javascript" src="report/js/chartist.min.js"></script>
  <script type="text/javascript" src="report/js/itemReport.js"></script>
  <script type="text/javascript" src="report/js/saleReport.js"></script>
  <script type="text/javascript" src="report/js/Chart.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>

</head>


<body class="w3-light-grey " style="font-family:Segoe UI;letter-spacing:1px;">

  <?php 
  include("admin_navigation.php") ;
  $totalSale="0";

  $tableOccupied_sql="SELECT * FROM hotel_tables WHERE occupied='1'";//-----------------get ocuupied tables count
  $tableTotal_sql="SELECT * FROM hotel_tables";//-----------------------get total tables count
  $workerCount_sql="SELECT * FROM user_login WHERE role != 'Administrator'";//-----------------------------get total workers count except Administrator
  $today=date("Y-m-d");
  $tableTotalOrder_sql="SELECT * FROM order_bill WHERE dated='".$today."'";//------------------------get total orders placed today
  $TotalOrderSale_sql="SELECT ROUND(sum(revenue), 2) FROM order_bill WHERE dated='".$today."'" ;//-------------------get total sum of todays sold orders

  $tabOccupied=mysqli_query($conn,$tableOccupied_sql);//-----------------get ocuupied tables count
  $tab=mysqli_query($conn,$tableTotal_sql);//-----------------------get total tables count
  $today_order_res=mysqli_query($conn,$tableTotalOrder_sql);//-----------------------------get total orders placed today
  $workerCount_result=mysqli_query($conn,$workerCount_sql);//-------------------------get total workers count except Administrator
  $TotalSale=mysqli_query($conn,$TotalOrderSale_sql);//-------------------get total sum of todays sold orders
  while($row=mysqli_fetch_array($TotalSale))
  {
    $totalSale=$row['ROUND(sum(revenue), 2)'];
  }

  $tot_ocuupied_tables = mysqli_num_rows($tabOccupied);//-----------------get ocuupied tables count
  $tot_tables=mysqli_num_rows($tab);//-----------------------get total tables count
  $tot_order=mysqli_num_rows($today_order_res);//-----------------------------get total orders placed today
  $tot_worker=mysqli_num_rows($workerCount_result);//-------------------------get total workers count except Administrator

  $avg_SaleToday= $totalSale/ $tot_order//---------------------------get average sale per day
  ?>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main " style="margin-left:300px;margin-top:43px;">
    <div class="col-lg-12 col-sm-12 col-md-12" style="height: 40px"></div>
    <!-- Header -->
    <header class="w3-container " style="padding-top:22px">
      <h5><b><i class="fa fa-dashboard"></i> My Dashboard </b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
      <div class="w3-quarter">
        <div class="w3-container w3-red w3-padding-16">
          <div class="w3-left"><i class="fa fa-street-view w3-xxxlarge"></i></div>
          <div class="w3-right w3-xsmall">
            <span>Total: <?php echo $tot_tables; ?></span><br>
            <span>Occupied: <?php echo $tot_ocuupied_tables; ?></span>
          </div>
          <div class="w3-clear"></div>
          <h4>Tables</h4>
        </div>
      </div>
      <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16">
          <div class="w3-left"><i class="fa fa-signing w3-xxxlarge"></i></div>
          <div class="w3-right">
            <h3><?php echo $tot_worker; ?></h3>
          </div>
          <div class="w3-clear"></div>
          <h4>Total Workers</h4>
        </div>
      </div>
      <div class="w3-quarter">
        <div class="w3-container w3-teal w3-padding-16">
          <div class="w3-left"><i class="fa fa-diamond w3-xxxlarge"></i></div>
          <div class="w3-right">
            <h3><?php echo $tot_order; ?></h3>
          </div>
          <div class="w3-clear"></div>
          <h4>Orders Today</h4>
        </div>
      </div>
      <div class="w3-quarter">
        <div class="w3-container w3-orange w3-text-white w3-padding-16">
          <div class="w3-left"><i class="fa fa-inr w3-xxxlarge"></i></div>
          <div class="w3-right">
            <h3><?php echo round($avg_SaleToday, 2) ?></h3>
          </div>
          <div class="w3-clear"></div>
          <h4>Average Sale Today</h4>
        </div>
      </div>
    </div>

    <div class="w3-panel">
      <div class="w3-row-padding" style="margin:0 -16px">
        <div class="w3-third">
          <h5><b><i class="fa fa-mortar-board"></i> Menu Items </b></h5>
          <table class="table table-striped w3-white" style="margin-bottom: 0px">
            <tr>
              <td class="w3-center" style="font-weight: bold;">Sr.No</td>
              <td class="w3-center" style="font-weight: bold;">
                Menu Item<br>
                <select style="font-size: 12px" id="menuRank_category">
                  <option value="all_menu">All</option>
                  <option value="top_nonAC">Top-5 (Non A/c)</option>
                  <option value="top_AC">Top-5 (A/c)</option>
                  <option value="lowest_nonAC">Lowest-5 (Non A/c)</option>
                  <option value="lowest_AC">Lowest-5 (A/c)</option>
                </select>
              </td>
              <td class="text-right" style="font-weight: bold;">Ordered</td>
            </tr>
          </table>
          <table id="menu_rank" class="table table-striped w3-white" style="margin-top: 0px">
            <?php  
            $top_menu_sql="SELECT * FROM menu_items WHERE visible='1' LIMIT 5";
            $top_menu_result=mysqli_query($conn,$top_menu_sql);  
            $count=0;    
            while($row = mysqli_fetch_array( $top_menu_result))
            {
              $count++;
              echo '
              <tr>
                <td class="w3-center" style="">'.$count.'</td>
                <td class="w3-center">'.$row['item_name'].'</td>
                <td class="text-right"><i>'.$row['ordered_count'].' times</i></td>
              </tr>
              ';
            }
            ?>
          </table>
        </div>
        <div class="w3-twothird">
          <h5><b><i class="fa fa-print"></i> Print Report</b></h5>
          <div class="well w3-col l12">
            <div class="w3-col l6 w3-padding">
             <form method="GET" action="report/report_print.php">              
              <div class="w3-col l12 w3-margin-bottom">
               <select class="form-control" name="ReportPrint_menu" id="ReportPrint_menu">
                <option class="w3-red" selected><b>Choose Menu Item</b></option>
                <?php                 
                $sqlmenu="SELECT * FROM menu_items WHERE visible=1";
                $menuresult=mysqli_query($conn,$sqlmenu);

                while($menuresultrow = mysqli_fetch_array( $menuresult))
                {
                  echo '<option value="'.$menuresultrow['item_name'].'">'.$menuresultrow['item_name'].'</option>';
                }   
                ?>  
              </select>
            </div>
            <div class="w3-col l6 ">
              <label class="w3-small w3-text-grey">From Date : </label>
              <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="report_fromDate" id="report_fromDate" required>
            </div>
            
            <div class="w3-col l6 ">
              <label class="w3-small w3-text-grey">To Date:</label>
              <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="report_toDate" id="report_toDate" required>
            </div>
           <!--  <div class="w3-col l12 w3-margin-top">             

              <label class="w3-small w3-text-grey"> 
                <input type="checkbox" name="report_menuRank" id="report_menuRank" value="1">
                Print TOP 5 &amp; LOWEST 5 Items in Report</label>
              </div> -->
              <div class="w3-col l12">
               <button class="btn w3-button w3-red w3-margin-top" type="submit" name="getReportPrint_btn" id="getReportPrint_btn" style="padding:8px">Print Report</button>
             </div>

           </form>  
         </div>
         <div class="w3-col l6">
        <!--                 ................here general imp note to print report....................
      -->  
      <label class="w3-small w3-text-red">NOTE:</label>
      <ol class="w3-small w3-text-red">
        <li style="margin-bottom: 5px;">Please fill all the input fields before submitting the form.</li>
        <li style="margin-bottom: 5px;">Printed Report includes Sales/day report and Menu-Ordered/day report within specified days along with TOP-5 and LEAST-5 Menu Items till now.</li>
        <li style="margin-bottom: 5px;">It is recommended to perform print action from computer or any display device having screen size more than 500x500 dpi.</li>
      </ol>   
    </div> 

  </div>
</div>
</div>
</div>
<hr class="w3-border">
<div class="w3-panel">
  <div class="w3-row-padding" style="margin:0 -16px">
    <div class="w3-col l3">
      <h5><b><i class="fa fa-line-chart"></i> Report Charts </b></h5>

      <div class="w3-col l12 w3-margin-top">
        <div class="w3-col-12 w3-center">
          <button class="btn w3-button w3-red" id="itemReport_btn">Item Report</button>
          <button class="btn w3-button w3-red" id="saleReport_btn">Sales Report</button>
        </div>
        <div id="item_countReport" class="Charts w3-margin-top" style="display:none">
            <div class="w3-col l12 w3-padding">
             <select class="form-control w3-margin-right" name="Report_menu" id="Report_menu">
              <option class="w3-red" selected><b>Choose Menu Item</b></option>
              <?php                 
              $sqlmenu="SELECT * FROM menu_items WHERE visible=1";
              $menuresult=mysqli_query($conn,$sqlmenu);

              while($menuresultrow = mysqli_fetch_array( $menuresult))
              {
                echo '<option value="'.$menuresultrow['item_name'].'">'.$menuresultrow['item_name'].'</option>';
              }   
              ?>  
            </select>
          </div>
          <div class="w3-col l6">
            <label class="w3-small w3-text-grey">From Date : </label>
            <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="item_fromDate" id="item_fromDate" required>
          </div>

          <div class="w3-col l6">
            <label class="w3-small w3-text-grey">To Date:</label>
            <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="item_toDate" id="item_toDate" required>
          </div>
                   
       
         <a class="w3-card w3-button w3-margin-top w3-right w3-text-red w3-small" name="getItem_btn" id="getItem_btn" style="padding:5px">Get Report <i class="fa fa-arrow-right"></i></a>                 
       
     </div>            

     <div id="sale_Report" class="Charts w3-margin-top" style="display:none">
        <div class="w3-col l6">
          <label class="w3-small w3-text-grey">From Date : </label>
          <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="sale_fromDate" id="sale_fromDate" required>
        </div>

        <div class="w3-col l6">
          <label class="w3-small w3-text-grey">To Date:</label>
          <input class="form-control w3-margin-right" type="date" style="font-size: 12px" name="sale_toDate" id="sale_toDate" required>
        </div>           

                  
       <a class="w3-card w3-button w3-right w3-margin-top w3-text-red w3-small" name="getSale_btn" id="getSale_btn" style="padding:5px">Get Report <i class="fa fa-arrow-right"></i></a>                 
   </div>  

 </div>
</div>
<!--           ..................ending of report forms.................. -->

<div class="w3-twothird" style="margin-right: 0">
  <h5></h5>
  <div class="well" style="overflow: hidden;overflow-x: scroll;">  

    <h4 class="w3-center w3-large" id="Report_title"></h4>
    <canvas id="Report_Chart" width="500px" height="500px" style="height: auto;">
    </canvas>
    <div id="saleReport_table"></div>
  </div>
</div>
</div>
</div>
<hr>

<!--   <div class="w3-container">
    <h5>Countries</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <td>United States</td>
        <td>65%</td>
      </tr>
      <tr>
        <td>UK</td>
        <td>15.7%</td>
      </tr>
      <tr>
        <td>Russia</td>
        <td>5.6%</td>
      </tr>
      <tr>
        <td>Spain</td>
        <td>2.1%</td>
      </tr>
      <tr>
        <td>India</td>
        <td>1.9%</td>
      </tr>
      <tr>
        <td>France</td>
        <td>1.5%</td>
      </tr>
    </table><br>
    <button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Users</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Mike</span><br>
      </li>
      <li class="w3-padding-16">
        <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jill</span><br>
      </li>
      <li class="w3-padding-16">
        <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
        <span class="w3-xlarge">Jane</span><br>
      </li>
    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Recent Comments</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Demographic</h5>
        <p>Language</p>
        <p>Country</p>
        <p>City</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>Browser</p>
        <p>OS</p>
        <p>More</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Target</h5>
        <p>Users</p>
        <p>Active</p>
        <p>Geo</p>
        <p>Interests</p>
      </div>
    </div>
  </div> -->

  <!-- Footer -->
  <hr>
  <footer class="w3-container w3-padding-16 w3-light-grey w3-center">
    <h4>&copy; Copyright and All Rights reserved</h4>
    <p>Powered by <a href="https://bizmo-tech.com/" target="_blank">Bizmo Technologies</a></p>
  </footer>

  <!-- End page content -->
</div>
<script>
  $(document).ready(function()
  {
    $("#menuRank_category").change(function()
    {
      var menuRank_category=$(this).val();
      var dataString = 'menuRank_category='+ menuRank_category;

      $.ajax
      ({
        type: "POST",
        url: "report/menuRank_report.php",
        data: dataString,
        cache: false,
        success: function(html)
        {
          $("#menu_rank").html(html);
        } 
      });
    });
  });
</script>
<script>
// loads item report chrt form
$(document).ready(function()
{
 $(function() {
  $('#itemReport_btn').click(function(){
    $('.Charts').hide();
    $('#item_countReport').show();
  });
});
});
</script>
<script>
// loads item report chrt form
$(document).ready(function()
{
 $(function() {
  $('#saleReport_btn').click(function(){
    $('.Charts').hide();
    $('#sale_Report').show();
  });
});
});
</script>
</body>
</html>