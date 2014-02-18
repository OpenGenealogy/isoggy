isoggy
======

Extract and validate information from the ISOGG Y-DNA Haplogroup Tree,
so that the data can be used in genetic genealogy programs.

##Requirements

These programs are written in command-line php.  To run them on Debian/Ubuntu
versions of Linux, you need to install:

    sudo apt-get install php5-cli
    
For how to install command line PHP in other environments, see [PHP](http://php.net/).     

##Usage

###readgroup
First retrieve the [latest haplogroup tree for A](http://www.isogg.org/tree/ISOGG_HapgrpA.html)
from the ISOGG web site, and save it locally:

    curl -O http://www.isogg.org/tree/ISOGG_HapgrpA.html

Now, redirect that file to the input of readgroup.php and redirect the
output to a new local file. 

    php readgroup.php <ISOGG_HapgrpA.html >A.txt
    
This reads the copy of the web page, attempts to reformat
the sometimes inconsistent text, and writes the results to stdout (in this example, redirected to A.txt).

Change the letter A (before .html) to another value for a different haplogroup.  Current acceptable values are single
letters from A to T, inclusive.

The results look like this, in subclade order:

    A1b1b2*|-
    A1b1b2a|M51/Page42,M229,M239/Page89,P71,P100
    
The subclade is followed by |.  Then the SNPs are shown, separated with commas.  
If a SNP has aliases, they are separated with a /.

###readindex
First retrieve the [latest Y-DNA SNP Index](http://www.isogg.org/tree/ISOGG_YDNA_SNP_Index.html) 
from the ISOGG web site and save it locally:

    curl -O http://www.isogg.org/tree/ISOGG_YDNA_SNP_Index.html
    
Now, redirect that file to the input of readindex.php and redirect the
output to a new local file.    

    php readindex.php <ISOGG_YDNA_SNP_Index.html >index.txt
    
This reads the copy of the web page, attempts to reformat
the sometimes inconsistent text, and writes the results to stdout (in this example, redirected to index.txt)    

The results are intended to be the same as that page, in SNP order.  The fields are separated by |, 
and are SNP, haplogroup, alternate names, refSNP id, Y-position, and mutation.

If there is more than one alternate name, they are separated with a semicolon and space.

##compare
The compare program is a very early version.  It is intended to check for
consistency between and within each of the group files, and the index file.

Many of the inconsistences are typos, some are formatting problems
like commas missing that garble values.

So far, this checks that each SNP listed in the group file is present in the 
index file, and that each subclade in the index file is in a group file.

Known bugs: does not yet handle two letter groups like BT.  Assumes index file
is named index.txt, this will become a parameter soon.

    php compare.php <G.txt

This runs the compare for the group G, and prints the result to stdout.

Example of results:

    M3428 for G2a not found in index
    PF3344 for G2a2b2a not found in index
    G1a1a is present in index L201 but not in group file
    G2a2b2a1a1a1 is present in index L1263 but not in group file


##Roadmap

The next step (in progress) is improve the compare (consistency check)
program, adding extra checks and improving what it already does.

Future plans could include a combined output in a more re-usable form
such as json, and running against old versions of the haplogroup trees.

Suggestions and comments, and (especially) bug reports are very
welcome.  Please use Github issues or pull requests for these, so they can be tracked.

##Credits

Although Rob Hoare is a member of ISOGG, these programs and OpenGenealogy have
no connection with ISOGG, nor with the creation of the Y-tree. I appreciate the 
efforts of the many ISOGG volunteers that provide such a great resource for genetic genealogy.

The [Y-DNA Haplogroup Tree](http://www.isogg.org/tree/index.html) that is
read by these programs is (c) Copyright 2014 International Society of Genetic Genealogy.
