<?php
		// open the current directory
		$dhandle0 = opendir($main_dir);
		// define an array to hold the files
		$files0 = array();
		if ($dhandle0) {
		   // loop through all of the files
		   while (false !== ($fname0 = readdir($dhandle0))) {
			  // if the file is not this file, and does not start with a '.' or '..',
			  // then store it for later display
			  if (($fname0 != '.') && ($fname0 != '..') &&
				  ($fname0 != basename($_SERVER['PHP_SELF']))) {
				  // store the filename
				  $files0[] = (is_dir( "./$fname0" )) ? "(Dir) {$fname0}" : $fname0;
			  }
		   }
		   // close the directory
		   closedir($dhandle0);
		}
		echo "<select name=\"year\" id=\"year\" > \n";
		echo "<option selected=\"selected\" value=\"-1\">";if(isset($_POST['year'])) echo $_POST['year']; else echo "---Select Year ---</option>\n";
		// Now loop through the files, echoing out a new select option for each one
		foreach( $files0 as $fname0 )
		{
		   echo "<option>{$fname0}</option>\n";
		}
		echo "</select>\n";
		?></td>
        <td>
        <?php
		// open the current directory
		$dhandle1 = opendir($path_year.'/');
		// define an array to hold the files
		$files1 = array();
		if ($dhandle1) {
		   // loop through all of the files
		   while (false !== ($fname1 = readdir($dhandle1))) {
			  // if the file is not this file, and does not start with a '.' or '..',
			  // then store it for later display
			  if (($fname1 != '.') && ($fname1 != '..') &&
				  ($fname1 != basename($_SERVER['PHP_SELF']))) {
				  // store the filename
				  $files1[] = (is_dir( "./$fname1" )) ? "(Dir) {$fname1}" : $fname1;
			  }
		   }
		   // close the directory
		   closedir($dhandle1);
		}
		
		echo "<select name=\"month\" id=\"month\" >\n";
		echo "<option selected=\"selected\" value=\"-1\">";if(isset($_POST['month'])) echo $_POST['month']; else echo "---Select Month ---</option>\n";
		// Now loop through the files, echoing out a new select option for each one
		foreach( $files1 as $fname1 )
		{
		   echo "<option>{$fname1}</option>\n";
		}
		echo "</select>\n";
?>