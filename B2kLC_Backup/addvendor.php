<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:190px; padding: .2em; text-align:left; }

select,textarea { margin-bottom:0px; width:195px; padding: .2em; text-align:left; }

#e_vndr,#e_vndr_cp{text-transform:uppercase;}
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_vndr.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Team name"});
      return false;
    }
	if(thisform.e_vndr_add.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Team Address"});
      return false;
    }
	if(thisform.e_vndr_of.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Team name"});
      return false;
    }
	if(thisform.e_vndr_cp.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Team Contact Person Name"});
      return false;
    }
	if(thisform.e_vndr_ph1.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Phone Number"});
      return false;
    }
	if(thisform.e_vndr_ml1.value==='')
    {
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Mail ID"});
      	return false;
    }
	thisform.submit();
	save();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Team"});
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
          <div id="main">
          <br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Team Details</h2></center>
          <table cellpadding="2" align="center" cellspacing="5">
          
          <tr>
          <td>Team Name</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr" id="e_vndr" size="28" Value="" class="text ui-widget-content ui-corner-all"/> *</td>
          </tr>
          
	      <tr>
          <td>Address</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="e_vndr_add" id="e_vndr_add" cols="22" rows="5" class="text ui-widget-content ui-corner-all"/></textarea> *</td></td>
          </tr>
          
           <tr>
          <td>Office Number</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_of" id="e_vndr_of" size="28" Value="" class="text ui-widget-content ui-corner-all" /> *</td></td>
          </tr>
          
          <tr>
          <td>Contact Person</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_cp" id="e_vndr_cp" size="28" Value="" class="text ui-widget-content ui-corner-all" /> *</td>
          </tr>
          <tr>
          <td>Phone number(s)</td>
          <td>:</td>
          <td>+91&nbsp;&nbsp;<input type="text" name="e_vndr_ph1" id="e_vndr_ph1" size="24" maxlength="10" Value="" class="text ui-widget-content ui-corner-all" /> *<br><br>

			  +91&nbsp;&nbsp;<input type="text" name="e_vndr_ph2" id="e_vndr_ph2" class="text ui-widget-content ui-corner-all" maxlength="10" size="24" Value="" /><br><br>
			  +91&nbsp;&nbsp;<input type="text" name="e_vndr_ph3" id="e_vndr_ph3" class="text ui-widget-content ui-corner-all" maxlength="10" size="24" Value="" /><br>
<br>
	
          </td>
          </tr>
          
          <tr>
          <td>Mail ID</td>
          <td>:</td>
          <td>(1)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_ml1" id="e_vndr_ml1" size="25" Value="" class="text ui-widget-content ui-corner-all" /> *<br><br>
		      (2)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="e_vndr_ml2" id="e_vndr_ml2" size="25" Value="" class="text ui-widget-content ui-corner-all" /><br>
          </td>
          </tr>
     
          </table>
          <table cellpadding="1" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="reset" /></td></tr>
          </table>
          </form>
          <br>
           <center><h2>Select a Team to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Team--</option>
                    <?php
                    $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $vend=$row['Vendor_name'];
                    echo '<option value="'.htmlentities($vend).'">'.htmlentities($vend).'</option>';
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

if(isset($_POST['e_vndr'],$_POST['e_vndr_add'],$_POST['e_vndr_cp'],$_POST['e_vndr_of'],$_POST['e_vndr_ph1'],$_POST['e_vndr_ml1']))
{
$vndr_name=mysql_real_escape_string($_POST['e_vndr']);
$vndr_name=mysql_real_escape_string(strtoupper($vndr_name));	
$vndr_add=mysql_real_escape_string($_POST['e_vndr_add']);
$vndr_off=mysql_real_escape_string($_POST['e_vndr_of']);
$vndr_cntctprsn=mysql_real_escape_string($_POST['e_vndr_cp']);
$vndr_ph1=mysql_real_escape_string($_POST['e_vndr_ph1']);
$vndr_ph1="+91 ".$vndr_ph1;
$vndr_ph2=mysql_real_escape_string($_POST['e_vndr_ph2']);
$vndr_ph2="+91 ".$vndr_ph2;
$vndr_ph3=mysql_real_escape_string($_POST['e_vndr_ph3']);
$vndr_ph3="+91 ".$vndr_ph3;
$vndr_mail1=mysql_real_escape_string($_POST['e_vndr_ml1']);
$vndr_mail2=mysql_real_escape_string($_POST['e_vndr_ml2']);
$sql=mysql_query("INSERT INTO `vendor` VALUES ('NULL','$vndr_name','$vndr_add','$vndr_off','$vndr_cntctprsn','$vndr_ph1','$vndr_ph2','$vndr_ph3','$vndr_mail1','$vndr_mail2')");
if($sql)
{
	$comment=$loginas." has added a Team Details [".$vndr_name."] into the Database";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Team details added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"addvendor.php\";}, 0);
								}
							});
							</script>";
}
}
if(isset($_POST['searchfield1']))
{	
	$vndr=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `vendor` WHERE `Vendor_name`='$vndr'");
	if($result)
	{
		$comment=$loginas." has deleted  Team Details [".$vndr."] from the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Team details Deleted Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"addvendor.php\";}, 0);
								}
							});
							</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
