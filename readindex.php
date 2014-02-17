<?php
// extract ISOGG Y-DNA SNP Index 
// Copyright 2014 Rob Hoare.  License: MIT.  
// https://github.com/OpenGenealogy/isoggy	
$version = '0.1.2';
$page = file_get_contents('php://stdin'); // read index file from stdin
preg_match_all("~<tr>(.*?)</tr>~s",$page,$matches); // find table rows
foreach($matches[0] as $match) { // for each yable row
	$match = str_replace('&nbsp;','',$match); // remove non-br spaces	
	$match = str_replace("\n",'',$match); // remove new lines
	preg_match_all("~<td>(.*?)</td>~s",$match,$f); // find table cells
	foreach($f[1] as $field) { // for each table cell
		if (strstr($field,'<a href=')) { // if there is an url ...
			preg_match_all("~>(.*?)<~s",$field,$text); // select text
			$field = $text[1][0]; // set field to text without url
		};		
		$field = str_replace("-&gt;",'->',$field); // replace html code
		$l[] = trim($field); // add to array of field		
	};
	$line = join('|',$l); // join up the fields with | delimiter
	if (!strstr($line,'font size')) { // skip top of page
		if (!strstr($line,'Other Names')) { // skip table heading
			echo "$line\n"; // write to stdout
		};	
	};	
	$l = ''; // empty the field array before next line
};		
exit;
