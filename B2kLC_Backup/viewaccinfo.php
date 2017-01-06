<?php include('top.php');?>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    <h2>Select the Account Name to see the details</h2>
    <div id="search_drop" style="margin-left:315px;">
    <center>
    
        <form name="account" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <select name="searchfield1" id="searchfield1" >
            <option selected="selected" value="-1">--Select Account--</option>
            <?php
            $sql=mysql_query("SELECT * FROM `acc_info` order by `Account_Name` ");
            while($row=mysql_fetch_array($sql))
            {
            $hsp=$row['Account_Name'];
            echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
            }
            ?>
            </select>&nbsp;&nbsp;
            <input type="submit" name="Searchdes" value="Search" alt="Search" id="Searchdes" title="Search" onClick="show()" />
        </form>
    </center>
    </div>
    
    <?php
	if(isset($_POST['searchfield1']))
	{
		echo "<br><br><br><br><br><br>";
		$acc=$_POST['searchfield1'];
		echo "<h4><center>General Instructions / Informattions of Account \"&nbsp;".$acc."&nbsp;\"</center></h4>";
		
		$main_query=mysql_query("SELECT * FROM `acc_info` WHERE `Account_Name`='$acc' order by `Account_Name`");
		$no=mysql_num_fields($main_query);
		echo "<table align=\"center\" width=\"600\" border=\"0\" bordercolor=\"000\" cellpadding=\"15\" style=\"padding-left:0px\">";
		while($vnrow=mysql_fetch_array($main_query))
		{
			for($i=1;$i<$no;$i++)
			{
			$col=mysql_field_name($main_query,$i);
			echo "<tr><td class=\"tdleft\">".$col."</td><td class=\"tdmid\">:</td><td class=\"tdright\">".$vnrow[$i]."</td></tr>";
			} 
		}
		echo "</table>";
	}	
	?>
	<br>
    <br>
    <br>
    <br>
    <br>
    <br>
   
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
