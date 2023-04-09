<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$str=file_get_contents('linksEN.txt');
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

