<?php
// compare haplogroup files and the index
// Copyright 2014 Rob Hoare.  License: MIT.  
// https://github.com/OpenGenealogy/isoggy	
$version = '0.1.0';
$group = file('php://stdin'); // read group from stdin
$index = file('index.txt'); // read index (make into arg)
//print_r($index);
// initialise
$oldsc = '';
$oldpos = '';
$oldmut = '';
$oldstart = '';
$groups = '';
foreach ($group as $groupentry) { 
	list($sc,$snp) = explode('|',$groupentry,2);
	$start = substr($sc,0,1); // build list of starting letters
	if ($start != $oldstart) {
		$groups[] = $start;
		$oldstart = $start;
	};	
	if (strstr($snp,'(')) {
		list($snp,$x) = explode('(',$snp); // clean off notes
	};	
	if (!strstr($sc,'*')) {
		$snpsets = explode(',',$snp);
		foreach ($snpsets as $snpset) {
			$snpaliases = explode('/',$snpset);
			foreach ($snpaliases as $snp) {
				trim($snp);
				$snp = str_replace("\n",'',$snp); 
				//echo "$snp\n";
				$rsnp = preg_quote($snp,'~'); // escape + 
				$matches  = preg_grep ("~^".$rsnp."\|~", $index);
				if (count($matches) > 0) {
					foreach ($matches as $match) {
						// 
						//echo "$snp match $match\n";
					};	
				} else { // no match
						if ($snp == '-') {
							echo "* missing at end of $sc in group file\n";
						} else {	 
							echo "$snp for $sc not found in index\n";
						};	
				};		
			};	
		};
	};
};	
// now, is every subclade in the idnex also in the group file?

foreach ($groups as $g) {
	foreach ($index as $i) {
		$ival = explode('|',$i);
		$start = substr($ival[1],0,1);
		if ($start == $g) {
			$snp = $ival[0];
			$sc = $ival[1];
			if (strstr($sc,'(')) {
				// skip any with notes (usually investigation)
			} else {				
				//echo "$sc $snp\n";
				$rsc = preg_quote($sc,'~'); // escape 
				$matches  = preg_grep ("~^".$rsc."\|~", $group);
				if (count($matches) == 0) {
					echo "$sc is present in index but not in group file\n";
				};	
			};	
		};
	};	
};	 
exit;
