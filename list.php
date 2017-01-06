<?php
/*
Files Lister
============
Very simple files/sub-dirs/media lister.
images get a small thumbnail, and sub-dirs are supported too.

no need to put the file in every sub-dir, just the most upper one.
you can assign a relative home-dir, from which the user cannot list out.
you can cancel the show sub-dirs option.
you can show only media files if you want.
support for up-dir (..) is cancelled for security reasons.
when a file named icon.gif/jpg/ico exists in a sub-dir - it is used as a thumbnail for the sub-dir.

Installation:
Just put the file in your home dir, and name it what you want.
Options:
parameter method options default description
========= ====== ======= ======= ===========
dir $_GET $dirdef subdir (without a slash)
media $_GET 1/0 $mediadef hide non-media files

$homedir variable the base relative home dir. u must add a slash at the end.
$mediaopt variable 1/0 1 show the option to switch between hide/show non-media files?
$mediadef variable 1/0 0 media default status, and permanent status when $mediaopt==0
$showdirs variable 1/0 1 show sub-dirs? when disabled, the dir parameter is also not available


author: Original (aka OriA)
date: 2005-07-30
copyrights: common, it took me 3 minutes of base code (and 2 hours of improovments...)
feel free to do whatever you want with it :)

Thats me, Original
*/

//error_reporting(0);


// parameters:
$homedir=''; // relative home dir
$mediadef=0; // hide non-medias by default?
$mediaopt=1; // show the option of switching between media mode?
$showdirs=1; // show sub-dirs?

// link to me
$me=basename($_SERVER['PHP_SELF']);

// current dir
if ($showdirs){
echo "Content of ";
// get sub-dir from GET
$cdir=''.$_GET['dir'];
// security - dont allow get out of home-dir by deleting suspicious dir characters
$cdir=str_replace('\\' ,'/',$cdir);
while (strpos($cdir,'/..')!==false) $cdir=str_replace('/..','/',$cdir);
while (strpos($cdir,'/./')!==false) $cdir=str_replace('/./','/',$cdir);
while (strpos($cdir,'//' )!==false) $cdir=str_replace('//' ,'/',$cdir);
while (strpos('\\/.',substr($cdir,0,1))!==false) $cdir=substr($cdir,1);
echo "$cdir/ ";
}else{
echo "Content:";
$cdir=$dir='';
}
$dir=$homedir.$cdir;
if ($dir!='') $dir.='/';

// show only media files? (media = php mediatypes = medias and swf)
if ($mediaopt){
$media=''.$_GET['media'];
if ($media==='') $media=$mediadef;
if ($media){
echo " &nbsp;<a href=\"$me?dir=$cdir&media=0\">(show all files)</a>";
}else{
echo " &nbsp;<a href=\"$me?dir=$cdir&media=1\">(hide non-media)</a>";
}
}else{
$media=$mediadef;
}

echo "<br>";

// fix for different code pages
function fixurl($str){
//return str_replace('%'.dechex(ord('/')),'/',htmlentities(rawurlencode($str)));
$ret='';
for($i=0;$i<strlen($str);$i++){
if ($str{$i}=='/'){
$ret.='/';
}else{
//$ret.='%'.dechex(ord($str{$i}));
$ret.=htmlentities(rawurlencode($str{$i}));
}
}
return $ret;
}

// show files
if (!$files=glob($dir."*.*")){
echo "<i>no files</i><br>";
}else{
foreach ($files as $file){
if (!is_dir($file) && $file!=basename($_SERVER['PHP_SELF'])){

// thumbnail:

// once there was a cool exif thumbnail system here - but the simple extensions method prooved to be better...

// get file extension
$ext=pathinfo($file);
$ext=strtolower($ext['extension']);
$images=array('jpg','jpeg','jp2','jpx','gif','png','ico','bmp','wbmp','tiff','iff','tif','pcx');
$movies=array('avi','mov','swf','swc');
$type='';
if (in_array($ext,$images)) $type='image';
if (in_array($ext,$movies)) $type='movie';
$text=$file;
if ($type=='movie'){
$text.=" <embed align=middle width=36 height=36 border=0 autostart=false src=\"".fixurl($dir).fixurl(basename($file))."\"></embed>";
//$text.=" <img align=middle height=36 border=0 src=\"http://www.w3.org/Icons/movie.gif\" />";
}elseif ($type=='image'){
$text.=" <img align=middle width=36 height=36 border=0 src=\"".fixurl($dir).fixurl(basename($file))."\" />";
}
if ($type || !$media){
echo "<a href=\"".fixurl($dir).fixurl(basename($file))."\">$text</a><br>";
}
}
}
}


// show sub-dirs
if ($showdirs){
if ($mediaopt){
$img="&media=$media";
}else{
$img='';
}

$d=0;
$dh = opendir($dir.'.');
while (false !== ($file = readdir($dh))) {
if ($file!='..' && $file!='.' && is_dir($dir.$file)) {
if ($d++==0) echo "<br>Sub-dirs:<br>";
$text=$file;
// add an icon to a sub-folder
if (file_exists($file.'/icon.gif')) $text.=" <img border=1 height=36 width=36 src=\"".fixurl($dir).fixurl($file)."/icon.gif\" />";
if (file_exists($file.'/icon.jpg')) $text.=" <img border=1 height=36 width=36 src=\"".fixurl($dir).fixurl($file)."/icon.jpg\" />";
if (file_exists($file.'/icon.jpeg'))$text.=" <img border=1 height=36 width=36 src=\"".fixurl($dir).fixurl($file)."/icon.jpeg\" />";
if (file_exists($file.'/icon.ico')) $text.=" <img border=1 height=36 width=36 src=\"".fixurl($dir).fixurl($file)."/icon.ico\" />";
echo "<b><a href=\"$me?dir=".$cdir.($cdir=='' ? '':'/').fixurl(basename($file))."$img\">$text</a><br></b>";
}
}
closedir($dh);

// show home link
if ($cdir!='') echo "<br><a href=\"$me?dir=$img\">Back to home dir</a><br>";
}

?>
