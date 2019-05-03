<?php

namespace refactored;

class Booking extends Customer implements Bookings
{
    public function __construct()
    {
        // self::initDbc(); //make sure that a database connection is being initiated (not necessarly needed, depends on implementation)
    }

    /**
     * Utility function used to:
     * get all bookings or a single booking based on the URL get parameter customerID
     * 
     * the idea is to return all booking made by a particular customer with customerID
     * 
     * tip: you can use @ to silence PHP notice level warnings (depending on implementation)
     * 
     * returns customised array containing zero to multiple booking
     */
    public function getBookings(int $id = null) //changed name of the method to begin with lower case using camel casing convention
    {
        if ($id !== null) {
            $stmt = self::$db->prepare("SELECT * FROM `bookings` WHERE `customerID` = :customerID");
            $stmt->execute(
                array(':customerID' => $id)
            );
        } else {
            $stmt = self::$db->prepare("SELECT * FROM `bookings`");
            $stmt->execute();
        }
        $return = array();
        while ($rows = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $user                                     = self::findById($rows['customerID']);
            // $return[$rows['id']]['customer_name']     = $user["title"] . ' ' .$user["first_name"] . ' ' . $user["second_name"];
            $return[$rows['id']]['customer_name']     = self::formatNames($user["title"], $user["first_name"], $user["second_name"]);
            $return[$rows['id']]['booking_reference'] = $rows['booking_reference'];
            $return[$rows['id']]['booking_date']      = \date('D dS M Y', \strtotime($rows['booking_date']));
        }
        return $return;
    }
}

?>