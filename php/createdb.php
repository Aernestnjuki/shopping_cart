<?php

class createDb
{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $tablename;
    public $con; //connection

    // class constructor
    public function __construct( 
        $dbname = "Shoppingdb",
        $tablename = "Producttb",
        $servername = "localhost",
        $username = "root",
        $password = ""
    ){
        //initializing the constructor with the class properties
        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;


        /// create connection

        $this->con = new mysqli($servername, $username, $password);

        // check the connection
        if(!$this->con){
            die("Connection failed:". $this->con->connect_error());
        }

        //query
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        //execute query
        if(mysqli_query($this->con,$sql)){

            $this->con = new mysqli($servername, $username, $password, $dbname);

            //sql to create new table
            $sql = "CREATE TABLE IF NOT EXISTS $tablename
            (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            product_name VARCHAR(25) NOT NULL,
            product_price FLOAT,
            product_image VARCHAR(100)
            );";

            if(!mysqli_query($this->con,$sql)){
                echo "Error creating table:". $this->con->error;
            }
        }else{
            return false;
        }
    }

    // get product from the database
    public function getdata(){
        $sql = "SELECT * FROM $this->tablename";

        $result = mysqli_query($this->con, $sql);

        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }
}