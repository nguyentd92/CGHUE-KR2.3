<?php

class DbConnection {
    private static $dbhost = "localhost";
    private static $username = "root";
    private static $password = "P@ssword";
    private static $dbname = "watch_shop_db";

    private static $connection = null;

    static function getInstance() { // Return Type: Instance of connection
        // Check if connection is null then declare connection by PDO
        if(!isset(self::$connection)) {
            try {
                self::$connection = new PDO("mysql:host=".self::$dbhost.";dbname=".self::$dbname,
                    self::$username,
                    self::$password
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(Exception $exception) {
                echo "Connection failed: ".$exception->getMessage();
            }
        }

        return self::$connection;
    }
}