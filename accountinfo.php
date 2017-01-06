<?php include('top.php');?>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
   	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the Account Information</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          <?php
		  $main_query=mysql_query("SELECT * FROM `acc_info`");
          $no=mysql_num_fields($main_query);
		  $ser_no=mysql_field_name($main_query,0);
          echo "<input type=\"hidden\" name=\"s_no\" id=\"s_no\" value=\"".$ser_no."\">";
		  for($i=1;$i<$no;$i++)
          {
		  $col=mysql_field_name($main_query,$i);
          echo "<tr>
          <td class=\"tdcolor\">".$col."</td>
          <td>:</td>
          <td><textarea name=\"".$col."\" id=\"".$col."\" cols=\"25\" rows=\"2\"></textarea></td>
          </tr>";
		  }
          ?>
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="submit" value="Submit" name="sub" onClick="save()" /></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" onClick="save()" /></td></tr>
          </table>
          </form>
          	<?php
			if(isset($_POST['sub']))
			{			
				$cols="S.No";
				$values="'NULL'";
				$main_query=mysql_query("SELECT * FROM `acc_info`");
				$no=mysql_num_fields($main_query);
				for($i=1;$i<$no;$i++)
				{
				$col=mysql_field_name($main_query,$i);
				$cols.=",".$col;
				$values.=","."'".$_POST[$col]."'";
				}
				$query="INSERT INTO `acc_info` VALUES (".$values.")";
				$sql=mysql_query($query);
				if($sql)
				{
					$comment=$loginas." has added Account Information into the Database";
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> dhtmlx.alert({
							title:\"Success !!!\",
							ok:\"Ok\",
							text:\"Accounts details added Successfully\",
							callback:function(){
							setTimeout(function(){ window.location = \"accountinfo.php\";}, 0);
							}
						});
						</script>";
				}
				else
				{
					echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Accounts details already exist or incorrect!!!\",
							callback:function(){
							setTimeout(function(){ window.location = \"accountinfo.php\";}, 0);
							}
						});
						</script>";
				
				}
			}
mysql_close($con);
?>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->

</body>
<script src="js/element.js"></script>
</html>
