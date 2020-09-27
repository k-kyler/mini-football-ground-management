<?php
    function userNameValidate($usernameInput) {
        // Remove HTML tags
        $usernameInput = strip_tags($usernameInput);

        // Remove specified characters
        $usernameInput = addslashes($usernameInput);

        return $usernameInput;
    }

    function passwordValidate($passwordInput) {
        // Remove HTML tags
        $passwordInput = strip_tags($passwordInput);

        // Remove specified characters
        $passwordInput = addslashes($passwordInput);

        // Encoded password
        $passwordInput = md5($passwordInput);

        return $passwordInput;
    }
?>