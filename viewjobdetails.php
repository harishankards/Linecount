<?php include('top.php');?>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    
    <table width="900">
    <tr>
    <td>
    <?php
	$cc=1;
	$cr=0;
	$comment=$loginas." has viewed job Details.";
	$fp = fopen($log_dir.$loginas.".txt", "a+");
	fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
	fclose($fp);
	$client=mysql_query("SELECT * FROM `vendor` order by `Vendor_name`");
	echo "<h4><center>Team Details</center></h4>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">";
	echo "<th>S.No</th><th>Client</th>";
	while($vnrow=mysql_fetch_array($client))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\"><td>".$cc."</td><td>".$vnrow['Vendor_name']."</td></tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	?>
    </td>
    </tr>
    </table><br><br>
    <table width="900">
    <tr>
    <td>
    <?php
	$cc=1;
	$cr=0;
	$client=mysql_query("SELECT * FROM `client` order by `Client_name`");
	echo "<h4><center>Client Details</center></h4>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">";
	echo "<th>S.No</th><th>Client</th>";
	while($clrow=mysql_fetch_array($client))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\"><td>".$cc."</td><td>".$clrow['Client_name']."</td></tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	?>
    </td>
    <td>
    <?php
	$cc=1;
	$cr=0;
	$platform=mysql_query("SELECT * FROM `platform` order by `Platform_name`");
	echo "<h4><center>Platform Details</center></h4>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\" >";
	echo "<th>S.No</th><th>Client</th><th>Platform</th>";
	while($plrow=mysql_fetch_array($platform))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\"><td>".$cc."</td><td>".$plrow['Client']."</td><td>".$plrow['Platform_name']."</td></tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	?>
    </td>
    <td>
    <?php
	$cc=1;
	$cr=0;
	$nature=mysql_query("SELECT * FROM `jobnature` order by `Nature`");
	echo "<h4><center>Account Nature Details</center></h4>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">";
	echo "<th>S.No</th><th>Nature</th>";
	while($ntrow=mysql_fetch_array($nature))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\"><td>".$cc."</td><td>".$ntrow['Nature']."</td></tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	?>
    </td>
    </tr>
    </table>
    <br><br><br><br>
    <table width="900" align="center">
    <tr align="center">
    <td>
    <?php
	$cc=1;
	$cr=0;
	$hosp=mysql_query("SELECT * FROM `hospitals` order by `Hospital_name`");
	echo "<h4><center>Hospital Details</center></h4>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"2\">";
	echo "<th>S.No</th><th>Client</th><th>Platform</th><th>Hospitals</th><th>MAX. Blanks</th>";
	while($hrow=mysql_fetch_array($hosp))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\">
		<td>".$cc."</td>
		<td>".$hrow['Client']."</td>
		<td>".$hrow['Platform']."</td>
		<td>".$hrow['Hospital_name']."</td>
		<td>".$hrow['Job_nature']."</td>
		</tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	?>
    </td>
    </tr>
    </table>      
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
