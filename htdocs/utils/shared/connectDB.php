<?php 
    // Function used to connect to the database
    function connectDB() {
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "collectio";
    
        $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    
        if (!$conn) {
            return false;
        }
        return $conn;
    }
?>