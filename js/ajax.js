var xmlhttp;
if(typeof XMLHttpRequest != "undefined"){
	xmlhttp = new XMLHttpRequest();
}else if(typeof window.ActiveObject != "undefined"){
	// for IE browser
	var ax = new Array(	"Msxml2.XMLHTTP.6.0",
						"Msxml2.XMLHTTP.5.0",
						"Msxml2.XMLHTTP.4.0",
						"Msxml2.XMLHTTP.3.0",
						"Msxml2.XMLHTTP.2.6",
						"MSXML2.ServerXMLHTTP",
						"MSXML2.XMLHTTP",
						"Microsoft.XMLHTTP");
	for(var i=0; i<ax.length; i++){
		try{
			xmlhttp = new ActiveXObject(ax[i]);
			if(typeof xmlhttp == "object") break;
		} catch(error){
			xmlhttp = null;
		}
	}
}

if(typeof xmlhttp.overrideMimeType != "undefined"){
	xmlhttp.overrideMimeType("text/html; charset=utf-8");
}

xmlhttp.onreadystatechange = function(){
	if(xmlhttp.readyState == 4){
		if(xmlhttp.status == 200){
			var data = xmlhttp.responseText;
			/* 
			 * if the responsive data is formatting in XML, 
			 * use the following attribute to receive
			 * var data = http_request.responseXML;
			 */
			updateView(data);
		}
	}
}

function updateView(){}