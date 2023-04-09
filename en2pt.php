<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$str=<<<heredoc
https://en.wikipedia.org/wiki/Garden_of_Eden
https://en.wikipedia.org/wiki/Top_hat
https://en.wikipedia.org/wiki/Myth
https://en.wikipedia.org/wiki/Natural_philosophers
https://en.wikipedia.org/wiki/Democritus
https://en.wikipedia.org/wiki/Fate
https://en.wikipedia.org/wiki/Socrates
https://en.wikipedia.org/wiki/Athens
https://en.wikipedia.org/wiki/Plato

https://en.wikipedia.org/wiki/Aristotle
https://en.wikipedia.org/wiki/Hellenistic_philosophy


https://en.wikipedia.org/wiki/The_Middle_Ages
https://en.wikipedia.org/wiki/The_Renaissance
https://en.wikipedia.org/wiki/Baroque
https://en.wikipedia.org/wiki/Descartes
https://en.wikipedia.org/wiki/Spinoza
https://en.wikipedia.org/wiki/John_Locke
https://en.wikipedia.org/wiki/David_Hume
https://en.wikipedia.org/wiki/George_Berkeley

https://en.wikipedia.org/wiki/The_Enlightenment
https://en.wikipedia.org/wiki/Kant
https://en.wikipedia.org/wiki/Romanticism
https://en.wikipedia.org/wiki/Georg_Wilhelm_Friedrich_Hegel
https://en.wikipedia.org/wiki/Kierkegaard
https://en.wikipedia.org/wiki/Marx
https://en.wikipedia.org/wiki/Charles_Darwin
https://en.wikipedia.org/wiki/Freud
https://en.wikipedia.org/wiki/Late_modern_period


https://en.wikipedia.org/wiki/Big_Bang
heredoc;
$arr=explode(PHP_EOL,$str);
$arr=array_map('linkEmPT',$arr);
print '<pre>';
print implode(PHP_EOL,$arr);

function linkEmPT($link){
	if(empty($link)){
		return $link;
	}
	$artigo=explode('https://en.wikipedia.org/wiki/',$link)[1];
	$url='https://en.wikipedia.org/w/api.php?action=query&prop=langlinks&format=json&lllimit=200&llurl=&titles='.$artigo.'&redirects=';
	$str=file_get_contents($url);
	$queryArr=json_decode($str,true)['query'];
	//$urlReal=$queryArr['redirects'][0]['to'];
	$pagesArr=$queryArr['pages'];
	$key=array_key_first($pagesArr);
	$langs=$pagesArr[$key]['langlinks'];
	$artigos=[];
	foreach($langs as $lang){
		if(
			$lang['lang']=='es' or
			$lang['lang']=='pt'
		){
			$artigos[$lang['lang']]=$lang;
		}
	}
	if(isset($artigos['pt'])){
		$out=$artigos['pt'];
	}else{
		$out=[
			'lang'=>'en',
			'url'=>$link,
			'*'=>$artigo
		];
	}
	return $out['url'];
}

