<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_name.value==='Username')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Username"});
      return false;
    }
	if(thisform.e_pass.value==='Password')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Password"});
      return false;
    }
	
	if(thisform.e_hsp.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Hospital"});
      return false;
    }

	if(thisform.e_clnt.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a valid Client"});
      return false;
    }
	if(thisform.e_plt.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a valid Platform"});
      return false;
    }
	if(thisform.e_wrk.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a valid Working status"});
      return false;
    }
	thisform.submit();
	save();
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
          <center><h2>Enter the ID Details</h2></center>
          <table cellpadding="2" align="center" cellspacing="2">
          
          	<tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value="Username" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" autocomplete="off"/></td>
            </tr>
            
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="text" name="e_pass" id="e_pass" size="28" Value="Password" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" autocomplete="off"/></td>
            </tr>
            
            <tr>
                <td>Choose a Client</td>
                <td>:</td>
                <td>
                    <select name="e_clnt" id="e_clnt" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Client--</option>
                    <?php
                    $sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $clnt=$row['Client_name'];
                    echo '<option value="'.htmlentities($clnt).'">'.htmlentities($clnt).'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Choose a Platform</td>
                <td>:</td>
                <td>
                    <select name="e_plt" id="e_plt" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Platform--</option>
                    <?php
                    $sql=mysql_query("select `Platform_name` from `platform` order by `Platform_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $plat=$row['Platform_name'];
                    echo '<option value="'.htmlentities($plat).'">'.htmlentities($plat).'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Choose a Hospital</td>
                <td>:</td>
                <td>
                    <select name="e_hsp" id="e_hsp" class="text ui-widget-content ui-corner-all" >
                    <option selected="selected" value="-1">--Select Hospital--</option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
                    echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Working Status</td>
                <td>:</td>
                <td>
                    <select name="e_wrk" id="e_wrk"  class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Working Status--</option>
                    <option value="Working">Working</option>
                    <option value="Not Working">Not Working</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Alloted to</td>
                <td>:</td>
                <td><input type="text" name="e_altd" id="e_altd" size="28" Value="" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" autocomplete="off"/></td>
            </tr>
            
          </table>
          <table cellpadding="1" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['e_plt'],$_POST['e_clnt'],$_POST['e_hsp'],$_POST['e_name'],$_POST['e_pass'],$_POST['e_wrk']))
{
	$name=mysql_real_escape_string($_POST['e_name']);
	$name=strtoupper($name);
	$pass=mysql_real_escape_string($_POST['e_pass']);
	$hos=mysql_real_escape_string($_POST['e_hsp']);
	$plat=mysql_real_escape_string($_POST['e_plt']);
	$clnt=mysql_real_escape_string($_POST['e_clnt']);
	$wrk=mysql_real_escape_string($_POST['e_wrk']);
	if(!($_POST['e_altd']==''))
	{
		$alloted_to=mysql_real_escape_string($_POST['e_altd']);
	}
	else
	{
		$alloted_to='Not alloted';
	}
	$sql=mysql_query("INSERT INTO `id_details` VALUES ('NULL','$clnt','$plat','$hos','$name','$pass','$wrk','$alloted_to')");
	if($sql)
	{
		$comment=$loginas." has added ID [".$name."] into the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"ID Details added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"addid.php\";}, 0);
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
