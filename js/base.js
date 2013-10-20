/*
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
			updataView(data);
		}
	}
}

function updataView(data){}
function timeDoing(){}

function timeUpdate(){
	timeDoing();
	updataView();
	setTimeout(timeUpdate(), 2*1000);
}
*/
function ready(){}
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1)
	{
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1)
	{
		c_value = null;
	}
	else
	{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1)
		{
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}
function deleteCookie(c_name){
	setCookie(c_name, "", -1);
}



