<?php include('top.php');?>
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    	<h2>Files uploaded by the MLS and Admin</h2>
        <h4>Content of Domain in upload folder</h4>
       <?php
	   	echo"<div class=\"roundborder\" style=\"width:400px; height: auto; float:left;\">";
		echo"<div><br><br>";
		//error_reporting(0);
		// parameters:
		$homedir=$log; // relative home dir
		$mediadef=0; // hide non-medias by default?
		$mediaopt=1; // show the option of switching between media mode?
		$showdirs=1; // show sub-dirs?
		// link to me
		$me=basename($_SERVER['PHP_SELF']);
		
		// current dir
		if ($showdirs){
		echo "<strong>Content of</strong> ";
		// get sub-dir from GET
		if(!isset($_GET['dir']))
		{
		$_GET['dir']='';
		}
		$cdir=''.$_GET['dir'];
		// security - dont allow get out of home-dir by deleting suspicious dir characters
		$cdir=str_replace('\\' ,'/',$cdir);
		while (strpos($cdir,'/..')!==false) $cdir=str_replace('/..','/',$cdir);
		while (strpos($cdir,'/./')!==false) $cdir=str_replace('/./','/',$cdir);
		while (strpos($cdir,'//' )!==false) $cdir=str_replace('//' ,'/',$cdir);
		while (strpos('\\/.',substr($cdir,0,1))!==false) $cdir=substr($cdir,1);
		echo "<strong>$cdir/ </strong>";
		}else{
		echo "Content:";
		$cdir=$dir='';
		}
		$dir=$homedir.$cdir;
		if ($dir!='') $dir.='/';
		
		// show only media files? (media = php mediatypes = medias and swf)
		if ($mediaopt){
		if(!isset($_GET['media']))
		{
		$_GET['media']='';
		}
		$media=''.$_GET['media'];
		if ($media==='') $media=$mediadef;
		if ($media){
		echo " &nbsp;<table><tr><td><img border=1 height=25 width=25 src=\"menu/button-add_sticker.png\" /></td><td><a href=\"$me?dir=$cdir&media=0\">(show all files)</a></td></tr></table>";
		}else{
		echo " &nbsp;<table><tr><td><img border=1 height=25 width=25 src=\"menu/button-remove_sticker.png\" /></td><td><a href=\"$me?dir=$cdir&media=1\">(hide non-media)</a></td></tr></table>";
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
		$mov_at='';
		$img_at='';
		// get file extension
		$ext=pathinfo($file);
		$ext=strtolower($ext['extension']);
		$images=array('jpg','jpeg','jp2','jpx','gif','png','ico','bmp','wbmp','tiff','iff','tif','pcx');
		$movies=array('avi','mov','swf','swc','flv');
		$type='';
		if (in_array($ext,$images)) $type='image';
		if (in_array($ext,$movies)) $type='movie';
		$text=$file;
		if ($type=='movie'){
		$mov_at="<embed align=middle width=36 height=36 border=0 autostart=false src=\"".fixurl($dir).fixurl(basename($file))."\"></embed>";
		//$text.=" <img align=middle height=36 border=0 src=\"http://www.w3.org/Icons/movie.gif\" />";
		}elseif ($type=='image'){
		$img_at="<img align=middle width=36 height=36 border=0 src=\"".fixurl($dir).fixurl(basename($file))."\" />";
		}
		if ($type || !$media){
		//echo $text."<br>";
		//echo $main_dir."<br>";
		$len=strlen($homedir);
		$e_len=strlen($text);
		//$homedir=trim($homedir," ");	
		$file_name=substr($text,$len,$e_len);
		//echo $file_name."<br>";
		//echo "<a href=\"".fixurl($dir).fixurl(basename($file))."\">$text</a><br>";
		//echo $local_dir."<br>";
		echo "<table><tr><td><img border=1 height=25 width=25 src=\"menu/view_up.png\" /></td><td><a href=\"".$log_local.$file_name."\">".$file_name.$img_at.$mov_at."</a></td></tr></table>";
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
		if ($d++==0) echo "<br><strong>Sub-dirs:</strong><br>";
		$text=$file;
		// add an icon to a sub-folder
		if (file_exists($file.'menu/folder.png')) $text.=" ";
		echo "<b><table><tr><td><img border=1 height=25 width=25 src=\"menu/folder.png\" /></td><td><a href=\"$me?dir=".$cdir.($cdir=='' ? '':'/').fixurl(basename($file))."$img\">$text</a></td></tr></table></b>";
		}
		}
		closedir($dh);
		
		// show home link
		if ($cdir!='') echo "<br><table><tr><td><img border=1 height=25 width=25 src=\"menu/home.png\" /></td><td><a href=\"$me?dir=$img\">Back to home dir</a></td></tr></table><br>";
		}
		echo "</div></div>";
