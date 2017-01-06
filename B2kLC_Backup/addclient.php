<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_clnt.value==='Add Client')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Client"});
      return false;
    }
	thisform.submit();
	save();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Client"});
      return false;
    }
	thisform.submit();
	del();
}
</script>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; text-transform:uppercase; }
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
          <div id="main">
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Client Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="5">
          <tr><td>Client Name</td><td>:</td><td><input type="text" name="e_clnt" id="e_clnt" size="28" Value="Add Client" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" /></td></tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
          <center><h2>Select a Client to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
                <form name="addclient" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Client--</option>
                    <?php
                    $sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Client_name'];
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

if(isset($_POST['e_clnt']))
{
$client=mysql_real_escape_string($_POST['e_clnt']);
$client=strtoupper($client);
$sql=mysql_query("INSERT INTO `client` VALUES ('NULL','$client')");
	if($sql)
	{
		$comment=$loginas." has added Client Details into Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Client details added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"addclient.php\";}, 0);
								}
							});
							</script>";
	}
}
if(isset($_POST['searchfield1']))
{	
	$client=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `client` WHERE `Client_name`='$client'");
	if($result)
	{
		$comment=$loginas." has deleted Client Details from Database";
		$fp = fopen($log_dir.$loginas.".txt", "at");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Client details Deleted Successfully !!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"addclient.php\";}, 0);
							}
						});
						</script>";
	}
}
?>
</body>
<script src="js/element.js"></script>
</html>
