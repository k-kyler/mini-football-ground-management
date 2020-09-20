<?php
    function getDatabase() {
        $conn = new mysqli(SERVER, USER, PASS, DB);

        if ($conn -> connect_error) {
            die('Error! Can not connect to MySQL database' . $conn -> connect_error);
        }

        else {
            return $conn;
        }
    }
?>