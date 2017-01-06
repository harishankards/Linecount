<?php include('top.php');?>
<script type="text/javascript" language="javascript">
function confirm_del(thisform)
{
	if(document.getElementById('from_del').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a FROM date"});
		return false;
	}
	if(document.getElementById('to_del').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a TO date"});
		return false;
	}
     if(confirm('Are you sure, You want to delete this data ?'))
	 {
	 	 if(confirm('Make sure you have a Backup, After deleting your data cannot be retrived !!!'))
		 {
			thisform.submit();
		 }
	 }
	 else
	 {
	 	return false;
	 }
}
</script>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }

</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <h2>InHouse Linecount Details </h2>
        <form name="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <table align="center" width="500" cellpadding="5">
           <tr align="center">
            <td class="result" colspan="6">Choose the Date to delete the file details</td>
            </tr>
            <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from_del" name="date1" class="text ui-widget-content ui-corner-all" value="" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to_del" name="date2" class="text ui-widget-content ui-corner-all" value="" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            </tr>
        </table> 
        <center><p style="color:#FF0000; font-size:9pt;"><b>WARNING !!! <br>Please take backup before deleting the data, <br>because after deleting the data no chance of recovery</b></p></center>
           
        <table align="center" width="500" cellpadding="5">
           <tr align="center">
                <td>
                <input type="button" value="Delete the data" name="search" id="search" onClick="confirm_del(this.form)" style="height:30px; width:150px;">
                </td>
            </tr>
        </table>
	</form>
    <br><br>

<?php
if(isset($_POST['date1'],$_POST['date2']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$sql=mysql_query("DELETE FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date'");
	if($sql)
	{
		$comment=$loginas." has deleted a file details in Database from ".$s_date." to ".$e_date.".";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"File details deleted Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewupload.php\";}, 0);
					}
				});
				</script>";
	}
	else
	{
		echo "<script> dhtmlx.alert({
					title:\"Error !!!\",
					ok:\"Ok\",
					text:\"File details cannot be deleted !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewupload.php\";}, 0);
					}
				});
				</script>";
	}
}
mysql_close($con);
?>
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
