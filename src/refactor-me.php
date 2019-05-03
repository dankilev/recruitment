<?php

namespace refactored; //we want to start by declaring the scope of the namespace we are in to avoid overriding existing class declarations etc..

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');
// // Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');

include_once('Config.php'); //This could also be a config.ini file (but if so, we must ammend how we access the data accordingly)
include_once('DataMapper.php');
include_once('Customers.php');
include_once('Customer.php');
include_once('Bookings.php');
include_once('Booking.php');

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Simple App</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
<h1>Simple Database App</h1>
<pre>
<?php
// Initiate a new Customer object and assign First Name to "Jim" and Last Name to "Johnson"
// $customerDK = new Customer('Mr', 'Dan', 'Kilev', 'Sefton Park Road', 'test');
$customer = new Customer('Mr', 'Jim', 'Johnson');
// $customer->setTitle('Proff');
// $customer->setFirstName('Jim');
// $customer->setLastName('Johnson');
// $customer->setAddress('Sefton Park');
// $customer->setTwitterAlias('dankilev');

echo ($customer->getTitle()); // Print the First Name
echo ' ';
echo ($customer->getFirstName()); // Print the First Name
echo ' ';
echo ($customer->getLastName()); // Print the Last Name
echo ' ';
echo ($customer->getAddress()); // Print the Address
echo ' ';
echo ($customer->getTwitterAlias()); // Print the Twitter Alias
echo '<hr />';
// Delete all users with that match the current customer object mandatory parameters //Was not par of the refactoring but I did it anyway ;)
// echo 'Deleted '. $customer->deleteCustomer() . ' existing customer(s) matching the current user mandatory parameters<br />';
// Save the new customer(s) into the DB
$customer->saveCustomer(); //I have changed the function to also return the number of affected row (in our case it should be 1), not necessarly need to be displayed ;)
// $customerDK->saveCustomer(); //not part of refactoring, just a testing remnant ;)

// Get our customers ORDERed by Surname
Customer::getAllCustomersOrderedBySurname();
echo '<hr />';
// Get all customers from the database and print on the page
Customer::getAllCustomers();
// Customer::$db = null; //For some crazy reason we might want to close a connection (not really recommended)

echo '<hr />';
// Initiate a new Booking object
$bookings = new Booking();

$results = $bookings->getBookings($_GET['customerID']);
if ($results) {
    foreach ($results as $result):
        echo $result['booking_reference'] . ' - ' . $result['customer_name'] . ' (' . $result['booking_date'] . ')<br />';
    endforeach;
} else {
    echo 'No results for customerID='.$_GET['customerID'];
}
?>
</pre>
</body>
</html>