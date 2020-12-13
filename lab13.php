<!DOCTYPE html>
<html lang="en">
<head>
<!--Name: Alexander Hill, Aysatu Diallo, Autumn Fitzgerald, Aniketh Babu
	Filename: lab13.php
	Blackboard User Name: ajhill, aldiallo2, 
	Class Section: CTI.110.5871
	Purpose: Calculate Event Costs 
-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>L13 Concert Event</title>
	<link rel="stylesheet" type="text/css" href="./lab13.css">
</head>
<body>
<div class = "mainBody"><h1 class="mainheader">Concert Ticket Order Summary</h1>
    
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
	
// Retrieving Input and Declaring Variables - Aysatu Diallo
$name = $_POST['name'];
$phoneNumber = $_POST['phonenumber'];
$adultTicket = $_POST['adultticket'];
$childTicket = $_POST['childticket'];
$date = $_POST['date'];

// Calculating SubTotal and Tax - Aysatu Diallo
$group = $adultTicket + $childTicket;
$subTotal = ($adultTicket * 35.00) + ($childTicket * 30.00);
$tax = $subTotal * 0.07;
	
// IF/ELSE for Fee - Aysatu Diallo
if ($group <= 5) {
	$fee = $group * 1.00;
} else {
	$fee = $group * 0.50;
}
	
// Calculates Total Cost - Aysatu Diallo
$total = $subTotal + $tax + $fee;
	
echo "<p>Your name: {$GLOBALS['name']}</p>";
echo "<p>Your phone number: {$GLOBALS['phoneNumber']}</p>";
echo "<p>Number of adult tickets: {$GLOBALS['adultTicket']}</p>";
echo "<p>Number of child tickets: {$GLOBALS['childTicket']}</p>";
echo "<p>Date selected: {$GLOBALS['date']}</p>";
echo "<p>Subtotal: $" . number_format($GLOBALS['subTotal'],2) . "</p>";
echo "<p>Tax: $" . number_format($GLOBALS['tax'],2) . "</p>";
echo "<p>Total cost: $" . number_format($GLOBALS['total'],2) . "</p>";
echo "<p>Please contact the manager if you have questions: </p>";
echo "<p>" . getManagerName("Admin") . "</p>";
echo "<p>Thanks {$GLOBALS['name']} for using this program!</p>";

?>
<footer class="returnbutton">
    <p><a href="lab13_main.html" class="buttonlink">Return to Main Page</a></p>
</footer>
</div>
</body>
</html>