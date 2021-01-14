<?php
    // Used to sanitize and check valid input
    function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if (strlen($data) == 0) {
            return false;
        }
        return $data;
    }
?>