<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_fields.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Valid Column Name"});
      return false;
    }
	thisform.submit();
	save();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a Valid column Name"});
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
          <center><h2>Enter the Column Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          <tr><td style="font-weight:bold;">Colomn Name</td><td>:</td><td><input type="text" name="e_fields" id="e_fields" size="28" Value="" onFocus="clearText(this)" onBlur="clearText(this)" /></td></tr>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
           <center><h2>Select a Column to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="adddesignation" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Column--</option>
                    <?php
                   	$main_query=mysql_query("SELECT * FROM `acc_info`");
					$no=mysql_num_fields($main_query);
					for($i=2;$i<$no;$i++)
					{
					$col=mysql_field_name($main_query,$i);
					echo "<option>".$col."</option>";
					}
                    ?>
            </select>&nbsp;&nbsp;
                  	<input type="button" name="Searchdes" value="Delete" alt="Search" id="Searchdes" title="Search" onClick="checkdes(this.form)" />
                </form>
                </center>
            </div>
			<br />
			<br />
			<br />
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['e_fields']))
{
	$fields=mysql_real_escape_string($_POST['e_fields']);
	//$fields=strtoupper($fields);
	$sql=mysql_query("ALTER TABLE `acc_info` ADD ".$fields." TEXT NOT NULL");
	if($sql)
	{
		$comment=$loginas." has added Column Details in Account Information";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
			title:\"Success !!!\",
			ok:\"Ok\",
			text:\"Colomn Name added Successfully\",
			callback:function(){
			setTimeout(function(){ window.location = \"addaccfields.php\";}, 0);
			}
		});
		
		</script>";
	}
}
if(isset($_POST['searchfield1']))
{	
	$fields=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("ALTER TABLE `acc_info` DROP `".$fields."`");
	if($result)
	{
		$comment=$loginas." has deleted Column Details in Account Information";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"Column Name Deleted Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"addaccfields.php\";}, 0);
				}
			});
			
			</script>";
	}
}
?>
</body>
<script src="js/element.js"></script>
</html>
