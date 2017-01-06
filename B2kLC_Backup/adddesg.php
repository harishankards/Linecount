<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:190px; padding: .2em; text-align:left; }

select,textarea { margin-bottom:0px; width:195px; padding: .2em; text-align:center; }

</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_des.value==='Add Designation')
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Please Enter a Designation to add"
			});
      return false;
    }
	thisform.submit();
	save();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
       dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Please choose a Designation to delete"
			});
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
          <center><h2>Enter the Designation Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="5">
          <tr><td style="font-weight:bold;">Designation Post</td><td>:</td><td><input type="text" name="e_des" id="e_des" size="28" Value="Add Designation" class="text ui-widget-content ui-corner-all" onFocus="clearText(this)" onBlur="clearText(this)" /></td></tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
           <center><h2>Select a Designation to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="adddesignation" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" class="text ui-widget-content ui-corner-all" >
                    <option selected="selected" value="-1">--Select Designation--</option>
                    <?php
                    $sql=mysql_query("select `Designation` from `designation` order by `Designation`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Designation'];
                    echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
                  	<input type="button" name="Searchdes" value="Delete" alt="Search" id="Searchdes" title="Search" onClick="checkdes(this.form)" />
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

if(isset($_POST['e_des']))
{
$desg=mysql_real_escape_string($_POST['e_des']);
$desg=strtoupper($desg);
$sql=mysql_query("INSERT INTO `designation` VALUES ('NULL','$desg')");
if($sql)
{
	$comment=$loginas." has added Designation Details into Database";
	$fp = fopen($log_dir.$loginas.".txt", "at");
	fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Designation details added Successfully !!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"adddesg.php\";}, 0);
							}
						});
						</script>";
}
}
if(isset($_POST['searchfield1']))
{	
	$des=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `designation` WHERE `Designation`='$des'");
	if($result)
	{
		$comment=$loginas." has deleted Designation Details from Database";
		$fp = fopen($log_dir.$loginas.".txt", "at");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Designation details Deleted Successfully !!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"adddesg.php\";}, 0);
							}
						});
						</script>";
	}
}
?>
</body>
<script src="js/element.js"></script>
</html>
