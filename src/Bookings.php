<?php

namespace refactored;

interface Bookings
{
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
    public function getBookings(int $id = null);
}

?>