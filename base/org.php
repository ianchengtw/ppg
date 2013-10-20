<?php
if(isset($_SERVER["SERVER_NAME"])){
	define("DOMAIN", "http://".$_SERVER["SERVER_NAME"]."/");
}else{
	define("DOMAIN", "http://localhost/");
}
define("ROOT", DOMAIN."ppg/");

function openHtml($title="PPG", $content=0, $css="", $js="", $ajax=false){
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
	if($title!=""){echo "<title>".$title."</title>";}
	echo '<meta charset="utf-8">';
	if($content>0){echo "<META HTTP-EQUIV='refresh' CONTENT='".(int)$content."'/>";}
	if($css!=""){
		echo "<style type='text/css'>";
		echo "@import url(http://".$css.")";
		echo "</style>";
	}
	if($js!=""){
		//js import
		echo "<script src='".$js."'></script>";
	}
	
	echo "<script src='".ROOT."js/base.js'></script>";
	
	if($ajax == true){
		echo "<script src='".ROOT."js/ajax.js'></script>";
	}

	echo '<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700|Open+Sans+Condensed:300,700" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css" /><![endif]-->';
	echo "</head>";
	echo '<body class="left-sidebar" onload=ready();>';
}

function baseView(){
	//echo "it is data-line<br>";
}
function closeHtml(){
	echo "</body>";
	echo "</html>";
}

interface mod{
	function start();
	function doing();
	function get();
	function post();
	function nodata();
	function view();
	function end();
}
class org{
	var $_database = null;
	var $_backPage = 'http://localhost/ppg/index.php';
	var $_title = 'PPG';
	var $_content;
	var $_css;
	var $_js;
	var $_error;
	
	function __construct(){
		//connect DB
		$dbhost = 'localhost';
		$dbuser = 'ian';
		$dbpass = '1234';
		$dbname = 'ppg';
		$this->database = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db($dbname);
	}
}

class baseMod extends org implements mod{
	
	function __construct(){
		parent::__construct();
		$this->start();
		$this->doing();
		$this->view();
		$this->end();
	}
	function start(){
	
		session_start();
		
		if(!empty($_SESSION)){
			foreach(get_class_vars(get_class($this)) as $name => $value){
				if ($name[0]!="_"){
					//SESSION new data demo (to other mod)  ex:$_SESSION[name]=value
					if (array_key_exists($name, $_SESSION)){$this->{$name} = $_SESSION[$name];}
				}
			}
		}else{
			//header('location: '.$this->_backPage);
		}
		if(!empty($_GET)){$this->get();}
		elseif(!empty($_POST)){$this->post();}
		else{$this->nodata();}
	}
	function doing(){}
	function get(){}
	function post(){}
	function nodata(){}
	function loadHeader($ajax = false){
		openHtml($this->_title, $this->_content, $this->_css, $this->_js, $ajax);
	}
	function loadFooter(){
		closeHtml();
	}
	function view(){
		$this->loadHeader();
		$this->loadFooter();
	}
	function end(){
		#save data
		foreach(get_class_vars(get_class($this)) as $name => $value){
			if ($name[0]!="_"){$_SESSION[$name]=$this->{$name};}
		}
	}
}

?>