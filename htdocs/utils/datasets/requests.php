<?php
    date_default_timezone_set('Asia/Kolkata');
    
    include realpath('../shared/sanitize.php');
    include realpath('../shared/connectDB.php');

    class ResponseStatus {
        public $error;
        public $success;
    }

    function approveRequest($rid, $type, $response) {
        $rid = sanitize($rid);
        $type = sanitize($type);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "There was an error connecting to the database";
            return;
        }
        if ($type == "dataset") {
            $sql = "SELECT DATASETS.DID, MESSAGE,  UID, TYPE, FILENAME FROM REQUESTS, DATASETS WHERE RID='$rid' AND DATASETS.DID=REQUESTS.DID";
        } else {
            $sql = "SELECT DATASETS.DID, MESSAGE,  UID, TYPE, MODEL_REQUESTS.FILENAME FROM MODEL_REQUESTS, DATASETS WHERE MRID='$rid' AND DATASETS.DID=MODEL_REQUESTS.DID";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0) {
            $response->error = "No such request found in the database, please check again";
            return;
        } 
        $row = mysqli_fetch_assoc($result);
        $filename = $row["FILENAME"];
        $r_uid = $row["UID"];
        $r_did = $row["DID"];
        $r_message = $row["MESSAGE"];
        if ($type == "dataset") {
            $targetFile = realpath('../../files/datasets/'.$filename);
            unlink($targetFile);
            $requestFile = realpath('../../files/requests/datasets/'.$r_uid."_".$filename);
            rename($requestFile, $targetFile);
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO CONTRIBUTIONS(UID, DID, MESSAGE) VALUES ('$r_uid', '$r_did', '$r_message');
            UPDATE DATASETS SET LAST_MODIFIED = '$date' WHERE DID='$r_did'; 
            UPDATE REQUESTS SET STATUS='1' WHERE RID='$rid';";
        } else {
            $targetFile = realpath('../../files/models/'.$filename);
            if (file_exists($targetFile)) {
                unlink($targetFile);
            } else {
                $targetFile = realpath('../../files/models/')."\\".$filename;
            }
            $requestFile = realpath('../../files/requests/models/'.$r_uid."_".$filename);
            rename($requestFile, $targetFile);
            $sql = "INSERT INTO MODELS(DID, UID, FILENAME, DESCRIPTION) VALUES('$r_did', '$r_uid', '$filename', '$r_message');";
            if (!mysqli_query($conn, $sql)) {
                $response->error = "Error in models database";
                return;
            }
            $sql = "SELECT MID FROM MODELS WHERE FILENAME = '$filename'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $mid = $row["MID"];
            $sql = "INSERT INTO CONTRIBUTIONS(UID, DID, MESSAGE, MID) VALUES('$r_uid', '$r_did', '$r_message', '$mid');
            UPDATE MODEL_REQUESTS SET STATUS='1' WHERE MRID = '$rid';";
        }
        if (mysqli_multi_query($conn, $sql)) {
            $response->success = "Request approved";
        } else {
            $response->error = "There was an error inserting values into the database";
        }
    }

    function declineRequest($rid, $type, $response) {
        $rid = sanitize($rid);
        $type = sanitize($type);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "There was an error connecting to the database";
            return;
        }   
        if ($type == "dataset") {
            $sql = "SELECT UID, FILENAME FROM REQUESTS, DATASETS WHERE RID = '$rid' AND REQUESTS.DID = DATASETS.DID";
        } else {
            $sql = "SELECT UID, FILENAME FROM MODEL_REQUESTS WHERE MRID = '$rid'";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0) {
            $response->error = "No such request found in the database, please check again";
            return;
        }
        $row = mysqli_fetch_assoc($result);
        if ($type == "dataset") {
            $targetFile = realpath('../../files/requests/datasets/'.$row["UID"]."_".$row["FILENAME"]);
            unlink($targetFile);
            $sql = "UPDATE REQUESTS SET STATUS='-1' WHERE RID = '$rid'";
        } else {
            $targetFile = realpath('../../files/requests/models/'.$row["UID"]."_".$row["FILENAME"]);
            unlink($targetFile);
            $sql = "UPDATE MODEL_REQUESTS SET STATUS='-1' WHERE MRID = '$rid'";
        }
        if (mysqli_query($conn, $sql)) {
            $response->message = "The request was declined successfully";
        } else {
            $response->error = "There was an error updating the database";
        }
    }

    function withdrawRequest($rid, $type, $response) {
        $rid = sanitize($rid);
        $type = sanitize($type);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "There was an error connecting to the database";
            return;
        }
        if ($type == "dataset") {
            $sql = "SELECT UID, FILENAME FROM REQUESTS, DATASETS WHERE REQUESTS.RID = '$rid' AND REQUESTS.DID = DATASETS.DID";   
        } else {
            $sql = "SELECT UID, FILENAME FROM MODEL_REQUESTS WHERE MRID = '$rid'";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0) {
            $response->error = "No such dataset was found";
            return;
        }
        $row = mysqli_fetch_assoc($result);
        $filename = $row["UID"]."_".$row["FILENAME"];
        if ($type == "dataset") {
            $targetFile = realpath('../../files/requests/datasets/'.$filename);
            $sql = "DELETE FROM REQUESTS WHERE RID = '$rid'";
        } else {
            $targetFile = realpath('../../files/requests/models/'.$filename);
            $sql = "DELETE FROM MODEL_REQUESTS WHERE MRID = '$rid'";
        }
        unlink($targetFile);
        if (mysqli_query($conn, $sql)) {
            $response->success = "The request was withdrawn";
        } else {
            $response->error = "Error in database try again later";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $json = file_get_contents("php://input");
        $obj = json_decode($json);
        $response = new ResponseStatus();
        if (!isset($obj->rid) || !isset($obj->type)) {
            $response->error = "The recieved data was insufficient";
            echo json_encode($response);
            exit;
        }
        if (isset($obj->approve)) {
            approveRequest($obj->rid, $obj->type, $response);
            echo json_encode($response);
            exit;
        } 
        if (isset($obj->decline)) {
            declineRequest($obj->rid, $obj->type, $response);
            echo json_encode($response);
            exit;
        }
        if (isset($obj->withdraw)) {
            withdrawRequest($obj->rid, $obj->type, $response);
            echo json_encode($response);
            exit;
        }
    }
?>