<?php 
    // This function is used to create a custom request approval function
    function createRequestFunction($conn) {
        global $uid, $new, $message;
        $requestFunction = $_POST["requestFunction"];
        $did = $_POST["did"];
        $badWords = ["unlink(", "fopen(", "connect("];
        foreach($badWords as $badWord) {
            if (strpos($requestFunction, $badWord) !== false) {
                $new = false;
                $message = "Attempt at malicious code, please contact us if this is a mistake.";
                return;
            }
        }
        $targetFile = realpath("files/functions/");
        $file = fopen($targetFile."/$uid"."_$did".".php", "w");
        if (fwrite($file, $requestFunction) > 0) {
            $sql = "UPDATE DATASETS SET CUSTOM_FUNCTION = 1 WHERE DID='$did'";
            if (mysqli_query($conn, $sql)) {
                $new = true;
                $message = "New custom request function created";
            } else {
                $new = false;
                $message = "There was an error with the database";
            }
        } else {
            $new = false;
            $message = "There was an error creating the function";
        }
        fclose($file);
    }

    function getRequestFunction($did) {
        global $uid;
        $targetFile = "files/functions/$uid"."_"."$did".".php";
        if (file_exists($targetFile)) {
            $file = fopen($targetFile, "r");
            $requestFunction = fread($file, filesize($targetFile));
            fclose($file);
        } else {
            $requestFunction = "<?php\nfunction customRequest(\$file) { \n /*\n\tReturn type can be one of the following values:\n\t0:\t Approve request manually\n\t1:\t Accept the request\n\t-1:\t Reject the request\n\t Write your code after this comment\n*/\n\t \n\n\n}\n?>";
        }
        return $requestFunction;
    }
    
?>