<?php
define('DB_PORT', 3306);

class Customer
{

    public $title;
    public $firstName;
    public $last_name;
    public $address;

    function saveCustomer(){
        $db = new mysqli('database', 'testuser', 'password', 'test', DB_PORT);
        $db->query('INSERT INTO customers (first_name, second_name) VALUES (\''.$this->firstName.'\', \''.$this->last_name.'\', \''.$this->address.'\')');
    }
    function get_our_customers_by_surname(){
        $db = new \mysqli('database', 'testuser', "password", 'test', DB_PORT);
        $res = $db->query('SELECT * FROM customers ORDER BY second_name');
    while($result=$res->fetch_assoc()){
        echo($this->formatNames($result['first_name'], $result['second_name']));
    }
    }

    public function formatNames($firstName, $surname) {
        $full_name = $firstName .= ' ';
        $full_name .= $surname;



        return $full_name;
    }


    function findById(string   $id)
    {
        $db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);
        $res = $db->query('SELECT * FROM customers WHERE id = \''.$id.'\'');
        mysqli_close ($db);
        return $res;
    }

            //Get all the customers from the database and output them
            function getAllCustomers(){
                $db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);




                $res = $db->query('SELECT * FROM customers');
                print '<table>';
                while ($result = $res->fetch_assoc()){
                    echo '<TR>';
                    echo '<TD>'.$result['first_name'].'</ td>';
                    echo '<td>'.$result['second_name'].'</ TD>';
                    echo '</tr>';
                }




                echo('</table>');
            }





}




class Booking {

    public function GetBookings($id = false)
    {
        $sql = "SELCT * FROM bookings";
        if ($id !== false ) {
            $sql .= " WHERE customerID=" . $id;
        }


        $db = new \mysqli('127.0.0.1', 'testuser', 'password', 'test', DB_PORT);
        $res = $db->query($sql);

        while ($result = $res->fetch_assoc()){
         $User = User::findById($result['customerID']);
            $return[$result['id']]['customer_name'] = $User->first_name . ' ' . $User->last_name;
            $return[$result['id']]['booking_reference'] = $result['booking_reference'];
            $return[$result['id']]['booking_date'] = date('D dS M Y', result['booking_date']);
        }

        return $return;
    }

}




?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Simple  App</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<h1>Simple Database App</h1>

<?php
$customer = new Customer();
$customer->firstName = "Jim";
$customer->last_name = "Johnson";
echo($customer->firstName);
echo($customer->last_name);
$customer->saveCustomer();
$customer->get_our_customers_by_surname();

$customer->getAllCustomers();
$bookings = new Booking();
    $results = @$bookings->GetBookings($_GET['customerId']);
    foreach ($results as $result):
        echo $result['booking_reference'] . ' - '. $result['customer_name'] . $result['booking_date'];
    endforeach;

?>

</body>
</html>

<?php ?>
