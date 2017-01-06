<?php 
error_reporting(0);
include('top.php');?>
<style>
input.text{ margin-bottom:0px; width:125px; padding: .2em; text-align:left; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
.ui-datepicker-calendar {
    display: none;
    }
</style>
<style>
  .ui-tabs-vertical { width: 55em; }
  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
 
  </style>
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    <form name="monthsub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    		<table align="center">
            <tr>
            <td>Month</td>
            <td>:</td>
            <td> <input type="text" id="monthpicker" title="Select the Date" name="month" value="<?php echo date('F Y');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/>
			</td>
            <td>ID</td>
            <td>:</td>
            <td>
            <select name="esid" class="text ui-widget-content ui-corner-all">
            <option value="-1" selected="selected">--Show All--</option>
            <?php
			
			$id=mysql_query("SELECT `User_ID` FROM `escript_id`");
			while($row=mysql_fetch_array($id))
			{
				echo "<option value=\"".$row['User_ID']."\">".$row['User_ID']."</option>";
			}	
			?>
            </select>
           <!-- <div class="ui-widget">
              <input id="tags" size="50" name="esid" class="text ui-widget-content ui-corner-all"/>
            </div>-->
            </td>
            <td align="center"><input type="submit" name="fsubmit" value="Show" /></td>
            </tr>
            <tr></tr>
            </table>
    </form>
    
    
    <?php
	if(isset($_POST['month'],$_POST['esid']))
	{
		$month=$_POST['month'];
		$esid=$_POST['esid'];
		if($esid=="-1")
		{
			$que="SELECT `User_ID` FROM `escript_id` ORDER BY `User_ID`";
		}
		else
		{
			/*echo $esid;
			$dat=explode(", ",$esid);
			for($i=0;$i<count($dat);$i++)
			{
				echo $dat[$i];
				echo "`User_ID`='$dat[$i]'";
			}
			*/
			$que="SELECT `User_ID` FROM `escript_id` WHERE `User_ID`='$esid' ORDER BY `User_ID`";
		}
		
		echo "<div id=\"tabs\" style=\"margin-left:80px; display:compact;\">";
		echo "<ul style=\"height: 750px; width:120px; overflow: auto; \">";
		
		$id_set=mysql_query($que);
		$c=1;
		while($id_s_row=mysql_fetch_array($id_set))
		{
			echo "<li><a href=\"#tabs-".$c."\">".$id_s_row['User_ID']."</a></li>";
			$c=$c+1;
		}
		echo "</ul>";
        $a=1;
		$id_query=mysql_query($que);
		while($idrow=mysql_fetch_array($id_query))
		{
			$id=mysql_real_escape_string($idrow['User_ID']);
			$intat_d_typd2=0;
			$intat_nd_typd2=0;
			$intat_d_edtd2=0;
			$intat_nd_edtd2=0;
			$outtat_d_typd2=0;
			$outtat_nd_typd2=0;
			$outtat_d_edtd2=0;
			$outtat_nd_edtd2=0;
			$intat_d_typd4=0;
			$intat_nd_typd4=0;
			$intat_d_edtd4=0;
			$intat_nd_edtd4=0;
			$outtat_d_typd4=0;
			$outtat_nd_typd4=0;
			$outtat_d_edtd4=0;
			$outtat_nd_edtd4=0;
			$intat_d_typd6=0;
			$intat_nd_typd6=0;
			$intat_d_edtd6=0;
			$intat_nd_edtd6=0;
			$outtat_d_typd6=0;
			$outtat_nd_typd6=0;
			$outtat_d_edtd6=0;
			$outtat_nd_edtd6=0;
			$intat_d_typd8=0;
			$intat_nd_typd8=0;
			$intat_d_edtd8=0;
			$intat_nd_edtd8=0;
			$outtat_d_typd8=0;
			$outtat_nd_typd8=0;
			$outtat_d_edtd8=0;
			$outtat_nd_edtd8=0;
			$intat_d_typd12=0;
			$intat_nd_typd12=0;
			$intat_d_edtd12=0;
			$intat_nd_edtd12=0;
			$outtat_d_typd12=0;
			$outtat_nd_typd12=0;
			$outtat_d_edtd12=0;
			$outtat_nd_edtd12=0;
			$intat_d_typd24=0;
			$intat_nd_typd24=0;
			$intat_d_edtd24=0;
			$intat_nd_edtd24=0;
			$outtat_d_typd24=0;
			$outtat_nd_typd24=0;
			$outtat_d_edtd24=0;
			$outtat_nd_edtd24=0;
			$d_intat_conv2=0;
			$d_outtat_conv2=0;
			$nd_intat_conv2=0;
			$nd_outtat_conv2=0;
			$d_intat_conv4=0;
			$d_outtat_conv4=0;
			$nd_intat_conv4=0;
			$nd_outtat_conv4=0;
			$d_intat_conv6=0;
			$d_outtat_conv6=0;
			$nd_intat_conv6=0;
			$nd_outtat_conv6=0;
			$d_intat_conv12=0;
			$d_outtat_conv12=0;
			$nd_intat_conv12=0;
			$nd_outtat_conv12=0;
			$d_intat_conv24=0;
			$d_outtat_conv24=0;
			$nd_intat_conv24=0;
			$nd_outtat_conv24=0;
			$query=mysql_query("SELECT * FROM `escript_report` WHERE `User_ID`='$id' AND `Month-Year`='$month'");
			
			 echo "<div id=\"tabs-".$a."\">";	
			$a=$a+1;		
			echo "<h3 style=\"color:#0099FF; text-align:center;\">".$id."-".$month."</h3>";
			echo "<p style=\"padding-left:-10px; font-size:14px; text-align:center;\">This gives the details about the 2, 4, 6, 8, 10, 12, 24 hours IN TAT and OUT TAT details of the ID \"".$id."\"</p>";
			echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
			echo "<tr  class=\"ui-widget-header\">
				<td align=\"center\" rowspan=\"2\" width=\"40%\">
					<b>DSP / Non DSP</b>
				</td>
				<td colspan=\"4\" align=\"center\">
					<b>USER ID : ".$id." / Month : ".$month."</b>
				</td>
			</tr>
			<tr class=\"ui-widget-header\">
				<td width=\"20%\" align=\"center\">
					<b>TAT STATUS</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>TYPED</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>EDITED</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>CONVERTED</b>
				</td>
			</tr>";
			while($report=mysql_fetch_array($query))
			{
				if($report['Exp_TAT']<='2')
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd2=$intat_d_typd2+$report['DSP_Typed'];
						$intat_nd_typd2=$intat_nd_typd2+$report['NDSP_Typed'];
						$intat_d_edtd2=$intat_d_edtd2+$report['DSP_Edited'];
						$intat_nd_edtd2=$intat_nd_edtd2+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd2=$outtat_d_typd2+$report['DSP_Typed'];
						$outtat_nd_typd2=$outtat_nd_typd2+$report['NDSP_Typed'];
						$outtat_d_edtd2=$outtat_d_edtd2+$report['DSP_Edited'];
						$outtat_nd_edtd2=$outtat_nd_edtd2+$report['NDSP_Edited'];
					}
				}
				if(($report['Exp_TAT']>'2') && ($report['Exp_TAT']<='4'))
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd4=$intat_d_typd4+$report['DSP_Typed'];
						$intat_nd_typd4=$intat_nd_typd4+$report['NDSP_Typed'];
						$intat_d_edtd4=$intat_d_edtd4+$report['DSP_Edited'];
						$intat_nd_edtd4=$intat_nd_edtd4+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd4=$outtat_d_typd4+$report['DSP_Typed'];
						$outtat_nd_typd4=$outtat_nd_typd4+$report['NDSP_Typed'];
						$outtat_d_edtd4=$outtat_d_edtd4+$report['DSP_Edited'];
						$outtat_nd_edtd4=$outtat_nd_edtd4+$report['NDSP_Edited'];
					}
				}
				if(($report['Exp_TAT']>'4') && ($report['Exp_TAT']<='8'))
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd6=$intat_d_typd6+$report['DSP_Typed'];
						$intat_nd_typd6=$intat_nd_typd6+$report['NDSP_Typed'];
						$intat_d_edtd6=$intat_d_edtd6+$report['DSP_Edited'];
						$intat_nd_edtd6=$intat_nd_edtd6+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd6=$outtat_d_typd6+$report['DSP_Typed'];
						$outtat_nd_typd6=$outtat_nd_typd6+$report['NDSP_Typed'];
						$outtat_d_edtd6=$outtat_d_edtd6+$report['DSP_Edited'];
						$outtat_nd_edtd6=$outtat_nd_edtd6+$report['NDSP_Edited'];
					}
				}
				if(($report['Exp_TAT']>'8') && ($report['Exp_TAT']<='12'))
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd8=$intat_d_typd8+$report['DSP_Typed'];
						$intat_nd_typd8=$intat_nd_typd8+$report['NDSP_Typed'];
						$intat_d_edtd8=$intat_d_edtd8+$report['DSP_Edited'];
						$intat_nd_edtd8=$intat_nd_edtd8+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd8=$outtat_d_typd8+$report['DSP_Typed'];
						$outtat_nd_typd8=$outtat_nd_typd8+$report['NDSP_Typed'];
						$outtat_d_edtd8=$outtat_d_edtd8+$report['DSP_Edited'];
						$outtat_nd_edtd8=$outtat_nd_edtd8+$report['NDSP_Edited'];
					}
				}
				if($report['Exp_TAT']>'12')
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd12=$intat_d_typd12+$report['DSP_Typed'];
						$intat_nd_typd12=$intat_nd_typd12+$report['NDSP_Typed'];
						$intat_d_edtd12=$intat_d_edtd12+$report['DSP_Edited'];
						$intat_nd_edtd12=$intat_nd_edtd12+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd12=$outtat_d_typd12+$report['DSP_Typed'];
						$outtat_nd_typd12=$outtat_nd_typd12+$report['NDSP_Typed'];
						$outtat_d_edtd12=$outtat_d_edtd12+$report['DSP_Edited'];
						$outtat_nd_edtd12=$outtat_nd_edtd12+$report['NDSP_Edited'];
					}
				}
				/*if($report['Exp_TAT']=='24')
				{
					if($report['TAT']=="IN TAT")
					{
						$intat_d_typd24=$intat_d_typd24+$report['DSP_Typed'];
						$intat_nd_typd24=$intat_nd_typd24+$report['NDSP_Typed'];
						$intat_d_edtd24=$intat_d_edtd24+$report['DSP_Edited'];
						$intat_nd_edtd24=$intat_nd_edtd24+$report['NDSP_Edited'];
					}
					else
					{
						$outtat_d_typd24=$outtat_d_typd24+$report['DSP_Typed'];
						$outtat_nd_typd24=$outtat_nd_typd24+$report['NDSP_Typed'];
						$outtat_d_edtd24=$outtat_d_edtd24+$report['DSP_Edited'];
						$outtat_nd_edtd24=$outtat_nd_edtd24+$report['NDSP_Edited'];
					}
				}
				*/
			}
			$d_intat_conv2=(2*$intat_d_typd2)+$intat_d_edtd2;
			$d_outtat_conv2=(2*$outtat_d_typd2)+$outtat_d_edtd2;
			$nd_intat_conv2=(2*$intat_nd_typd2)+$intat_nd_edtd2;
			$nd_outtat_conv2=(2*$outtat_nd_typd2)+$outtat_nd_edtd2;
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">0 &<= 2 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd2."</td><td>".$intat_d_edtd2."</td><td>".$d_intat_conv2."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">0 &<= 2 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd2."</td><td>".$outtat_d_edtd2."</td><td>".$d_outtat_conv2."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">0 &<= 2 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd2."</td><td>".$intat_nd_edtd2."</td><td>".$nd_intat_conv2."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">0 &<= 2 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd2."</td><td>".$outtat_nd_edtd2."</td><td>".$nd_outtat_conv2."</td></tr>";
			$d_intat_conv4=(2*$intat_d_typd4)+$intat_d_edtd4;
			$d_outtat_conv4=(2*$outtat_d_typd4)+$outtat_d_edtd4;
			$nd_intat_conv4=(2*$intat_nd_typd4)+$intat_nd_edtd4;
			$nd_outtat_conv4=(2*$outtat_nd_typd4)+$outtat_nd_edtd4;
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">2 &<= 4 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd4."</td><td>".$intat_d_edtd4."</td><td>".$d_intat_conv4."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">2 &<= 4 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd4."</td><td>".$outtat_d_edtd4."</td><td>".$d_outtat_conv4."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">2 &<= 4 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd4."</td><td>".$intat_nd_edtd4."</td><td>".$nd_intat_conv4."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">2 &<= 4 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd4."</td><td>".$outtat_nd_edtd4."</td><td>".$nd_outtat_conv4."</td></tr>";
			$d_intat_conv6=(2*$intat_d_typd6)+$intat_d_edtd6;
			$d_outtat_conv6=(2*$outtat_d_typd6)+$outtat_d_edtd6;
			$nd_intat_conv6=(2*$intat_nd_typd6)+$intat_nd_edtd6;
			$nd_outtat_conv6=(2*$outtat_nd_typd6)+$outtat_nd_edtd6;
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">4 &<= 8 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd6."</td><td>".$intat_d_edtd6."</td><td>".$d_intat_conv6."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">4 &<= 8 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd6."</td><td>".$outtat_d_edtd6."</td><td>".$d_outtat_conv6."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">4 &<= 8 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd6."</td><td>".$intat_nd_edtd6."</td><td>".$nd_intat_conv6."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">4 &<= 8 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd6."</td><td>".$outtat_nd_edtd6."</td><td>".$nd_outtat_conv6."</td></tr>";
			$d_intat_conv8=(2*$intat_d_typd8)+$intat_d_edtd8;
			$d_outtat_conv8=(2*$outtat_d_typd8)+$outtat_d_edtd8;
			$nd_intat_conv8=(2*$intat_nd_typd8)+$intat_nd_edtd8;
			$nd_outtat_conv8=(2*$outtat_nd_typd8)+$outtat_nd_edtd8;
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">8 &<= 12 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd8."</td><td>".$intat_d_edtd8."</td><td>".$d_intat_conv8."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">8 &<= 12 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd8."</td><td>".$outtat_d_edtd8."</td><td>".$d_outtat_conv8."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">8 &<= 12 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd8."</td><td>".$intat_nd_edtd8."</td><td>".$nd_intat_conv8."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">8 &<= 12 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd8."</td><td>".$outtat_nd_edtd8."</td><td>".$nd_outtat_conv8."</td></tr>";
			$d_intat_conv12=(2*$intat_d_typd12)+$intat_d_edtd12;
			$d_outtat_conv12=(2*$outtat_d_typd12)+$outtat_d_edtd12;
			$nd_intat_conv12=(2*$intat_nd_typd12)+$intat_nd_edtd12;
			$nd_outtat_conv12=(2*$outtat_nd_typd12)+$outtat_nd_edtd12;
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">12 &<= 999hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd12."</td><td>".$intat_d_edtd12."</td><td>".$d_intat_conv12."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">12 &<= 999 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd12."</td><td>".$outtat_d_edtd12."</td><td>".$d_outtat_conv12."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td style=\"text-align:left;\">12 &<= 999 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd12."</td><td>".$intat_nd_edtd12."</td><td>".$nd_intat_conv12."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td style=\"text-align:left;\">12 &<= 999 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd12."</td><td>".$outtat_nd_edtd12."</td><td>".$nd_outtat_conv12."</td></tr>";
			/*
			$d_intat_conv24=(2*$intat_d_typd24)+$intat_d_edtd24;
			$d_outtat_conv24=(2*$outtat_d_typd24)+$outtat_d_edtd24;
			$nd_intat_conv24=(2*$intat_nd_typd24)+$intat_nd_edtd24;
			$nd_outtat_conv24=(2*$outtat_nd_typd24)+$outtat_nd_edtd24;
			echo "<tr align=\"center\" class=\"tr0\"><td>24 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd24."</td><td>".$intat_d_edtd24."</td><td>".$d_intat_conv24."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td>24 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd24."</td><td>".$outtat_d_edtd24."</td><td>".$d_outtat_conv24."</td></tr>";
			echo "<tr align=\"center\" class=\"tr0\"><td>24 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd24."</td><td>".$intat_nd_edtd24."</td><td>".$nd_intat_conv24."</td></tr>";
			echo "<tr align=\"center\" class=\"tr1\"><td>24 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd24."</td><td>".$outtat_nd_edtd24."</td><td>".$nd_outtat_conv24."</td></tr>";
			*/
			echo "</table></p></div>";
		}
		echo "</div>";
	}
	Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"viewemonxl.php\">";
	Print "<input type=\"hidden\" Value=\"$month\" name=\"month\" id=\"month\" />";
	Print "<input type=\"hidden\" Value=\"$esid\" name=\"esid\" id=\"esid\" />";
	Print "<input type=\"submit\" value=\"Get details as Excel\" name=\"Filedetails\"/>";
	Print "</form></center></td></tr></table>";
	?>
    <br />
    <br />
    <br />
    </div> <!-- end of main -->
    <div id="main_bottom"></div>

   	<?php include('footer.php');?>
	<script>
	   $(function() {
		$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	  });
	  
	</script>
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
</html>
