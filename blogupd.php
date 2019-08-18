<?php
//
// blog update script from GoogleDocs  by mtzhiro https://d0i.org/mtzhiro 2019
//
// License: GNU General Public License v2 or later
// License URI: http://www.gnu.org/licenses/gpl-2.0.html

$file = '/some/where/ready.txt';
$blogfile = '/some/www/html/blog/index.html';
$res = '';
$bstr ='';
$res = system('wget -q -O /some/where/blogfile.txt https://docs.google.com/document/d/1uaghaig9a8fa6jN2dYji1fXuus/edit');
$res = system('grep -o -e \+\+\+.*\+\+\+ /some/where/blogfile.txt > /some/where/content.txt');
$res = system('sed -r \'s/\\\\n/\\n/g\' /some/where/content.txt | grep -v \+\+\+> ' . $file);

// blog file header
$res = system('cat /some/where/bloghead.txt > ' . $blogfile);

// blog file content read
$fped = fopen($file, 'r');
while( ! feof( $fped ) ){
  $l = fgets( $fped, 9182);
  preg_match("/^###\s*([0-9]*)(.*)/", $l, $ai);
  $l = str_replace(array("\r\n","\r","\n"), '', $l);
  if (isset($ai[1]) ) {
    $ystr = date("Y");
    $d0i = '/0/156mtzhiroblog' . $ystr . $ai[1] . $ai[2];
    $link = 'https://d0i.org' . $d0i;
    $bstr .= '<a name="' .  $d0i .  '">' . $l . '</a>' . "\n";
    $bstr .=  '      d0i <a href="' . $link . '">' . $d0i . "</a>\n";
  } else {
    $bstr .= $l . "\n";
  }
}
fclose($fped);

//write into blog file
$fpa = fopen($blogfile, 'a');
fwrite($fpa, $bstr);
fclose($fpa);

// blog file footer
$res = system('cat /some/where/blogfoot.txt >> ' . $blogfile);
