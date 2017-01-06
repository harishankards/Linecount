<?php include('editortop.php');?>
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
        <div id="main"><br><br>
        <div id="tabs">
          <ul>
            <li><a href="prevdaymls.php">MLS Prev. Day</a></li>
            <li><a href="todaymls.php">MLS Today</a></li>
            <li><a href="editorprevday.php">QC Prev. Day </a></li>
            <li><a href="editortoday.php">QC Today</a></li>
          </ul>
        </div>
        
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
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
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
