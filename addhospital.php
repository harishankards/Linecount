<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
#e_clnt ,#e_plt ,#e_nat { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
#e_hsp { text-transform:uppercase;}
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_hsp.value==='Add Hospital')
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Please Enter a Hospital Name"
			});
      return false;
    }

	if(thisform.e_clnt.value==="-1")
    {
	   dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Choose a valid Client"
			});
      return false;
    }
	if(thisform.e_plt.value==="-1")
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Choose a valid Platform"
			});
      return false;
    }
	if(thisform.e_nat.value==="-1")
    {
      dhtmlx.alert({title:"Warning !!!",
			ok:"Ok",
			text:"Choose a valid Account Nature"
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
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a Valid Platform"});
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
          <center><h2>Enter the Hospital Details</h2></center>
          <table cellpadding="1" align="center" cellspacing="5" style="padding-left:100px;">
          <tr><td>Hospital Name</td><td>:</td><td><input type="text" name="e_hsp" id="e_hsp" size="28" Value="Add Hospital" onFocus="clearText(this)" onBlur="clearText(this)" class="text ui-widget-content ui-corner-all" /><b>* Donot Use (.) DOT</b></td></tr>
            <tr><td>Choose a Client</td><td>:</td><td>
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
            <td>Choose a Platform</td><td>:</td>
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
            <td>Account Nature</td><td>:</td>
            <td>
            <select name="e_nat" id="e_nat" class="text ui-widget-content ui-corner-all">
            <option selected="selected" value="-1">--Select Account Nature--</option>
            <?php
            $sql=mysql_query("select `Nature` from `jobnature` order by `Nature` ");	
            while($row=mysql_fetch_array($sql))
            {
            $nat=$row['Nature'];
            echo '<option value="'.htmlentities($nat).'">'.htmlentities($nat).'-Blank(s)</option>';
            }
            ?>
            </select>
            </td>
            </tr>
          </table>
          <table cellpadding="2" align="center" cellspacing="5">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
          <br>
           <center><h2>Select a Hospital to delete</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Hospital--</option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
                    echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
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

if(isset($_POST['e_plt'],$_POST['e_clnt'],$_POST['e_hsp'],$_POST['e_nat']))
{
$hos=trim($_POST['e_hsp']," ");
$hos=mysql_real_escape_string(strtoupper($hos));
$plat=mysql_real_escape_string($_POST['e_plt']);
$clnt=mysql_real_escape_string($_POST['e_clnt']);
$nat=mysql_real_escape_string($_POST['e_nat']);
$sql=mysql_query("INSERT INTO `hospitals` VALUES ('NULL','$clnt','$plat','$hos','$nat')");
if($sql)
{
	if($clnt=="Nuance")
	{
		$add_hos =mysql_query("ALTER TABLE `escript_id` ADD `$hos` VARCHAR(15) NOT NULL");	
	}
	$comment=$loginas." has added Hospital [".$hos."] into the Database";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	echo "<script> dhtmlx.alert({
			title:\"Success !!!\",
			ok:\"Ok\",
			text:\"Hospital details added Successfully !!!\",
			callback:function(){
			setTimeout(function(){ window.location = \"addhospital.php\";}, 0);
			}
		});
		</script>";
}
}
if(isset($_POST['searchfield1']))
{	
	$des=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `hospitals` WHERE `Hospital_name`='$des'");
	if($result)
	{
		echo "<script> dhtmlx.alert({
			title:\"Success !!!\",
			ok:\"Ok\",
			text:\"Hospital Details details Deleted Successfully !!!\",
			callback:function(){
			setTimeout(function(){ window.location = \"addhospital.php\";}, 0);
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
