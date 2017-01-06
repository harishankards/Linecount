<?php
	function checkIfTimedOut()
	{
		$current = time();// take the current time
		$diff = $current - $_SESSION['loggedinAt'];
		if($diff > $_SESSION['timeOut_sec'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>