<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>HOTEL POS</title>
  <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/font awesome/font-awesome.css">
  <link rel="stylesheet" href="../assets/css/w3.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <script type="text/javascript" src="../assets/css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../assets/css/bootstrap/bootstrap.min.js"></script>
  <style type="text/css">
   
    body,h1,h5 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
    background-image: url('images/onepage_restaurant.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
}
  </style>

</head>
<body>

<div class="bgimg w3-display-container w3-text-white">
  <div class="w3-display-middle w3-large">
    <hr>

          <form action="customer_login.php" id="form_customer_login"   method="POST">
            
            <input class="form-control " type="text" name="cust_name" placeholder="Username Eg:XYZ" required/><br>
            <input class="form-control" type="password" name="cust_passwd" placeholder="Password Eg:**********" required/><br>
            <input class="form-control w3-red w3-wide" type="submit" name="cust_submit" id="cust_submit" value="Login" >

            
          </form>
  </div>
 
  <div class="w3-display-bottomleft w3-container">
    <p class="w3-xlarge">monday - saturday 10-23 | sunday 14-02</p>
    <p class="w3-large">Nalstop Chowk, Pune</p>
    <p>powered by <a href="https://www.bizmo-tech.com/" target="_blank">Bizmo Technologies</a></p>
  </div>
</div>


</body>
</html>

