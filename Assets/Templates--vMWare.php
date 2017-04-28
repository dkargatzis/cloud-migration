<?php	

	session_start();    
        $var = explode(':',(string)$_SESSION['org'],3);

	$ch = curl_init($var[2]);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/*+xml;version=5.1','x-vcloud-authorization:'.$_SESSION['tokenID'])); 

	$response = curl_exec($ch);

	curl_close($ch);
	
	$xml = simplexml_load_string($response);
	
	foreach ($xml->Link as $val) {
		if($val['name'] == "".$var[1])
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

	echo  '<h3>vApp Templates</h3>
		  <h4>Template Name &nbsp; &#x25BE;</h4>
		  <form method="post" class="form new--vApp" id="new--vapp">
		  <input type="hidden" name= "vapp--name" id="vapp--name">
		  <input type="button" name="NewvApp" value="&#x2B;" onclick="SetName()">
		  <div class="scroll">';  
	foreach ($xml->ResourceEntities->ResourceEntity as $val){ 
		if($val['type'] == "application/vnd.vmware.vcloud.vAppTemplate+xml")
			echo '<br><input type="radio" name="template" value="' .$val['name'] .'">&nbsp;'.$val['name'];

	}
	
	echo '</div></form>';
?>