?>			
        <div class="roundborder" style="width:400px; height: auto; float:right;">
        <br>
        <br>
		<h4>Download Directory</h4>
        <form name="download" action="createzip.php" method="post">
        <table align="center" width="300" cellpadding="5">
        <tr>
        <td>Select the Date</td>
        <td>:</td>
		<td>
		<input type="text" id="datepicker" title="Select the Date" name="downdate" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/> ( YYYY-MM-DD )
        </td>
        </tr>
        </table>
        
        <table align="center" width="50" cellpadding="5">
        <tr>
        <td>
        <input type="submit" name="download" id="download" value="Download">
        </td>
        </tr>
        </table>
        <center><p>Select the Date to download the files upoaded on that date</p></center>
        </form>
        <br>
        <br>
		<br>
		<br>
        <br>
		<br>
		<h4>Delete Directory</h4>
        <form name="delete" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="300" cellpadding="5">
        <tr>
        <td>Select the Date</td>
        <td>:</td>
		<td>
		<input type="text" id="datepicker1" title="Select the Date" name="deldate" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/> ( YYYY-MM-DD )
        </td>
        </tr>
        </table>
        
        <table align="center" width="50" cellpadding="5">
        <tr>
        <td>
        <input type="submit" name="delete" id="delete" value="Delete Directory">
        </td>
        </tr>
        </table>
        <center><p>Select the Date to delete the files upoaded on that date</p></center>
        </form>
        <br>
		<br>
		<br>
		</div>
        <br>
		<br>
		<br>
        <?php
		if(isset($_POST['deldate']))
		{
			
			$p_date=$_POST['deldate'];
			$year=date('Y', strtotime($p_date));
			$month=date('F-Y', strtotime($p_date));
			$dat=explode("-",$p_date);
			$date=$dat[2]."-".$dat[1]."-".$dat[0];
			
			$file_dir=$main_dir.$year."/".$month."/".$date."/";
			function Delete($path)
			{
				if (is_dir($path) === true)
				{
					$files = array_diff(scandir($path), array('.', '..'));
			
					foreach ($files as $file)
					{
						Delete(realpath($path) . '/' . $file);
					}
			
					return rmdir($path);
					
				}
			
				else if (is_file($path) === true)
				{
					return unlink($path);
				}
			
				return false;
			}
			$res_del=Delete($file_dir);
			if($res_del)
			{
				echo "<script> alert('Directory ".$file_dir."  is deleted Successfully !!!');</script>";
			}
			else
			{
				echo "<script> alert('Directory ".$file_dir."  is does not exisit !!!');</script>";
				echo "<script> window.location = window.location.href;</script>";
			}
			
		}
		?>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
        </center>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php
	if(isset($_GET['e']))
	{
		$error=$_GET['e'];
		echo "<script>alert('".$error."');</script>";
		echo "<script> setTimeout(function(){ window.location = \"listfiles.php\";}, 0);</script>";
	}
	?>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
