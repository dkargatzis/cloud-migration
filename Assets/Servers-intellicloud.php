<?php
	
	session_start();
																			
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://147.27.50.1:8774/v2/ae3e3bea49f3449db48dcfc8291288a9/servers");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Auth-Token: '.$_SESSION['tokenID'])); 

	$results = curl_exec($ch);												

	curl_close($ch);
	echo  '<h3>Instances</h3>
		  <h4>Instance Name &nbsp; &#x25BE;</h4> 
          <form method="post" class="form form--servers" onsubmit="SetName1()">
          <input type="hidden" name= "snap--name" id="snap--name">
		  <div class="scroll">';                 
          $json = json_decode($results, true);
          foreach ($json['servers'] as $val) {
            echo '<input type="radio" name="InstanceID" value="' .$val['id'] .'">&nbsp;'.$val['name'];
            echo "<br>";
          }
                         
    echo '</div><input type="submit" name="submit" value="Create Snapshot">
      </form>';



?>
