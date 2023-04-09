<!DOCTYPE html>
<html>
<head>
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
</style>
</head>
<body>
<table width="100%" height="100%">
<tr>
<td width="33%">
<center>
<h1>O Mundo de Sofia</h1>
<h3>Sumário</h3>
</centeR>
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
</td>
<td>
<iframe id="palco" src="about:blank" width="100%" height="100%"></iframe>
</td>
</tr>
</table>
<script>
function abrirNoPalco(url){
	$("#palco").attr('src',url);
}
$(function(){
	abrirNoPalco("<?php print $links[0];?>");
	$('a')
	   .click(function (event) {
	       event.preventDefault();
	       event.stopPropagation();
	       abrirNoPalco($(this).attr('href'));
	});
});
</script>