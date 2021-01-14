<?php
    // Sets the session variables to null so as to logout the user
    session_start();
    $_SESSION["login"] = null;
    $_SESSION["logout"] = true;
    $_SESSION["uid"] = null;
    header("Location: /index.php");
?>