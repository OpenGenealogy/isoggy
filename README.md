isoggy
======

Extract (and later validate) information from the ISOGG Y-DNA Haplogroup Tree,
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

##Roadmap

The next step (in progress) is to compare the haplogroup files with the index file, to
check that these programs work, and that the index is complete.

Future plans could include a combined output in a more re-usable form
such as json, and running against old versions of the haplogroup trees.

Suggestions and comments, and (especially) bug reports are very
welcome.  Please use Github issues or pull requests for these, so they can be tracked.

##Credits

OpenGenealogy and Rob Hoare are not connected to ISOGG or their data. We appreciate the 
efforts of their many volunteers to provide this great resource for genetic genealogy.

The [Y-DNA Haplogroup Tree](http://www.isogg.org/tree/index.html) that is
read by these programs is Copyright 2014
 International Society of Genetic Genealogy.
