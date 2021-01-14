<?php

include realpath("utils/shared/connectDB.php");
include realpath('utils/shared/sanitize.php');

session_start();
// If the user has logged in store the session variables(login contains user's original name for the navbar, uid has the user id)
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $uid = $_SESSION['uid'];
    $new = null;
    $message = "";
} else {
    // When the page loads after logout this is run so as to display the logout message
    if (isset($_SESSION["logout"])) {
        $login = null;
        $uid = null;
        $new = true;
        $message = "Logout Successful";
        unset($_SESSION["logout"]);
    // When the user loads the page normally
    } else {
        $login = null;
        $uid = null;
        $new = null;
        $message = "";
        // If the server has generated an otp yet to be verified store it so the handler can use it for verification
        if (isset($_SESSION["otp"])) {
            $otp = $_SESSION["otp"];
            unset($_SESSION["otp"]);
        }
    }
    
}

// Function to login the user
function handleLogin($conn) {
    global $login, $new, $message, $uid;
    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    $sql = "SELECT UID,NAME,PASSWORD FROM USERS WHERE USERNAME='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row <= 0) {
        $new = false;
        $login = null;
        $message = "Username does not exist please sign up";
    } else {
        $hash = $row["PASSWORD"];
        // The password in the database is a bcrypt hashed 60 character string value
        if (password_verify($password, $hash)) {
            $login = $row["NAME"];
            $_SESSION['login'] = $login;
            $uid = $row["UID"];
            $_SESSION['uid'] = $uid;
            $new = true;
            $message = "Login Successful";
        } else {
            $login = null;
            $new = false;
            $message = "Login Failed please check your credentials";
        }
    }
}

// Function used to sign up an user
function handleSignup($conn) {
    global $login, $new, $message, $uid, $otp;
    $email = sanitize($_POST["email"]);
    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    $name = sanitize($_POST["name"]);
    $userOtp = sanitize($_POST["otp"]);
    // Here we verify if the generated otp is the same as the otp sent by the user
    if ($userOtp != $otp) {
        $login = null;
        $uid = null;
        $new = false;
        $message = "Your OTP did not match please try signing up again";
        return;
    }
    // Hash the password to a 60 character string uing bcrypt
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO USERS (EMAIL,NAME,USERNAME,PASSWORD) VALUES ('$email', '$name', '$username', '$password_hashed');";
    if (mysqli_query($conn, $sql)) {
        $login = $name;
        $_SESSION['login'] = $login;
        $select = "SELECT UID FROM USERS WHERE USERNAME = '$username'";
        $result = mysqli_query($conn, $select);
        $row = mysqli_fetch_assoc($result);
        $uid = $row["UID"];
        $_SESSION['uid'] = $uid;
        $new = true;
        $message = "Signed up and logged in $name";
    } else {
        $login = null;
        $uid = null;
        $new = false;
        $message = mysqli_error($conn);
    }
}

// Function called when the user submits a contact us form
function handleContact($conn) {
    global $login, $new, $message, $uid;
    if (!isset($login)) {
        $new = false;
        $message = "Please login first!";
    } else {
        $subject = sanitize($_POST["subject"]);
        $content = sanitize($_POST["message"]);
        $sql = "INSERT INTO MESSAGES(SUBJECT, MESSAGE, UID) VALUES('$subject', '$content', $uid)";
        if (mysqli_query($conn, $sql)) {
            $new = true;
            $message = "Your message was recieved, we will contact you shortly via email";
        } else {
            $new = false;
            if (mysqli_errno($conn) == 1062) {
                $message = "Please wait while we contact you regarding your last query";
            } else {
                $message = mysqli_error($conn);
            }
        }
    }
}

// Function that gives the user details
function getProfile($user) {
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT NAME, EMAIL, USERNAME, JOINED FROM USERS WHERE UID = '$user'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
}

