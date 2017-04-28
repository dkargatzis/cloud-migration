<?php 

	
function Authenticate($credentials){

	$ch = curl_init("https://mycloud.stratogen.net/api/sessions");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_USERPWD, $credentials);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/*+xml;version=5.1')); 

	$response = curl_exec($ch);

	$var = explode('<?xml', (string)$response, 2); //Explode response to header part and body part 

	$var1 = explode("x-vcloud-authorization: ", $var[0]); 
	$token = substr($var1[1], 0, 44);	//Get only token id from header part 

	$_SESSION['tokenID'] = $token;


	curl_close($ch);

	$xml = simplexml_load_string("<?xml".$var[1]);
	foreach ($xml->Link as $val) {
		if($val["name"] == "".$xml['org'])
			$OrgLink = $val["href"]; 
	}
	return $xml['user'].":".$xml['org'].":".$OrgLink;

}

/*function GetUploadLinks($org, $OrgLink){

	$ch = curl_init($OrgLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID'])); 

	$response = curl_exec($ch);

	curl_close($ch);
	
	$xml = simplexml_load_string($response);
	
	foreach ($xml->Link as $val) {
		if($val['name'] == "".$org)
			$vDCLink = $val["href"];
	}

	$ch = curl_init($vDCLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID'])); 

	$response = curl_exec($ch);
	curl_close($ch);	

	$xml = simplexml_load_string($response);

	foreach ($xml->Link as $val) {
		if($val['rel'] == "add" && $val['type'] == "application/vnd.vmware.vcloud.uploadVAppTemplateParams+xml")
			$NewVappLink = $val["href"];
	}
	
	$_SESSION['NewVappLink'] = $NewVappLink ."";

	foreach ($xml->ResourceEntities->ResourceEntity as $val){ 
		if($val['type'] == "application/vnd.vmware.vcloud.vAppTemplate+xml")
			echo $val['name']."<br>";
	}
	
}/*

	$xml = simplexml_load_string($response);
	
	foreach ($xml->Link as $val) {
		if($val['name'] == "TUC")
			$vDCLink = $val["href"];		// Link to the vDC
		if($val['name'] == "test")
			$CatalogLink = $val["href"];	// Link to the catalog list
	}
	//echo $vDCLink."\n";
	//echo $CatalogLink."\n";

	$ch = curl_init($vDCLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID'])); 

	$response = curl_exec($ch);
	curl_close($ch);	

	$xml = simplexml_load_string($response);
	
	foreach ($xml->Link as $val) {
		if($val['rel'] == "add" && $val['type'] == "application/vnd.vmware.vcloud.uploadVAppTemplateParams+xml")
			$NewVappLink = $val["href"];
		if($val['rel'] == "add" && $val['type'] == "application/vnd.vmware.vcloud.media+xml")
			$MediaLink = $val["href"];
	}

	$_SESSION['NewVappLink'] = $NewVappLink ."";

	return "";
}*/


	/*
	Create Media Object 				
	*/
	
	/*$file_path_str = 'image.vmdk';
	
	$body = '<?xml version="1.0" encoding="UTF-8"?>
			<Media
			xmlns="http://www.vmware.com/vcloud/v1.5"
			name="Snapshot.vmdk"
			size="'.filesize($file_path_str).'" 
			imageType="vmdk">
			<Description>Snapshot disk image</Description>
			</Media>';

	$ch = curl_init($MediaLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','Content-Type: application/vnd.vmware.vcloud.media+xml','x-vcloud-authorization:'.$token));
	
	curl_close($ch);

	$xml = simplexml_load_string($response);

	foreach ($xml->Files as $val) {
		if($val->File->Link['rel'] == "upload:default")
			$MediaUpLink = $val->File->Link['href'];
	}


	$fp = fopen($file_path_str, 'r');
	$post = fread($fp, filesize($file_path_str));

	$ch = curl_init($MediaUpLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$token));

	$response = curl_exec($ch);
	if(!curl_errno($ch)){
		$info = curl_getinfo($ch);
		if($info['http_code'] != 200)
			echo "\nan upload error occured..";
	}
	curl_close($ch);
	fclose($fp);
*/



    /* 
        Create a New Vapp
    */

function CreateVapp($NewVappLink, $vapp_name){

	$body = '<?xml version="1.0" encoding="UTF-8"?>
			<UploadVAppTemplateParams
			name="'.$vapp_name.'"
			xmlns="http://www.vmware.com/vcloud/v1.5"
			xmlns:ovf="http://schemas.dmtf.org/ovf/envelope/1">
			<Description>Ubuntu vApp Template</Description>
			</UploadVAppTemplateParams>';

	$ch = curl_init($NewVappLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','Content-Type: application/vnd.vmware.vcloud.uploadVAppTemplateParams+xml','x-vcloud-authorization:'.$_SESSION['tokenID']));

	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	/* 
	Here we find descriptor's upload link
	*/
	$xml = simplexml_load_string($response);
	if($xml['name'] == $vapp_name)
		$VappLink = $xml['href'];
	
	foreach ($xml->Files as $val) {
		if($val->File->Link['rel'] == "upload:default")
			$OVFLink = $val->File->Link['href'];
	}

	$_SESSION['OVFLink'] = $OVFLink ."";
	$_SESSION['AppLink'] = $VappLink ."";
	
	if ($info['http_code'] == 201){
		echo '<script>alert("vapp template created..");</script>';
		return true;
	}
	
}		


function UploadDescriptor($OVFLink){

	$file_path_str = 'Assets/descr.ovf';
	$fp = fopen($file_path_str, 'r');
	$post = fread($fp, filesize($file_path_str));

	$ch = curl_init($OVFLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID']));

	$response = curl_exec($ch);
	if(!curl_errno($ch)){
		$info = curl_getinfo($ch);
		if($info['http_code'] != 200)
			echo "\nan upload error occured..";
	}
	curl_close($ch);
	fclose($fp);

	if ($info['http_code'] == 200)
		return true;

}

function GetVMDK($lnk){
	$ch = curl_init($lnk);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID'])); 

	$response = curl_exec($ch);
	curl_close($ch);

	$xml = simplexml_load_string($response);

	foreach ($xml->Files as $val) {
		if($val->File->Link['rel'] == "upload:default")
			$VMDKLink = $val->File->Link['href'];
	}

	
	$file_path_str = 'Assets/image.vmdk';
	$fp = fopen($file_path_str, 'r');
	$post = fread($fp, filesize($file_path_str));

	$ch = curl_init($VMDKLink);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID']));

	$response = curl_exec($ch);
	if(!curl_errno($ch)){
		$info = curl_getinfo($ch);
		if($info['http_code'] != 200)
			echo "\nan upload error occured..";
	}
	curl_close($ch);
	fclose($fp);

	if ($info['http_code'] == 200)
		return true;
}



	

?>
