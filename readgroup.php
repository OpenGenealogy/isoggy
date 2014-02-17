<?php
// extract haplogroup - parameter is A to T. - version 0.1.0
// Copyright 2014 Rob Hoare.  License: MIT.
// https://github.com/OpenGenealogy/isoggy
$page = file_get_contents('php://stdin');
preg_match_all("~<!(.*?)<br>~s",$page,$matches);
foreach($matches[0] as $match) {
	$match = str_replace('&nbsp;','',$match);
	$match = str_replace('&nbsp','',$match);	
	$match = str_replace(chr(149),'',$match);
	$match = str_replace("\n",'',$match);
	$match = str_replace("\r",'',$match);
	preg_match_all("~>(.*?)<~s",$match,$entries);
	$entry = join(' ',$entries[1]);
	if (!strstr($entry,'font-weight:')) { // skip stylesheet
		$entry = trim(str_replace('">','',$entry));
		$e = split(' ',$entry,2);
		$sn = trim(array_pop($e));
		$sc = trim($e[0]);
		$sn = str_replace('/S9 PF605','/S9,PF605',$sn); // quick fix
		$sn = str_replace(' ','',$sn);		
		echo "$sc|$sn\n";
	};
};
