<?php

	session_start();
	if(isset($_GET['region']))
		$region = $_GET['region']; 

    $json = json_decode($_SESSION['nodes'], true);
	foreach ($json['access']['serviceCatalog'] as $node) {
		if($node['type'] == "compute"){
			foreach ($node['endpoints'] as $value) {
				if($value['region'] == $region){
					$computeURL = $value['publicURL'];
				}
			 } 
		 }elseif($node['type'] == "image"){
		 	foreach ($node['endpoints'] as $value) {
				if($value['region'] == $region){
					$_SESSION['glanceURL'] = $value['publicURL'];
				}
			 } 
		 }
	}

	$_SESSION['computeURL'] = $computeURL;
																			
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $computeURL."/servers");
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
