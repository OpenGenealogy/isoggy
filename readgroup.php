<?php
// extract haplogroup tree data.
// Copyright 2014 Rob Hoare.  License: MIT.
// https://github.com/OpenGenealogy/isoggy
$version = '0.1.2';
$page = file_get_contents('php://stdin'); // read group file from stdin
preg_match_all("~<!(.*?)<br>~s",$page,$matches); // select detail lines
foreach($matches[0] as $match) { // for each set of details
	$match = str_replace('&nbsp;','',$match); // remove non-br spaces
	$match = str_replace('&nbsp','',$match); // and incomplete ones	
	$match = str_replace(chr(149),'',$match); // remove bullets
	$match = str_replace("\n",'',$match); // remove new lines
	$match = str_replace("\r",'',$match); // remove returns
	preg_match_all("~>(.*?)<~s",$match,$entries); // remove all html
	$entry = join(' ',$entries[1]); // join up what's left, with spaces
	if (!strstr($entry,'font-weight:')) { // skip stylesheet
		$entry = trim(str_replace('">','',$entry)); // fix untidy A
		list($sc,$snp) = explode(' ',$entry,2); // split subclade, snp
		$snp = str_replace('/S9 PF605','/S9,PF605',$snp); // fix R
		$snp = str_replace(' ','',$snp); // remove spaces
		$snp = str_replace('>','',$snp); // remove stray tag closings
		if ($sc != 'Y') { // ignore Y on A file		
			echo "$sc|$snp\n"; // write to stdout
		};
	};
};
exit;
