<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Cloud Migration Service</title>
  
    <link rel="stylesheet" href="Assets/css/login.css">
    <style type="text/css">
    .procedure {
	   font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    }
    </style>
  </head>

<body>

<header>
    Cloud Migration<br>
    <span>on heterogeneous platforms</span>
    <hr>
</header>

<div class="grid__container">

  <center><img src="Assets/images/stratogen.png" height="75" width="170"></center>
  <form action="" method="post" class="form form--login">

            <div class="form__field">
              <label class="fontawesome-user" for="login__username"><span class="hidden">Username</span></label>
              <input name="login__username" type="text" class="form__input" placeholder="Username" required>
            </div>
    
            <div class="form__field">
              <label class="fontawesome-lock" for="login__password"><span class="hidden">Password</span></label>
              <input name="login__password" type="password" class="form__input" placeholder="Password" required>
            </div>

            <div class="form__field">
              <input type="submit" value="Sign In">
            </div>
    
    </form>

</div>

<div class="skip">
	<input type="button" value="Back &#8626;" onclick="window.location='procedure.php';">  
</div>

<div class="description">
	<center><h3>Log in with Stratogen Cloud credentials to start the upload procedure.</h3></center>
</div>

<br>
<div class="footer">
	&#x24B8; 2015 by dkargatzis.
    	<a target="_blank" href="https://plus.google.com/u/0/101783807990547566494?prsrc=3"
  		 rel="publisher" target="_top" style="text-decoration:none;">
		<img src="https://ssl.gstatic.com/images/icons/gplus-64.png" alt="Google+" style="border:0;width:16px;height:16px;"/>
		</a>
         &nbsp
    	<a target="_blank" href="https://gr.linkedin.com/pub/dimitris-kargatzis/101/5a2/138">
      	<img src="https://static.licdn.com/scds/common/u/img/webpromo/btn_profile_bluetxt_80x15.png" width="80" height="15" border="0" alt="View dimitris kargatzis's profile on 			 LinkedIn"></a>
</div>
    
    
</body>
</html>

<?php

require_once('Assets/stratogen.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $usr = trim($_POST["login__username"]);
  $psw = trim($_POST["login__password"]);
  
  $cred = $usr .":" . $psw;

  session_start();
  $_SESSION['org'] = Authenticate($cred) ."";
 
  header("location: tools.php");

}

?>
