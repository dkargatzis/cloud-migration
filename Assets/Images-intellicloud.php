<?php

	session_start();
	
	$glanceURL = "http://147.27.50.1:9292/v2/images";
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $glanceURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','X-Auth-Token: '.$_SESSION['tokenID'])); 

	$results = curl_exec($ch);
																		
	curl_close($ch);
	
	echo  '<h3>Images</h3>
		  <h4>Image Name &nbsp; &#x25BE;</h4> 
          <form method="post" class="form form--images">
		  <div class="scroll">';  
          $json = json_decode($results, true);
          foreach ($json['images'] as $val) {
            echo '<input type="radio" name="ImageID" value="' .$val['id'] .'">&nbsp;'.$val['name'];
            echo '<input type="hidden" name= "image--name" value="'.$val['name'].'">';
            echo "<br>";
          }
                         
    echo '</div><input type="submit" name="submit" value="Download Image">
      </form>';



?>
