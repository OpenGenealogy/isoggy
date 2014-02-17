<?php
// extract haplogroup tree data.
// Copyright 2014 Rob Hoare.  License: MIT.
// https://github.com/OpenGenealogy/isoggy
$version = '0.1.1';
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
		$snp = trim(array_pop($e));
		$sc = trim($e[0]);
		$snp = str_replace('/S9 PF605','/S9,PF605',$snp); // fix R
		$snp = str_replace(' ','',$snp);
		$snp = str_replace('>','',$snp);
		if ($sc != 'Y') { // ignore Y on A file		
			echo "$sc|$snp\n";
		};
	};
};
exit;
