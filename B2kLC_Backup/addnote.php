<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_content.value==='')
    {
      alert("Please enter a Content ");
      return false;
    }
	if(thisform.to_whom.value==='-1')
    {
      alert("Please Choose To ");
      return false;
    }
	if(thisform.client.value==='-1')
    {
      alert("Please Choose Client ");
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
          <form name="addnote" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter Today's Updates</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          
          	<tr>
                <td>Date</td>
                <td>:</td>
                <td>
				<input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/> 
                </td>
                 </td>
            </tr>
            
            <tr>
                <td>Client</td>
                <td>:</td>
                <td>
                <select name="client" id="client" class="text ui-widget-content ui-corner-all">
                 	<option value="-1" selected="selected">--Select--</option>
                    <option value="All">All</option>
                    <option value="Escription">E-Scription</option>
                    <option value="IDSIL">IDSIL / PJO</option>
                </select>
                </td>
                 </td>
            </tr>
            <tr>
                <td>To</td>
                <td>:</td>
                <td>
				<select name="to_whom" id="to_whom" class="text ui-widget-content ui-corner-all">
                 	<option value="-1" selected="selected">--Select--</option>
                 	<option value="All">All</option>
                    <option value="MT">MLS / MT</option>
                    <option value="QC">Editor / QC</option>
                </select>
                </td>
                 </td>
            </tr>
            
            <tr>
                <td>Content </td>
                <td>:</td>
                <td><textarea name="e_content" id="e_content" rows="5" cols="22" class="text ui-widget-content ui-corner-all"></textarea></td>
            </tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['date5'],$_POST['e_content'],$_POST['client'],$_POST['to_whom']))
{
	$date=mysql_real_escape_string($_POST['date5']);
	$cont=mysql_real_escape_string($_POST['e_content']);
	$client=mysql_real_escape_string($_POST['client']);
	$to=mysql_real_escape_string($_POST['to_whom']);
	$sql=mysql_query("INSERT INTO `notes` VALUES ('NULL','$date','$cont','$client','$to')");
	if($sql)
	{
		$comment=$loginas." has added an Update into the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> alert('Information added Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"addnote.php\";}, 0);</script>";
	}
	
}
?>
</body>
</html>
