<?php

namespace refactored;

interface Customers
{
    /**
     * Utility function used to:
     * Format nicely the 'title', 'firstName' and 'surname' fed direcly into the present function
     * 
     * consumes:
     * title id declared as varchar(5) NOT NULL into the DB
     * firstName is declared as first_name varchar(30) into the DB
     * surname is declared as second_name varchar(30) into the DB
     * 
     * returns formatted string
     */
    static public function formatNames(string $title, string $firstName, string $surname);
    
    /**
     * Utility function used to:
     * get all the customers from the database and directly echo them out
     */
    static public function getAllCustomers();
    
    /**
     * Utility function used to:
     * get all the customers from the database (sorted by surname) and directly prints them out each on a new line
     */
    static public function getAllCustomersOrderedBySurname();
    
    /**
     * setter for string firstName
     */
    public function setTitle(string $title);
    /**
     * setter for string firstName
     */
    public function setFirstName(string $firstName);
    /**
     * setter for string lastName
     */
    public function setLastName(string $lastName);
    /**
     * setter for string address
     */
    public function setAddress(string $address);
    /**
     * setter for string twitterAlias
     */
    public function setTwitterAlias(string $twitterAlias);
    
    /**
     * getter/accessor for string title
     * returns string
     */
    public function getTitle();
    /**
     * getter/accessor for string firstName
     * returns string
     */
    public function getFirstName();
    /**
     * getter/accessor for string lastName
     * returns string
     */
    public function getLastName();
    /**
     * getter/accessor for string address
     * returns string
     */
    public function getAddress();
    /**
     * getter/accessor for string twitterAlias
     * returns string
     */
    public function getTwitterAlias();
    
    /**
     * Utility function used to:
     * save the current customer into the database
     */
    public function saveCustomer();
    
    /**
     * Utility function used to:
     * Deletes all customers from the database that match the mandatory parameters of the current customer
     * 
     * returns the number of users that were deleted from the database
     */
    public function deleteCustomer();

    /**
     * Utility function used to:
     * Return a single customers by getting it from its id, which is unique so the result from the database will always be 1 or 0
     * 
     * returns associative array that should contain one user maximum (based on the database enforcing unique "id"s)
     */
    static public function findById(int $id);
}

?>