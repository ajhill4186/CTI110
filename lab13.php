<!DOCTYPE html>
<html lang="en">
<head>
<!--Name: Alexander Hill
	Filename: lab13.php
	Blackboard User Name: ajhill@my.waketech.edu
	Class Section: CTI.110.5871
	Purpose: Calculate Event Costs 
-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>L13 Concert Event</title>
	<link rel="stylesheet" type="text/css" href="./lab13.css">
</head>
<body>
    
	<?php
/*
 * Connects to and queries the database for the manager's name.
 *
 * PARAM $placeholder (placeholder name to return in case db query fails)
 * RETURNS String
 * ERROR logs error to default logger and returns $placeholder 
 */
function getManagerName($placeholder) {
	
	// establish and confirm connection with database
    $connect = mysqli_connect("localhost", "cti110", "wtcc", "mydatabase");
    if(!$connect) {
        error_log("Cannot connect to database (".mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
		return $placeholder;
    }

	// query database for manager's name and verify results are present
	$result = mysqli_query($connect, "SELECT firstName, lastName FROM personnel WHERE jobTitle = 'Manager'");
    if (!$result) {
        error_log("Could not successfully run query" . mysqli_error($connect) );
		return $placeholder;
    }
	
	// fetch result array and close connection to database
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
	
	// return manager's name
    return $row['firstName'] . " " . $row['lastName'];
}

// retrieve form attributes from http request body and assign to variables for reusability
$name = $_POST['name'];
$phonenumber = $_POST['phonenumber'];
$adultTicket = $_POST['adultticket'];
$childTicket = $_POST['childticket'];
$date = $_POST['date'];

/*
 * calculates the subtotal, tax and total and assigns them to globals of the same name.
 *
 * PARAM $adult (number of adult tickets)
 * PARAM $child (number of child tickets)
 */
function calcCost($adult, $child) {
	// create globals to use assign and use later
    global $subTotal, $tax, $totalCost;
	
	// perform calculations with algorithms designed to product specifications
    $subTotal = (35 * $adult) + (30 * $child);
    $tax = $subTotal * 0.07;
    $totalCost = $subTotal + $tax + (($adult + $child <= 5) ? 1.0 : 0.5) * ($adult + $child);
}

/*
 * creates the main body of the ticket receipt using globals previously defined
 *
 * RETURNS String
 */
function printReciept() {
    return "<div class = \"mainBody\"><h1 class=\"mainheader\">Concert Ticket Order Summary</h1>" . 
    "<p>Name: " . $GLOBALS['name'] . "</p>" . 
    "<p>Phone number: " . $GLOBALS['phonenumber'] . "</p>" . 
    "<p>Adult tickets: " . $GLOBALS['adultTicket'] . "</p>" . 
    "<p>Child tickets: " . $GLOBALS['childTicket'] . "</p>" . 
    "<p>Date: " . $GLOBALS['date'] . "</p>" . 
    "<p>Subtotal: $" . number_format($GLOBALS['subTotal'],2) . "</p>" . 
    "<p>Tax: $" . number_format($GLOBALS['tax'],2) . "</p>" . 
    "<p>Total cost: $" . number_format($GLOBALS['totalCost'],2) . "</p>" . 
    "<p>Please contact the manager if you have question:</p>" . 
    "<p>" . getManagerName("Admin") . "</p>" . 
    "<p>Thanks " . $GLOBALS['name'] . " for using this program!</p>";
}
calcCost($adultTicket, $childTicket);
echo printReciept();
?>
<footer class="returnbutton">
    <p><a href="lab13_main.html" class="buttonlink">Return to Main Page</a></p>
</footer>
</div>
</body>
</html>