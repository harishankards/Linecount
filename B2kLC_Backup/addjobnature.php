<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_nat.value==='Add Account Nature')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Account Nature"});
      return false;
    }
	thisform.submit();
	save();
}
function checknat(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Valid Account Nature"});
      return false;
    }
	thisform.submit();
	del();
}
</script>

</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Account Nature</h2></center>
          <table cellpadding="1" align="center" cellspacing="5">
          <tr><td>Account Nature (Maximum No. of Blanks Allowed)</td><td>:</td><td><input type="text" name="e_nat" id="e_nat" size="28" Value="Add Account Nature" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" /></td></tr>
          </table>
          <table cellpadding="1" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
          <br>
          <br>
           <center><h2>Select account nature to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                   <select name="searchfield1" id="searchfield1">
                        <option selected="selected" value="-1">--Select Account Nature--</option>
                        <?php
                        $sql=mysql_query("select `Nature` from `jobnature` order by `Nature` ");
                        while($row=mysql_fetch_array($sql))
                        {
                        $nat=$row['Nature'];
                        echo '<option value="'.htmlentities($nat).'">'.htmlentities($nat).'-Blank(s)</option>';
                        }
                        ?>
            		</select>&nbsp;&nbsp;
                  	<input type="button" name="Searchdes" value="Delete" alt="Search" id="Searchdes" title="Search" onClick="checknat(this.form)" />
                </form>
                </center>
            </div>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['e_nat']))
{
$nature=mysql_real_escape_string(trim($_POST['e_nat'],' '));
$sql=mysql_query("INSERT INTO `jobnature` VALUES ('NULL','$nature')");
if($sql)
{
	$comment=$loginas." has added Account Nature [".$nature."] into the Database";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> alert('Account nature details added Successfully');</script>";
	echo "<script> setTimeout(function(){ window.location = \"addjobnature.php\";}, 0);</script>";
}
}
if(isset($_POST['searchfield1']))
{	
	$nature=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `jobnature` WHERE `Nature`='$nature'");
	if($result)
	{
		$comment=$loginas." has Deleted Account Nature [".$nature."] from the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> alert('Designation details Deleted Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"addjobnature.php\";}, 0);</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
