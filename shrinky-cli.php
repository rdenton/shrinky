<?php
/*
	The MIT License (MIT)

	Copyright (c) 2013 Richard Denton / eMarketeer Australia

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

require_once 'shrinky.php';

//Make sure a CSS file has been specified.
if ( $argc < 2 ) {
	print("Usage: php shrinky.php /path/to/style.css /path/to/style.min.css\n\n");
	exit();
}

$shrinky_fpin = $argv[1];

//Does the file exist?
if ( !file_exists($shrinky_fpin) ) {
	print("File specified does not exist\n");
	exit();
}

//Read the original stylesheet.
$shrinky_fh = fopen($shrinky_fpin,"r");
$shrinky_css = fread($shrinky_fh, filesize($shrinky_fpin));
fclose($shrinky_fh);

//Shrinky CSS
$shrinky = new shrinky_css($shrinky_css);
$shrinky->shorten_colors();
$shrinky->strip_whitespace();

if ( $argc >= 3 ) {
	//Write output file.
	$fh = fopen($argv[2],"w");
	fwrite($fh, $shrinky->result());
	fclose($fh);
	
	print ("\nShrinkified css file written to ".$argv[2]."\n");
	
}

print ("ShrinkyCSS has saved ".$shrinky->bytes_saved()." bytes.\n\n");

?>