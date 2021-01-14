<?php
    // Used to insert local time into the database timestamp
    date_default_timezone_set('Asia/Kolkata');

    // This is used when the response to JS has no data
    class ResponseStatus {
        public $success;
        public $error;
    }

    //This is used when the response to JS has dataset details 
    class ResponseDataset {
        public $error;
        public $dataset;
        public $contributors;
    }

    // This is used when the response to JS has model details
    class ResponseModel {
        public $error;
        public $data;
    }

    // Used to get the list of datasets
    function getDatasets() {
        $conn = connectDB();
        if (!$conn) {
            return false;
        }
        $sql = "SELECT DID, USERNAME, UID, DATASETS.NAME AS NAME, DESCRIPTION, FORMAT, SIZE, CREATED, LAST_MODIFIED, PUBLIC, FILENAME, CONTRIBUTABLE, DOWNLOADS FROM DATASETS, USERS WHERE PUBLIC = '1' AND DATASETS.CREATOR = USERS.UID ORDER BY DOWNLOADS DESC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Used to get the list of the models for a dataset
    function getModels($did, $response) {
        $did = sanitize($did);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "Connection to databse failed";
            return;
        }
        $sql = "SELECT USERS.UID, MODELS.DESCRIPTION, USERNAME, MODELS.FILENAME FROM USERS, MODELS WHERE DID = '$did' AND MODELS.UID = USERS.UID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0) {
            $response->error = "No models found";
            return;
        }
        $data = [];
        while($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }
        $response->data = $data;
    }

    // Used to get the count of models, used to display the Trained Models button
    function getModelsCount($did) {
        $conn = connectDB();
        if (!$conn) {
            return false;
        }
        $sql = "SELECT * FROM MODELS WHERE DID = '$did'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Used to get all the metadata about the dataset
    function getDatasetDetails($did, $response) {
        $did = sanitize($did);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "Error connecting to database";
            return;
        }
        $sql1 = "SELECT * FROM DATASETS WHERE DID = $did";
        $sql2 = "SELECT DISTINCT USERS.USERNAME, USERS.UID FROM USERS, CONTRIBUTIONS WHERE CONTRIBUTIONS.DID = '$did' AND USERS.UID = CONTRIBUTIONS.UID";
        $result1 = mysqli_query($conn, $sql1);
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result1) <= 0 || mysqli_num_rows($result2) <=0) {
            $response->error = "No such dataset found";
        } else {
            $row = mysqli_fetch_assoc($result1);
            $response->dataset = $row;
            $tempArray = [];
            while($row = mysqli_fetch_assoc($result2)) {
                array_push($tempArray, $row);
            }
            $response->contributors = $tempArray;
        }
    }

    // Used to upload the dataset
    function uploadDataset() {
        global $uid, $new, $message;
        $name = sanitize($_POST["dataset-name"]);
        $description = sanitize($_POST["dataset-description"]);
        $format = sanitize($_POST["dataset-format"]);
        $public = 0;
        $contributable = 0;
        if (isset($_POST["dataset-public"])) {
            $public = 1;
        }
        if (isset($_POST["dataset-contributable"])) {
            $contributable = 1;
        }
        $targetDir = realpath("files/datasets/");
        $filename = basename($_FILES["dataset-file"]["name"]);
        $targetFile = $targetDir."\\".$filename;
        $size = $_FILES["dataset-file"]["size"];
        $upload = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (file_exists($targetFile)) {
            $upload = 0;
            $new = false;
            $message = "The file already exists please select another filename";
        }

        if ($fileType != $format) {
            $upload = 0;
            $new = false;
            $message = "The file does not match the selected format";
        }

        if ($upload == 1) {
            if (move_uploaded_file($_FILES["dataset-file"]["tmp_name"], $targetFile)) {
                $sql = "INSERT INTO DATASETS(NAME, DESCRIPTION, CREATOR, FORMAT, SIZE, PUBLIC, CONTRIBUTABLE, FILENAME) VALUES('$name', '$description', '$uid', '$format', '$size', '$public', '$contributable', '$filename');";
                $conn = connectDB();
                if (!$conn) {
                    $new = false;
                    $message = "Connection to database failed";
                    return;
                }
                if (mysqli_query($conn, $sql)) {
                    $new = true;
                    $message = "The dataset was uploaded to the server";
                } else {
                    $new = false;
                    $message = "There was an error in the database";
                }
            }
        }
    }

    // Used to get the upload from a dataset contribution
    function contributeDataset() {
        global $uid, $new, $message;
        $did = sanitize($_POST["contribute-dataset-id"]);
        $name = sanitize($_POST["contribute-dataset-name"]);
        $message = sanitize($_POST["contribute-dataset-message"]);
        $type = sanitize($_POST["contribute-dataset-type"]);
        $size = $_FILES["contribute-dataset-file"]["size"];
        $filename = basename($_FILES["contribute-dataset-file"]["name"]);
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $requiredType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $upload = 1;

        $conn = connectDB();
        if (!$conn) {
            $new = false;
            $message = "Connection to database failed";
            return;
        }

        if ($type == "dataset") {
            $targetDir = realpath('files/requests/datasets');
            $targetFile = $targetDir."\\"."$uid"."_".$name;
        } else {
            $targetDir = realpath('files/requests/models');
            $targetFile = $targetDir."\\"."$uid"."_".$filename;
        }

        if (file_exists($targetFile)) {
            $upload = 0;
            $new = false;
            $message = "Please wait while your last request is approved";
        }

        if ($type == "dataset") {
            if ($fileType != $requiredType) {
                $upload = 0;
                $new = false;
                $message = "Please upload a $requiredType file";
            }
        } else  {
                if ($fileType != "h5")
                {
                    $upload = 0;
                    $new = false;
                    $message = "Please upload a h5 file";
                }
        }

        if ($fileType == "csv") {
            $sql = "SELECT CUSTOM_FUNCTION FROM DATASETS WHERE DID = '$did'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) <= 0) {
                $new = false;
                $message = "There was an error in the database";
                return;
            }
            $row = mysqli_fetch_assoc($result);
            if ($row["CUSTOM_FUNCTION"] == 1) {
                include realpath("files/functions/$uid"."_".$did.".php");
                $file = $_FILES["contribute-dataset-file"]["tmp_name"];
                $fp = fopen($file, "r");
                $status = customRequest($fp);
                fclose($fp);
                if ($status == 1) {
                    $targetFile = realpath("files/datasets/$name");
                } else if ($status == -1) {
                    $upload = 0;
                    $new = false;
                    $message = "Your dataset was rejected by the automatic function";
                }
            }
        }

        if ($upload == 1) {
            if (move_uploaded_file($_FILES["contribute-dataset-file"]["tmp_name"], $targetFile)) {

                if ($type == "dataset") {
                    $sql = "INSERT INTO REQUESTS(DID, UID, MESSAGE, TYPE, STATUS) VALUES('$did', '$uid', '$message', '$type', '$status');";
                } else {
                    $sql = "INSERT INTO MODEL_REQUESTS(DID, UID, FILENAME, MESSAGE, TYPE) VALUES('$did', '$uid', '$filename', '$message', '$type')";
                }
                
                if (mysqli_query($conn, $sql)) {
                    $new = true;
                    $message = "The request was sent sucessfully";
                    return;
                } else {
                    $new = false;
                    $message = "There was an error in the database";
                    return;
                }
            }
        }
    }

    // Used to download private datasets from the profile uploads, requested datasets and requestsed models
    function downloadDatasetPrivate($name) {
        $targetDir = realpath('files/'.$name);
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=\"" . basename($targetDir) . "\";");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($targetDir));
        ob_clean();
        flush();
        readfile($targetDir);
    }

    // Used to download public datasets
    function downloadDataset($did, $name) {
        global $new, $message;
        $conn = connectDB();
        if (!$conn) {
            $new = false;
            $message = "Connection to database failed";
            return;
        }
        $sql = "UPDATE DATASETS SET DOWNLOADS = DOWNLOADS + 1 WHERE DID='$did'";
        if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) > 0) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/force-download');
            header("Content-Disposition: attachment; filename=\"" . basename($name) . "\";");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize("files/datasets/".$name));
            ob_clean();
            flush();
            readfile("files/datasets/".$name);
        } else {
            $new = false;
            $message = "Error downloading the file";
        }
    }

    // Used to edit the dataset
    function editDataset() {
        global $new, $message, $uid;
        $did = sanitize($_POST["did"]);
        $name = sanitize($_POST["edit-name"]);
        $description = sanitize($_POST["edit-description"]);
        $public = 0;
        $contributable = 0;
        $customRequest = 0;
        if (isset($_POST["edit-public"])) {
            $public = 1;
        }
        if (isset($_POST["edit-contributable"])) {
            $contributable = 1;
        }
        if(isset($_POST["custom-request-contributable"])) {
            $customRequest = 1;
        }
        $conn = connectDB();
        if (!$conn) {
            $new = false;
            $message = "Connection to database failed";
            return;
        }
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE DATASETS SET NAME='$name', DESCRIPTION='$description', PUBLIC='$public', CONTRIBUTABLE='$contributable', CUSTOM_FUNCTION='$customRequest', LAST_MODIFIED='$date' WHERE DID='$did'";
        if (mysqli_query($conn, $sql)) {
            $new = true;
            $message = "The dataset was edited sucessfully";
        } else {
            $new = false;
            $message = "There was an error in the database";
        }
        return header("Location: /profile.php?user=$uid");
    }

    // Used to delete the dataset and any files related to it
    function deleteDataset($did, $response) {
        global $uid;
        $did = sanitize($did);
        $conn = connectDB();
        if (!$conn) {
            $response->error = "There was an error connecting to the database";
            return;
        }
        $sql = "SELECT FILENAME, CUSTOM_FUNCTION FROM DATASETS WHERE DID = '$did'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) <= 0) {
            $response->error = "No such dataset was found";
            return;
        } 
        $row = mysqli_fetch_assoc($result);
        $filename = $row["FILENAME"];
        $targetFile = realpath('files/datasets/'.$filename);
        unlink($targetFile);
        $targetDir = realpath("files/requests/datasets/");
        foreach (glob($targetDir."\\*_".$filename) as $file) {
            unlink($file);
        }
        if ($row["CUSTOM_FUNCTION"] != -1) {
            unlink("files/functions/$uid"."_"."$did".".php");
        }
        $sql = "SELECT FILENAME FROM MODELS WHERE DID = '$did'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $targetFile = realpath('files/models/'.$row["FILENAME"]);
                unlink($targetFile);
            }
        }
        $sql = "SELECT UID, FILENAME FROM MODEL_REQUESTS WHERE DID = '$did'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $targetFile = realpath('files/requests/models/'.$row["UID"]."_".$row["FILENAME"]);
                unlink($targetFile);
            }
        }
        $sql = "DELETE FROM DATASETS WHERE DID = '$did'";
        if (mysqli_query($conn, $sql)) {
            $response->success = "The dataset was deleted sucessfully";
        } else {
            $response->error = "There was an error deleting the dataset from the database";
        }
    }
    
?>