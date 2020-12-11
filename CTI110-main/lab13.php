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
// all this for a managers name ;)
function getManagerName() {
    $connect = mysqli_connect("localhost", "cti110", "wtcc", "mydatabase");
    $userQuery = "SELECT firstName, lastName FROM personnel WHERE jobTitle = 'Manager'";
    $result = mysqli_query($connect, $userQuery);

    if(!$connect) {
        die("ERROR: Cannot connect to database (".mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
    }
    if (!$result) {
        die("Could not successfully run query" . mysqli_error($connect) );
    }
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
    return $row['firstName'] . " " . $row['lastName'];
}

$name = $_POST['name'];
$phonenumber = $_POST['phonenumber'];
$adultTicket = $_POST['adultticket'];
$childTicket = $_POST['childticket'];
$date = $_POST['date'];

// calculates the cost of the concert ;)
function calcCost($adult, $child) {
    global $subTotal, $tax, $totalCost;
    $subTotal = (35 * $adult) + (30 * $child);
    $tax = $subTotal * 0.07;
    $totalCost = $subTotal + $tax + (($adult + $child <= 5) ? 1.0 : 0.5) * ($adult + $child);
}

// prints the body of the reciept ;)
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
    "<p>" . getManagerName() . "</p>" . 
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