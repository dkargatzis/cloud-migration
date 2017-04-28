<?php

function Authentication($tenant, $usr, $psw){
	
	$ch = curl_init();

	$url = 'http://cloud.lab.fi-ware.org:4730/v2.0/tokens';
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

	curl_setopt($ch, CURLOPT_URL, $_SESSION['computeURL']."/servers/".$serverID."/action");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Auth-Token: '.$_SESSION['tokenID'])); 

	$results = curl_exec($ch);
	$info = curl_getinfo($ch);																		
	curl_close($ch);

	return $info['http_code'];

}

function DownloadFile($file, $nm){

	$glanceURL = substr_replace($_SESSION['glanceURL'], "2", -1);
	$file = $glanceURL."/images/".$file."/file";

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


function Upload($nm){
	session_start();
	$ch = curl_init();
	
	$body = '{
    "name": "'.$nm .'",
    "container_format": "bare",
    "disk_format": "qcow2",
    "visibility": "private",
    "min_disk": 0,
    "protected": false,
    "min_ram": 0
}';

	$glanceURL = substr_replace($_SESSION['glanceURL'], "2", -1);

	curl_setopt($ch, CURLOPT_URL, $glanceURL."/images");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Auth-Token: '.$_SESSION['tokenID'])); 

	$results = curl_exec($ch);
	$info = curl_getinfo($ch);																		
	curl_close($ch);

	echo $info['http_code'];

	$json = json_decode($results, true);
	$file = $glanceURL ."/images/" .$json['id'] ."/file"; 

/*    
	$cmd = 'curl -i -X PUT -H "X-Auth-Token: '.$_SESSION['tokenID'].'" -H "Content-Type: application/octet-stream" \
   -d @/var/www/html/cloud_migration/Assets/file-ref/temp.qcow2 ' .$file;

   echo $cmd;

   exec($cmd,$result);

   foreach ($result as $line) {
       echo "$line\n";
   }

}  */


/*    
	$file_path_str = 'Assets/file-ref/temp.qcow2';
	$fp = fopen($file_path_str, 'r');
    echo filesize($file_path_str);
	if ($fp == false){
		echo '<script>alert("Error to Open File..");</script>';
		exit;
	}	
    $post = fread($fp, filesize($file_path_str));
    echo "<script>console.log( 'Everything fine..' );</script>";
    echo "<script>console.log( 'File size: " . filesize($file_path_str) . "' );</script>";
*/    
    $file_name_with_full_path = "Assets/file-ref/temp.qcow2";
    $cFile = '@' . realpath($file_name_with_full_path);
    $post = array('file_contents'=> $cFile);
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $file);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/octet-stream', 'X-Auth-Token: '.$_SESSION['tokenID']));

	$response = curl_exec($ch);
	if(!curl_errno($ch)){
		$info = curl_getinfo($ch);
		if($info['http_code'] != 204)
			echo "\nan upload error occured..";
	}
	curl_close($ch);
	fclose($fp);
	echo $info['http_code'];
	if ($info['http_code'] == 204)
		return true;

}

?>