// Function that gives the user activity
function getUserActivity($user) {
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT NAME, DESCRIPTION, CREATED, LAST_MODIFIED, MESSAGE, DATASETS.DID FROM DATASETS, CONTRIBUTIONS WHERE CONTRIBUTIONS.UID = '$user' AND CONTRIBUTIONS.DID = DATASETS.DID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function that gives the user uploads
function getUserUploads($user) {
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT FILENAME, PUBLIC, NAME, DESCRIPTION, DID, CREATED, CONTRIBUTABLE, CUSTOM_FUNCTION FROM DATASETS WHERE CREATOR='$user'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function that gives dataset contribution requests recieved for datasets uploaded by the user
function getRecievedDatasetRequests() {
    global $uid;
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT USERS.UID, STATUS, RID, DATASETS.NAME, DATASETS.FILENAME, MESSAGE, TYPE, USERNAME FROM USERS, DATASETS, REQUESTS WHERE DATASETS.CREATOR = '$uid' AND REQUESTS.DID = DATASETS.DID AND REQUESTS.UID = USERS.UID AND STATUS = '0'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function that gives model contribution requests recieved for datasets uploaded by the user
function getRecievedModelRequests() {
    global $uid;
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT USERS.UID, STATUS, MRID, DATASETS.NAME, MODEL_REQUESTS.FILENAME, MESSAGE, TYPE, USERNAME FROM USERS, DATASETS, MODEL_REQUESTS WHERE DATASETS.CREATOR = '$uid' AND MODEL_REQUESTS.DID = DATASETS.DID AND MODEL_REQUESTS.UID = USERS.UID AND STATUS = '0'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function that gives model contribution requests sent by the user
function getSentModelRequests() {
    global $uid;
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = "SELECT USERS.UID, MRID, STATUS, DATASETS.NAME, MODEL_REQUESTS.FILENAME, MESSAGE, TYPE, USERNAME FROM USERS, DATASETS, MODEL_REQUESTS WHERE MODEL_REQUESTS.UID = '$uid' AND MODEL_REQUESTS.DID = DATASETS.DID AND MODEL_REQUESTS.UID = USERS.UID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0 ) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function that gives dataset contribution requests sent by the user
function getSentDatasetRequests() {
    global $uid;
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        $sql = $sql = "SELECT USERS.UID, STATUS, RID, DATASETS.NAME, DATASETS.FILENAME, MESSAGE, TYPE, USERNAME FROM USERS, DATASETS, REQUESTS WHERE REQUESTS.UID = '$uid' AND REQUESTS.DID = DATASETS.DID AND REQUESTS.UID = USERS.UID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0 ) {
            return $result;
        } else {
            return false;
        }
    }
}

// Function called when the user edits his profile
function editProfile($conn) {
    global $uid, $new, $message, $login;
    $name = sanitize($_POST["edit-name"]);
    $username = sanitize($_POST["edit-username"]);
    $email = sanitize($_POST["edit-email"]);
    $oldPassword = sanitize($_POST["edit-password-old"]);
    $newPassword = sanitize($_POST["edit-password-new"]);
    $sql = "SELECT PASSWORD FROM USERS WHERE UID = '$uid'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) <= 0) {
        $new = false;
        $message = "Failed to update profile";
        return;
    }
    $row = mysqli_fetch_assoc($result);
    $password = $row["PASSWORD"];
    if (!password_verify($oldPassword, $password)) {
        $new = false;
        $message = "Edit failed please check your credentials";
        return;
    }
    if ($newPassword) {
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE USERS SET NAME = '$name', USERNAME = '$username', EMAIL = '$email', PASSWORD = '$password' WHERE UID = '$uid'";
    } else {
        $sql = "UPDATE USERS SET NAME = '$name', USERNAME = '$username', EMAIL = '$email' WHERE UID = '$uid'";
    }

    if (mysqli_query($conn, $sql)) {
        $login = $name;
        $_SESSION['login'] = $login;
        $new = true;
        $message = "Profile updated sucessfully";
    } else {
        $new = false;
        $message = "Error updating profile";
    }
}

// Function called when the user clicks delete profile on edit profile
function deleteUser($conn) {
    global $uid, $new, $message, $login;
    if (isset($_POST["deleteMessage"])) {
        $deleteMessage = sanitize($_POST["deleteMessage"]);
        $sql = "SELECT * FROM USERS WHERE UID = '$uid'";
        $result = mysqli_query($conn, $sql);
        if ($result <= 0) {
            $new = false;
            $message = "There was an error deleting your account";
            exit;
        }
        $row = mysqli_fetch_assoc($result);
        $email = $row["EMAIL"];
        $sql = "INSERT INTO FEEDBACK(USERNAME, EMAIL, MESSAGE) VALUES('$login', '$email', '$deleteMessage')";
        if (!mysqli_query($conn, $sql)) {
            $new = false;
            $message = "There was an error deleting your account";
            exit;
        }
    }
    $sql = "SELECT FILENAME FROM DATASETS WHERE DATASETS.CREATOR='$uid'";
    $targetDir = realpath('files/datasets/');
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            unlink($targetDir."\\".$row["FILENAME"]);
        }
    }
    $targetDir = realpath('files/requests/datasets/');
    foreach(glob($targetDir."\\"."$uid"."*") as $file) {
        unlink($file);
    }
    $sql = "DELETE FROM USERS WHERE UID = '$uid';";
    if (mysqli_query($conn, $sql)) {
        $_SESSION["login"] = null;
        $_SESSION["uid"] = null;
        $new = true;
        $message = "Your account has been deleted sucessfully";
        header("Location: /index.php");
    } else {
        $new = false;
        $message = "There was an error deleting your account";
    }
}

// Router than routes the requests to the correct functions above
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();
    if (!$conn) {
        $new = false;
        $message = "Connection to database failed";
    } else {
        if (isset($_POST["loginForm"])) {
            handleLogin($conn);
        }
        if (isset($_POST["signupForm"])) {
            handleSignup($conn);
        }
        if (isset($_POST["contactForm"])) {
            handleContact($conn);
        }
        if (isset($_POST["deleteUser"])) {
            deleteUser($conn);
        }
        if (isset($_POST["editProfile"])) {
            editProfile($conn);
        }
        if (isset($_POST["requestFunctionForm"])) {
            createRequestFunction($conn);
        }
        mysqli_close($conn);
    }
}

?>