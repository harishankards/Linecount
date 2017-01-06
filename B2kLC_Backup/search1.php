<?php

// Get the variable that we sent.
$str = $_GET['s'];

// Declare the array filled with months and
// an empty array where we can store months
// that match our search query.
$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$months_match = array();

if(strlen($str)) {
	// Set a counter variable for outputting.
	$count = 0;
	
	// Run a loop through all of the $months array.
	// We will check each spot for a match.
	for($i = 0; $i < count($months); $i++) {
		// If our search string is inside of $months[$i] and the
		// position of our search string is at 0 then proceed.
		if(stristr($months[$i], $str) && strpos($months[$i], $str) == 0) {
			// Add the matched month to the next spot in
			// $months_match array.
			$months_match[] = $months[$i];
			$count++;
		}
	}
	
	// Now we need to loop through our $months_match
	// array and output each spot.
	for($i = 0; $i < count($months_match); $i++) {
		echo $months_match[$i];
		// If we just outputted the last spot in the
		// array, then don't output a line break - 
		// it is not needed after the last spot.
		if($i != (count($months_match) - 1)) {
			echo "<br />";
		}
	}
	
	// If we didn't find anything that matched our
	// search query, then output 'None found'.
	if($count == 0) {
		echo "<b>None found</b>";
	}
}

?>
