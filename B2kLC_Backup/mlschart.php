<?php 
error_reporting(0);
include('mlstop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center }
</style>
<style type="text/css" media="screen">
	#holder {
		height: 260px;
		margin: 0px 0 0 20px;
		width: 820px;
	}
</style>
<script src="charts/charts.js"></script>
<script src="charts/popup.js"></script>
<script src="charts/jquery.js"></script>
<script src="charts/analytics.js"></script>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <h2>Uploaded File Details </h2>
        <form name="sub" id="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
        
        <table align="center" width="500" cellpadding="2">
        	<tr align="center">
            <td class="show" colspan="6">Choose the Date to See the uploaded Files</td>
            </tr>
            <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            </tr>
        </table>
        <table align="center" width="400" cellpadding="10">
            <tr align="center">
                <td>
                <input type="submit" value="Search" name="search" id="search" onClick="show()">
                </td>
            </tr>
        </table>
	</form>
		<!-- div tag for showing results from jscript-->
<?php 
if(isset($_POST['date1'],$_POST['date2']))
{
	$from=mysql_real_escape_string($_POST['date1']);
	$to=mysql_real_escape_string($_POST['date2']);
	$s_date=$from;
	$e_date=$to;
	$uploadby=$_SESSION['idsilmlsname'];
	$fp = fopen($log_dir.$uploadby.".txt", "a+");
	$comment=$id." has viewed the file details in IDSIL / PJO from ".$s_date." to ".$e_date;
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$c=1;
	$r=0;
	$lc=0;
	$editlines=0;
	$blanklines=0;
	$dupeditlines=0;
	$dupblanklines=0;
	$count=1;
	if($count!=0)
	{	
	    $datediff = floor(strtotime($e_date)/(60*60*24)) - floor(strtotime($s_date)/(60*60*24));
		echo $datediff;
		//echo date('02-m-Y');
		?>
        
		<table id="data">
            <tfoot>
                <tr>
                    <?
					for($i=1;$i<=$datediff;$i++)
					{
					    $len=strlen($i);
						if($len<2)
						{
							$i="0".$i;
						}
						echo "<th>".$i."</th>";
						$dat=date("Y-m-$i");
						$t_lines=0;
						$result=mysql_query("SELECT `Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date`='$dat' AND	`Uploadedby`='$uploadby'");
						while($c_row=mysql_fetch_array($result))
						{
							$t_lines=$t_lines+$c_row['Linecount'];
						}
						$lines[]=$t_lines;
					}
					?>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <?
					for($j=0;$j<=$datediff;$j++)
					{
						
						echo "<td>".$lines[$j]."</td>";
					}
					?>
                </tr>
            </tbody>
        </table>
        <?
		echo "<div id=\"holder\"></div>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry no files found  !!!</center></h1><br /><br /><br /><br /><br /><br />";
	}
}
mysql_close($con);
?>
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
