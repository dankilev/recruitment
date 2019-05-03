<?php

namespace refactored;

class Customer extends DataMapper implements Customers
{
    private $title; //declared as `title` varchar(5) NOT NULL into the DB
    private $firstName; //declared as `first_name` varchar(30) NOT NULL into the DB
    private $lastName; //declared as `second_name` varchar(30) NOT NULL into the DB
    private $address = null; //declared as `address` varchar(255) NULL into the DB
    private $twitterAlias = null; //declared as `twitter_alias` varchar(255) NULL into the DB
    
    /**
     * Customer constructor
     * 
     * consumes:
     * string title is mandatory
     * string firstName is mandatory
     * string lastName is mandatory
     * string address is optional
     * string twitterAlias is optional
     * 
     * used to inititate the Customer object and initiate the "data base connection" using PDO from DataMapper
     */
    public function __construct(string $title, string $firstName, string $lastName, string $address = null, string $twitterAlias = null)
    {
        // Initiate the Mysql Connection
        self::initDbc();

        // Instantiate the mandatory parameters upon object creation
        $this->setTitle($title);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        if ($address != null) {
            $this->setAddress($address);
        }
        if ($twitterAlias != null) {
            $this->setTwitterAlias($twitterAlias);
        }
    }
    /**
     * Customer destructor
     * 
     * only used to shut down the PDO connection with the MySQL database via the DataMapper
     */
    public function __destruct()
    {
        // Closes the MySQL Connection once the Customer class is no longer in use (gabage collected etc..)
        self::$db = null; //explicitely closes the \PDO connection
    }

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
    static public function formatNames(string $title, string $firstName, string $surname) //added string typing as those are supposed to be strings
    {
        //there was no need to create new variables for such a simple operations as concatenation of strings!
        //since the name mentioned formatting, I have added an actual string formating
        //makes sure that the first name has only its first letter capitalised while the rest is in lower case
        //makes sure that the surname is CAPITALISED
        return ucfirst(strtolower($title)) . ' ' . ucfirst(strtolower($firstName)) . ' ' .strtoupper($surname);
    }
    
    /**
     * Utility function used to:
     * get all the customers from the database and directly echo them out
     */
    static public function getAllCustomers()
    {
        $stmt = self::$db->prepare("SELECT * FROM `customers`");
        $stmt->execute();
        echo '<table>';
        while ($rows = $stmt->fetch(\PDO::FETCH_ASSOC)) { //using fetch instead of fetchall for better memory efficiency!
            echo '<tr>';
            echo '<td>' . $rows['title'] . '</td>';
            echo '<td>' . $rows['first_name'] . '</td>';
            echo '<td>' . $rows['second_name'] . '</td>';
            echo '<td>' . $rows['address'] . '</td>';
            echo '<td>' . $rows['twitter_alias'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    
    /**
     * Utility function used to:
     * get all the customers from the database (sorted by surname) and directly prints them out each on a new line
     */
    static public function getAllCustomersOrderedBySurname()
    {
        $stmt = self::$db->prepare("SELECT * FROM `customers` ORDER BY `second_name`");
        $stmt->execute();
        while ($result = $stmt->fetch( \PDO::FETCH_ASSOC )) {
            print self::formatNames($result['title'], $result['first_name'], $result['second_name']).'<br />'; 
        }
    }
    
    /**
     * setter for string firstName
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    /**
     * setter for string firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    /**
     * setter for string lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    /**
     * setter for string address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }
    /**
     * setter for string twitterAlias
     */
    public function setTwitterAlias(string $twitterAlias)
    {
        $this->twitterAlias = $twitterAlias;
    }
    
    /**
     * getter/accessor for string title
     * returns string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * getter/accessor for string firstName
     * returns string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * getter/accessor for string lastName
     * returns string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * getter/accessor for string address
     * returns string
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * getter/accessor for string twitterAlias
     * returns string
     */
    public function getTwitterAlias()
    {
        return $this->twitterAlias;
    }
    
    /**
     * Utility function used to:
     * save the current customer into the database
     */
    public function saveCustomer()
    {
        // to use mysqli from whitin our refactored namespace we need to use the main namespace, hence the "\" character prior the mysqli
        // $this->db->query('INSERT INTO `customers` (`first_name`, `second_name`, `address`, `twitter_alias`) VALUES (\'' . $this->firstName . '\', \'' . $this->lastName . '\', \'' . $this->address . '\')');
        $stmt = self::$db->prepare("INSERT INTO `customers` (`title`, `first_name`, `second_name`, `address`, `twitter_alias`) VALUES (:title, :first_name, :second_name, :user_address, :twitter_alias)");
        $stmt->execute(
            array(
                ':title' => $this->getTitle(),
                ':first_name' => $this->getFirstName(),
                ':second_name' => $this->getLastName(),
                ':user_address' => $this->getAddress(),
                ':twitter_alias' => $this->getTwitterAlias()
            )
        );
    }
    
    /**
     * Utility function used to:
     * Deletes all customers from the database that match the mandatory parameters of the current customer
     * 
     * returns the number of users that were deleted from the database
     */
    public function deleteCustomer()
    {
        $stmt = self::$db->prepare("DELETE FROM `customers` WHERE `title` = :title AND `first_name` = :first_name AND `second_name` = :second_name");
        $stmt->execute(
            array(
                ':title' => $this->getTitle(),
                ':first_name' => $this->getFirstName(),
                ':second_name' => $this->getLastName()
            )
        );
        return $stmt->rowCount(); //For the fun of it we can return how many users were deleted :)
    }

    /**
     * Utility function used to:
     * Return a single customers by getting it from its id, which is unique so the result from the database will always be 1 or 0
     * 
     * returns associative array that should contain one user maximum (based on the database enforcing unique "id"s)
     */
    static public function findById(int $id) //changed to be using the interger typing for the "id" to match the database declaration!
    {
        $stmt = self::$db->prepare("SELECT * FROM `customers` WHERE `id` = :id");
        $stmt->execute(
            array(':id' => $id)
        );
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

?>