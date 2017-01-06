<?php session_start();
mysql_connect("localhost","root","") or die(mysql_error());  
mysql_select_db("b2k_database") or die(mysql_error());  

if(isset($_GET['user']) && isset($_GET['message'])) {
  if(trim($_GET['user']) != "" && trim($_GET['message']) != "") {
    $message = strip_tags(mysql_real_escape_string(trim($_GET['message'])));  
    $user    = strip_tags(mysql_real_escape_string(trim($_GET['user'])));  
	
	$_SESSION['username'] = $user;

    $s = "INSERT INTO message(username,message,posted) VALUES ('$user', '$message',NOW())";
    $q = mysql_query($s) or die(mysql_error());
  }
}
	
  $s = "SELECT username,message,posted FROM message WHERE (DAY(posted) = DAY(CURDATE()) AND MONTH(posted) = MONTH(CURDATE()) AND YEAR(posted) = YEAR(CURDATE())) ORDER BY posted ASC";
  $q = mysql_query($s) or die(mysql_error());  
	
?>
<?php while($r = mysql_fetch_array($q)) { 
  if($r['username'] == $_SESSION['username']) $user_bg = '#2C50A2'; else $user_bg = '#FF3333'; 
?>
    <div style="color:<?php echo $user_bg; ?>"><?php echo "<strong>" . $r['username'] . " says:</strong> " . date('g:i:s a', strtotime($r['posted'])); ?></div>
    <div style="padding-left:5px; padding-bottom:15px;"><?php echo $r['message']; ?></div>
<?php } ?>