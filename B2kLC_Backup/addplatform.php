<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_plt.value==='Add Platform')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Platform"});
      return false;
    }

	if(thisform.e_clnt.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a valid Client"});
      return false;
    }
	thisform.submit();
	save();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a valid Platform"});
      return false;
    }
	thisform.submit();
	del();
}
</script>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }

#e_plt{ text-transform:uppercase;}
</style>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main"><br />
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Platform Details</h2></center>
          <table cellpadding="2" align="center" cellspacing="5">
          <tr><td>Platform Name</td><td>:</td><td><input type="text" name="e_plt" id="e_plt" size="28" Value="Add Platform" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all"/></td></tr>
            <tr><td>Choose a Client</td><td>:</td><td>
            <select name="e_clnt" id="e_clnt" class="text ui-widget-content ui-corner-all">
            <option selected="selected" value="-1">--Select Client--</option>
            <?php
            $sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
            while($row=mysql_fetch_array($sql))
            {
            $des=$row['Client_name'];
            echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
            }
            ?>
            </select>
            </td>
            </tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
           <center><h2>Select a Platform to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Platform--</option>
                    <?php
                    $sql=mysql_query("select `Platform_name` from `platform` order by `Platform_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Platform_name'];
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

if(isset($_POST['e_plt'],$_POST['e_clnt']))
{
$plat=mysql_real_escape_string($_POST['e_plt']);
$clnt=mysql_real_escape_string($_POST['e_clnt']);
$plat=mysql_real_escape_string(strtoupper($plat));
$sql=mysql_query("INSERT INTO `platform` VALUES ('NULL','$clnt','$plat')");
if($sql)
{
	$comment=$loginas." has added a Platform Details [".$plat."] into the Database";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Platform details added Successfully!!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"addplatform.php\";}, 0);
							}
						});
						</script>";
}
}
if(isset($_POST['searchfield1']))
{	
	$des=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `platform` WHERE `Platform_name`='$des'");
	if($result)
	{
		$comment=$loginas." has deleted a Platform Details [".$des."] from the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Platform Details details Deleted Successfully!!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"addplatform.php\";}, 0);
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

