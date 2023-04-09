<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>O Mundo de Sofia</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
html,body{
	margin:0;
	padding:0;
}
iframe{
	border:none;
	margin-top:-8px;
}
table{
	height:100%;
	width:100%;
}
#container{
	overflow-y: scroll;
}
#palco{
	postion:absolute;
	float:right;
	height:100%;
	width:66%;
}
#sumario{
	position:absolute;
	left:0;
	top:0;
	width:33%;
}
@media (max-width: 800px) {
	#palco,#sumario{
		position:relative;
		width:100%;
	}
}

</style>
</head>
<body>
<div id="sumario">
<center>
<h1>O Mundo de Sofia</h1>
<h3>Sumário</h3>
</center>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$caps=explode(PHP_EOL,file_get_contents('caps.txt'));
$links=explode(PHP_EOL,file_get_contents('links.txt'));
$links=array_map('converterParaMobile',$links);
print '<ol>'.PHP_EOL;
function converterParaMobile($url){
	return str_replace("https://pt.wikipedia.org/","https://pt.m.wikipedia.org/",$url);
}
foreach($caps as $key=>$cap){
	$link=$links[$key];
	if(empty($link)){
		$link=$cap;
	}else{
		$link='<a href="'.$link.'">'.$cap.'</a>';
	}
	print '<li>'.$link.'</li>'.PHP_EOL;
}
print '</ol>'.PHP_EOL;
?>
</div><!--sumario-->
<iframe id="palco" src="about:blank"></iframe>
<script>
function abrirNoPalco(url){
	$("#palco").attr('src',url);
	$('html, body').animate({
		scrollTop: $("#palco").offset().top
	}, 2000);
}
$(function(){
	$('#palco').css('height',$(document).height()+'px');
	abrirNoPalco("<?php print $links[0];?>");
	$('a')
	   .click(function (event) {
	       event.preventDefault();
	       event.stopPropagation();
	       abrirNoPalco($(this).attr('href'));
	});
});
</script>