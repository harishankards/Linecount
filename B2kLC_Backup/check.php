<?php
session_start();
$stillLoggedIn = timeCheck();
echo $stillLoggedIn;
function timeCheck()
{
	if(!isset($_SESSION['isLoggedIn']))
	{
		session_unset();
		return true;
		exit;
	}
	else
	{
		// user is logged in
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
		$hasSessionExpired = checkIfTimedOut();
                
		if($hasSessionExpired)
		{
			session_unset();
			return true;
		}
		else
		{
			return false;
                       
		}
	}
}
?>