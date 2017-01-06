<?php include('monitortop.php');?>
<style>
input.text { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }
fieldset { padding:0; border:0; margin-top:10px; }
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
    
   	<?php
    include('header.php');
    if(isset($_SESSION['Vendor_Admin']))
    { 
        include('ak_tecmenu.php');
        $vendor_name=$_SESSION['Vendor_Admin'];
    }
    ?>
    <div id="main_top"><center><br><?php echo"<label id=\"welcome_note\">Welcome ".$vendor_name."</label>";?></center></div>
    <div id="main"><br>
    <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <table align="center">
              <tr align="center">
                  <td>  
                      <div class="ui-widget">
                          <label for="tags">Search by Name : </label>
                          <input id="tags" name="empname" class="text ui-widget-content ui-corner-all"/>
                      </div>
                  </td>
                  <td><input type="submit" value="Check"></td>
              </tr>
         </table>
         </form>
         <br>
          <?php
		  	
			if(isset($_POST['empname']))
			{
				$emp_name=$_POST['empname'];
				$query="SELECT * FROM `mlsprofile` WHERE `Name` LIKE '%$emp_name%' order by `Name`";
			}
			else
			{
				$query="SELECT * FROM `mlsprofile` order by `Name`";
			}
			
			$result=mysql_query($query);
			$sendquery=$query;
			$count=mysql_num_rows($result);
			if($count>0)
			{
				$comment=$loginas." has Viewed MLS Profile Details";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
				Print "<center>"; 
				Print "<div style=\"width: 900px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table width=\"900\" border=\"1\" align=\"center\"  class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\">";
				Print "<tr class=\"ui-widget-header\"><th>Options</th><th>Employee ID</th><th>Name</th><th>Primary A/C</th><th>Secondary A/C</th><th>Tertiary A/C</th><th>Optional 1</th><th>Optional 2</th><th>Non DUP Trgt</th><th>DUP Trgt</th><th>Working Hours</th></tr>";
							
				Print "<tbody>";
				$c=1;
				$a=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" style=\"cursor:pointer;\" >";
					Print "<td align=\"center\" >".$a."</td> "; 
					Print "<td>".$row['ID'] . "</td> ";
					Print "<td>".$row['Name'] . "</td> ";
					Print "<td>".$row['Primary'] . "</td> ";
					Print "<td>".$row['Secondary'] . "</td> ";
					Print "<td> ".$row['Tertiary'] . " </td>";
					Print "<td>".$row['Optional_one'] . "</td> "; 
					Print "<td> ".$row['Optional_two'] . " </td>";
					Print "<td> ".$row['Target_lines'] . "</td>";
					Print "<td> ".$row['DUP_target'] . " </td>";
					Print "<td> ".$row['Work_timings'] . " </td>";
					Print "</tr>";
					if($c==1)
					{
						$c=0;
					}
					else
					{
						$c=1;
					}
					$a=$a+1;
				}
				Print "</tbody>";
				Print "</table>";
				Print "</div>";
				Print "</center>";
				
			echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
			Print "<br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
			Print "<input type=\"hidden\" Value=\"Employee Details\" name=\"rep_name\" id=\"name\" />";
			Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
			Print "<input type=\"submit\" value=\"Get Employee details as Excel\" name=\"Filedetails\"/>";
			Print "</form></center>";
			}
			else
			{
				echo "<br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br />";
			}
			
			?>  
           
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    <script>
    $(function() {
        $( document ).tooltip({
            track: true
        });
    });
	$(function() {
    $( "#dialog-form" ).dialog({
	  autoOpen: true,
      modal: true,
	  width: 330,
      buttons: {
        "Update Profile": function() {
          $('#updateprofile').submit();
        },
        Cancel: function() {
		  document.location.href = "viewmlsprofile.php";
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      }
    });
  });
    </script>
      <script>
  $(function() {
    var availableTags = [
		<?php
		$empsql=mysql_query("SELECT `Name` FROM `mlsprofile` order by `Name`");
		while($emprow=mysql_fetch_array($empsql))
		{
		$e_name=$emprow['Name'];
		echo '"'.$e_name.'",';
		}
		echo '"end"';
		?>

    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  function sub(thisform)
  {
  	thisform.submit();
  }
  </script>
  <script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_no.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee ID"});
      return false;
    }
	if(thisform.e_pass.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Password"});
      return false;
    }
	
	if(thisform.e_name.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee name"});
      return false;
    }
	
	if(thisform.e_vndr.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Vendor"});
      return false;
    }
	
	if(thisform.e_des.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Designation"});
      return false;
    }
	
	if(thisform.e_status.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a ID Status"});
      return false;
    }
	thisform.submit();
	save();
}
</script>
 <?
			if(isset($_GET['del_emp_no']))
			{		
				$value=mysql_real_escape_string($_GET['del_emp_no']);	
				$del=mysql_query("DELETE FROM `mlsprofile` WHERE `ID`='$value'");
				if($del)
				{
					$comment=$loginas." has MLS Profile ".$value;
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Employee Profile details of ID ".$value." deleted successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"viewmlsprofile.php\";}, 0);
								}
							});
							</script>";
				}
			}
			if(isset($_GET['up_no']))
			{	
				$mls_id=$_GET['up_no'];
				$mls_q=mysql_query("SELECT `ID`,`Name`,`Target_lines`,`DUP_target` FROM `mlsprofile` WHERE `ID`='$mls_id'");
				while($mls_r=mysql_fetch_array($mls_q))
				{
					$non_dup=$mls_r['Target_lines'];
					$dup=$mls_r['DUP_target'];
					$mls_name=$mls_r['Name'];
					$mls_id=$mls_r['ID'];
				}
				?>
				 <div id="dialog-form" title="Profile Update">
				  <form id="updateprofile" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
				  <fieldset>
					<table align="center">
                    <tr>
					<td>
					<label for="ID">ID</label>
					</td>
					<td>:</td>
					<td>
					<input type="text" name="mls_id" id="mls_id" value="<?php echo $mls_id; ?>" class="text ui-widget-content ui-corner-all" readonly="readonly" />
					</td>
					</tr>
                    <tr>
					<td>
					<label for="name">Name</label>
					</td>
					<td>:</td>
					<td>
					<input type="text" name="mls_name" id="mls_name" value="<?php echo $mls_name; ?>" class="text ui-widget-content ui-corner-all" readonly="readonly" />
					</td>
					</tr>
                    
					<tr>
					<td>
					<label for="DUP">DUP Lines</label>
					</td>
					<td>:</td>
					<td>
					<input type="text" name="dup_line" id="dup_line" value="<?php echo $dup; ?>" class="text ui-widget-content ui-corner-all" />
					</td>
					</tr>
					<tr>
					<td>
					<label for="NON DUP">NON DUP Lines</label>
					</td>
					<td>:</td>
					<td>
					<input type="text" name="ndup_line" id="ndup_line" value="<?php echo $non_dup; ?>" class="text ui-widget-content ui-corner-all" />
					</td>
					</tr>
					</table>
				  </fieldset>
				  </form>
				</div>
				<?
			}
			if(isset($_POST['dup_line'],$_POST['ndup_line'],$_POST['mls_id'],$_POST['mls_name']))
			{
				$dup_line=mysql_real_escape_string($_POST['dup_line']);
				$ndup_line=mysql_real_escape_string($_POST['ndup_line']);
				$mls_id=mysql_real_escape_string($_POST['mls_id']);
				$mls_name=mysql_real_escape_string($_POST['mls_name']);
				$up_mls=mysql_query("UPDATE `mlsprofile` SET `Target_lines`='$ndup_line',`DUP_target`='$dup_line' WHERE `ID`='$mls_id'");
				if($up_mls)
				{
					echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Employee Profile details of ID ".$value." Updated successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"viewmlsprofile.php\";}, 0);
								}
							});
							</script>";
				}
			}
			?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
