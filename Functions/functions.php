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

    function getImages($db) {
        $sqlQuery = "select * from images";

        return $db -> query($sqlQuery);
    }

    function getUserByName($db, $username) {
        $sqlQuery = "select * from users where user_name = ?";

        $stm = $db ->prepare($sqlQuery);
        $stm -> bind_param('s', $username);
        $status = $stm -> execute();

        if ($status) {
            $data = $stm -> get_result();

            return $data;
        }

        else {
            $stm -> close();

            return null;
        }
    }
?>