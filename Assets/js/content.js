var strLoading = '<div style="margin-top:5em;width: 45em;color:#FF0000;"><center><img src="Assets/images/ajax-loader.gif" width="60" height="60" border="0" /> <br>&nbsp;Loading...</center></div>';
function sendGetRequest(url, contentDiv, divLoading){
	var xmlHttp = GetXmlHttpObject();
	
	xmlHttp.onreadystatechange = function(){
		afterStateChange(xmlHttp, contentDiv, divLoading);
	}
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
}

function afterStateChange(xmlHttp, contentDiv, divLoading){ 
	if(xmlHttp.readyState < 4){
		showLoading('On', contentDiv, divLoading);
	}

	if(xmlHttp.readyState == 4 || xmlHttp.readyState == "complete"){
		showLoading('Off', contentDiv, divLoading);
		document.getElementById(contentDiv).innerHTML 	= xmlHttp.responseText;
	}
}

function showLoading(flag, contentDiv, divLoading){ 
	if(divLoading != ''){
		var objLoading = document.getElementById(divLoading);
		if(!objLoading) var objLoading = document.getElementById(contentDiv);
		if(flag == 'On') objLoading.innerHTML = strLoading;
		else if(flag == 'Off') objLoading.innerHTML = '';
	}
}

function GetXmlHttpObject(){
	var xmlHttp;
	try{
		/* Firefox, Opera 8.0+, Safari */
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		/* Internet Explorer */
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
}

function SetName(){
	var nm = prompt("name: ");
	if(nm){
	    document.getElementById("vapp--name").value = nm;
	    document.getElementById("new--vapp").submit();

    }
}

function SetName1(){
	var nm = prompt("Snapshot name: ");
	if(nm){
	    document.getElementById("snap--name").value = nm;

    }
}

function SetName2(){
	var nm = prompt("image name: ");
	if(nm){
	    document.getElementById("new--image").value = nm;
	    //document.getElementById("form--images").submit();

    }
}

