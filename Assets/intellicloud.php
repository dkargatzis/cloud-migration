<?php

function Authentication($tenant, $usr, $psw){
	
	$ch = curl_init();

	$url = 'http://147.27.50.1:35357/v2.0/tokens';
	$body = '{ 
				"auth": {
					"tenantName": "' .$tenant .'",
					"passwordCredentials": {
						"username": "' .$usr .'",
						"password": "' .$psw .'"
					}
				}
			}';

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

	$results = curl_exec($ch);

	curl_close($ch);


	$json = json_decode($results, true);

	$_SESSION['tokenID'] = $json['access']['token']['id'];

	return $results;	

}

function Snapshot($serverID,$nm){
	session_start();
	$ch = curl_init();
	
	$body = '{
		"createImage":
		{"name": "'.$nm .'", "metadata": {}}
	}';

	curl_setopt($ch, CURLOPT_URL, "http://147.27.50.1:8774/v2/ae3e3bea49f3449db48dcfc8291288a9/servers/".$serverID."/action");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Auth-Token: '.$_SESSION['tokenID'])); 

	$results = curl_exec($ch);
	$info = curl_getinfo($ch);																		
	curl_close($ch);
echo $serverID;
	return $info['http_code'];

}

function DownloadFile($file, $nm){

	$file = "http://147.27.50.1:9292/v2/images/".$file."/file";

	set_time_limit(0);
	$fp = fopen ('Assets/file-ref/temp.qcow2', 'w+');		//This is the file where we save the information
	if ($fp == false){
		echo '<script>alert("Error to Open File..");</script>';
		exit;
	}
	$ch = curl_init(str_replace(" ","%20",$file));					//Here is the file we are downloading, replace spaces with %20
	curl_setopt($ch, CURLOPT_FILE, $fp); 								// write curl response to file
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Auth-Token: '.$_SESSION['tokenID'])); 
	
	curl_exec($ch);
	$info = curl_getinfo($ch);				 
	curl_close($ch);
	fclose($fp);

	return $info['http_code'];
	
}



?>
