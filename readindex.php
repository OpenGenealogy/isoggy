<?php
// extract ISOGG Y-DNA SNP Index 
// Copyright 2014 Rob Hoare.  License: MIT.  
// https://github.com/OpenGenealogy/isoggy	
$version = '0.1.1';
$page = file_get_contents('php://stdin');
preg_match_all("~<tr>(.*?)</tr>~s",$page,$matches);
foreach($matches[0] as $match) {
	$match = str_replace('&nbsp;','',$match);	
	$match = str_replace("\n",'',$match);
	preg_match_all("~<td>(.*?)</td>~s",$match,$f);
	foreach($f[1] as $field) {
		if (strstr($field,'<a href=')) { // remove url
			preg_match_all("~>(.*?)<~s",$field,$text);
			$field = $text[1][0];
		};
		$field = str_replace("-&gt;",'->',$field);
		$l[] = trim($field);		
	};
	$line = join('|',$l);
	if (!strstr($line,'font size')) { // skip top
		if (!strstr($line,'Other Names')) { // skip heading
			echo "$line\n";
		};	
	};	
	$l = '';
};		
exit;
