<?php
    // Used to send OTP to the users mail address
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    session_start();
    class Response {
        public $error;
        public $success;
    }
    require realpath("PHPMailer/src/PHPMailer.php");
    require realpath("PHPMailer/src/Exception.php");
    require realpath("PHPMailer/src/SMTP.php");
    function sendMail($email, $otp) {
        global $response;
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = 'devarunshenoy99@gmail.com';
        $passwordFile = realpath("../../env/dev.env");
        $fp = fopen($passwordFile, "r");
        $env = fread($fp, filesize($passwordFile));
        $password = explode("=", $env)[1];
        fclose($fp);
        $mail->Password = $password;
        $mail->From = "devarunshenoy99@gmail.com";
        $mail->FromName = "Collect.io";
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Collect.io One Time Password";
        $mail->Body = "<h3>Your Collect.io OTP for Sign up:</h3><h1>$otp</h1><p>Please do not share this one time password with anyone.";
        $mail->AltBody = "This is the plain text version of the email content";
        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $json = file_get_contents("php://input");
        $obj = json_decode($json);
        $response = new Response();
        if (!isset($obj->email)) {
            $response->error = "No email provided";
            echo json_encode($response);
            exit;
        }
        $otp = rand(100000, 999999);
        $sendStatus = sendMail($obj->email, $otp);
        if ($sendStatus) {
            $response->success = "OTP sent";
            $_SESSION["otp"] = $otp; 
        } else {
            $response->error = "Mail was not sent";
        }
        echo json_encode($response);
    }
?>