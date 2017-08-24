
<!-- Top container -->
<?php if(!isset($_SESSION['admin_passwd']))
{
 
  header("location:../index.php");
  // include("admin_navigation.php");
} ?>
<div class="w3-bar w3-top w3-red w3-large container_size" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right w3-xlarge">HOTEL POS</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left sidebar_size" style="z-index:3;width:300px;margin-top: 40px;" id="admin_navigation"><br>
  <div class="w3-container w3-row">
    
    <div class="w3-col s8 w3-col l12 w3-bar w3-xlarge">
      <span>Welcome, <strong>Admin </strong></span><br>
      
    </div>
    <a class="btn w3-right fa fa-sign-out w3-small w3-medium w3-light-grey w3-padding-small" href="admin_logout.php"> Logout</a>
  </div>
  <hr>
  
  <div class="w3-bar-block l">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="admin_index.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-dashboard fa-fw"></i>  Dashboard</a>
    <a href="admin_viewTable.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Dining Tables</a>
    <a href="parcelOrder.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-shopping-bag fa-fw"></i>  Parcel Ordering</a>
    <a href="admin_manageSettings.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Manage Settings</a>
    <a href="admin_manageRoles.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-secret fa-fw"></i>  Manage Roles</a>
    <a href="change_password.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-unlock-alt fa-fw"></i>  Change Password</a>
    <br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="admin_navigation_sm"></div>


<script>
// Get the Sidebar
var admin_navigation = document.getElementById("admin_navigation");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("admin_navigation_sm");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (admin_navigation.style.display === 'block') {
        admin_navigation.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        admin_navigation.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    admin_navigation.style.display = "none";
    overlayBg.style.display = "none";
}
</script>