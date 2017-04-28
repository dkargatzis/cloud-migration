<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Cloud Migration Service</title>
  
    <link rel="stylesheet" href="Assets/css/download.css">
    <style type="text/css">
    .procedure {
	   font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    }
    </style>

	<script src="Assets/js/content.js" ></script>

  </head>

<body>

<header>
    <div class="user">
      <img src="https://cloud.lab.fiware.org/images/header/user.png" height="20" width="20" align="middle">
      <?php    
      session_start();  
          $json = json_decode($_SESSION['nodes'], true);
          echo $json['access']['user']['username'];
      ?>
      <form method="post" class="Logout">
        <input type="submit" name="Logout" value="&#x25BF;">
      </form>
    </div>
    Cloud Migration<br>
    <span>on heterogeneous platforms</span>
    <hr>
</header>


<div class="grid__container">
    <h4>Project</h4>
    <?php    
      session_start();  
      $json = json_decode($_SESSION['nodes'], true);  
      echo "&nbsp;" .$json['access']['token']['tenant']['name'];
    ?>  

    &nbsp;

    <div class="menu">
        <li><input type="button" value="Instances&#x27a1;" onclick="sendGetRequest('Assets/Servers-intellicloud.php', 'grid1', 'grid1');"></li>
        <li><input type="button" value="Images&#x27a1;" onclick="sendGetRequest('Assets/Images-intellicloud.php', 'grid1', 'grid1');"></li>
    </div>
</div>

<div class="temp--grid" id="grid1">

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

require_once('Assets/intellicloud.php');

  session_start();

  if (!isset($_SESSION['tokenID']))
    header("location: intellicloud-proc.php");

  if($_POST['Logout']){
    session_destroy();
    header("location: intellicloud-proc.php");
    exit();
  }
  if($_POST['InstanceID']){    
    if(Snapshot($_POST['InstanceID'], $_POST['snap--name']) == 202)
      echo '<script>alert("Snapshot created successfully!");</script>';
  }    
  
  if($_POST['ImageID']){   
    if(DownloadFile($_POST['ImageID'], $_POST['image--name']) == 200)
      echo '<script>alert("Image downloaded successfully!");</script>';
  }  
  


?>
