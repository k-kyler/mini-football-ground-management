<?php
    // Call functions
    require_once(realpath(dirname(__FILE__) . '/..') . '/Functions/functions.php');

    // Create access to MySQL database
    session_start();
    define('SERVER', '127.0.0.1');
    define('USER', 'kkyler');
    define('PASS', '123456');
    define('DB', 'mini_football_ground_management');
    define('ROOT', dirname(__FILE__));
    define('HOST', 'http://localhost:81');
?>