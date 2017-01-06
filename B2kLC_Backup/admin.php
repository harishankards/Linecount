<?php include('top.php');?>
<style>
.redalert{
color:#FF0000;}
.greenalert{
color:#0066FF;
}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php
	include('main_top.php');
	?>
    <div id="main"><br>
        <br>
        <h2>Current Employee Status</h2>
         <div id="tabs" >
          <ul>
            <li><a href="prevdaymls.php">MLS Prev.</a></li>
            <li><a href="todaymls.php">MLS Today</a></li>
            <li><a href="editorprevday.php">QC Prev. Day </a></li>
            <li><a href="editortoday.php">QC Today</a></li>
            <li><a href="currentwork.php">Current Status</a></li>
            <li><a href="noncomplaint.php">Non Complaint</a></li>
            <li><a href="messages.php">New Messages</a></li>
          </ul>
        </div>
        </div>
        
        <div class="cleaner"></div>
        <div class="cleaner"></div>
        </center>
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <script>
 $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "<div><center><br><br><br><br><img src=\"images/ajax/01.gif\"></center><br><br><br><br><br><div>" );
        });
      }
    });
  });
  </script>
<?php
echo '<script>
		  $(function() {
		$( "#dialog" ).dialog({
		  modal: true,
		  width: 450
		});
		});
	  </script>';

	$leave_q=mysql_query("SELECT `Date_of_request` FROM  `leave_request` WHERE `Permission_status`='Pending'");
	$count_leave=mysql_num_rows($leave_q);
	if($count_leave!=0)
	{
		echo "<div id=\"dialog\" title=\"For Your Information\">
				<center><img src=\"images/b2k_logo.png\" height=\"55\" width=\"78\"></center>";
		echo '<p style="padding-top:10px; padding-left:10px; text-align:left;"><span class="ui-icon ui-icon-check" style="float: left; margin-right: .3em;"></span>';
		echo "Today ".$count_leave." Members have requested Leave <a href=\"confirmleave.php\" style=\"color:#549bcc\">Click here</a> to see that.</p>";
		echo "</div>";
	}

?>
  
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>