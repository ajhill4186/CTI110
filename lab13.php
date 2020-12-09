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

$server = "localhost";
$user = "cti110";
$pw = "wtcc";
$db = "mydatabase";
$connect=mysqli_connect($server, $user, $pw, $db);
    if( !$connect) {
        die("ERROR: Cannot connect to database $db on server $server 
            using user name $user (".mysqli_connect_errno().
            ", ".mysqli_connect_error().")");
    }
$userQuery = "SELECT firstName, lastName FROM personnel WHERE jobTitle = 'Manager'";
$result = mysqli_query($connect, $userQuery);
    if (!$result) {
        die("Could not successfully run query ($userQuery) from $db: " .	
            mysqli_error($connect) );
    }
    if (mysqli_num_rows($result) == 0) {
        print("No records found with query $userQuery");
    } else { 
        while ($row = mysqli_fetch_assoc($result))
			{
				$managerName = $row['firstName'] . " " . $row['lastName'];
			}
     }
            mysqli_close($connect);   // close the connection
        
$name = $_POST['name'];
$phonenumber = $_POST['phonenumber'];
$adultTicket = $_POST['adultticket'];
$childTicket = $_POST['childticket'];
$date = $_POST['date'];


$adultCost = 35 * $adultTicket;
$childCost = 30 * $childTicket;
$subTotal = $adultCost + $childCost;
$tax = $subTotal * 0.07;
if ($adultTicket + $childTicket <= 5) {
    $totalCost = $subTotal + $tax + 1.0 * ($adultTicket + $childTicket);
} else {
    $totalCost = $subTotal + $tax + 0.5 * ($adultTicket + $childTicket);
}
print("<div class = \"mainBody\"><h1 class=\"mainheader\">Concert Ticket Order Summary</h1>");
print("<p>Name: " . $name . "</p>");
print("<p>Phone number: " . $phonenumber . "</p>");
print("<p>Adult tickets: " . $adultTicket . "</p>");
print("<p>Child tickets: " . $childTicket . "</p>");
print("<p>Date: " . $date . "</p>");
print("<p>Subtotal: $" . number_format($subTotal,2) . "</p>");
print("<p>Tax: $" . number_format($tax,2) . "</p>");
print("<p>Total cost: $" . number_format($totalCost,2) . "</p>");
print("<p>Please contact the manager if you have question: " . "</p>");
print("<p>" . $managerName . "</p>");
print("<p>Thanks " . $name . " for using this program!" . "</p>");
?>
<footer class="returnbutton">
    <p><a href="lab13_main.html" class="buttonlink">Return to Main Page</a></p>
</footer>
</div>
</body>
</html>