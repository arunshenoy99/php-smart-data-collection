<?php 
    include "utils/users/user.php";
    include "utils/datasets/datasets.php";

    $active1 = "";
    $active2 = "";
    $active3 = "";
    $active4 = "active";
    $title = "Datasets";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["datasetForm"])) {
            uploadDataset();
        }
        else if (isset($_POST["contributeForm"])) {
            contributeDataset();
        }
        else if (isset($_POST["editDatasetForm"])) {
            editDataset();
        } 
        else {
            $json = file_get_contents("php://input");
            $obj = json_decode($json);
            if (isset($obj->delete)) {
                $response = new ResponseStatus();
                if (!isset($obj->did)) {
                    $response->error = "Please provide a dataset ID";
                    echo json_encode($response);
                    exit;
                } else {
                    deleteDataset($obj->did, $response);
                    echo json_encode($response);
                    exit;
                }
            }
            else if (isset($obj->metadata)) {
                $response = new ResponseDataset();
                if (!isset($obj->did)) {
                    $response->error = "Please provide a dataset ID";
                    echo json_encode($response);
                    exit;
                } else {
                    getDatasetDetails($obj->did, $response);
                    echo json_encode($response);
                    exit;
                }
            }
            else if (isset($obj->models)) {
                $response = new ResponseModel();
                if (!isset($obj->did)) {
                    $response->error = "Please provide a dataset ID";
                    echo json_encode($response);
                    exit;
                } else {
                    getModels($obj->did, $response);
                    echo json_encode($response);
                    exit;
                }
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["downloadName"])) {
            if (isset($_GET["did"])) {
                downloadDataset($_GET["did"], $_GET["downloadName"]);
            } else {
                downloadDatasetPrivate($_GET["downloadName"]);
            }
        }
    }
    
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "partials/shared/head.php"; ?>
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/datasets.css">
    </head>
    <body>
        <?php include "partials/shared/spinner.php" ?>
        <?php include "partials/users/loginModal.php"; ?>
        <?php include "partials/users/signupModal.php"; ?>
        <?php include "partials/datasets/detailModal.php"; ?>
        <?php include "partials/datasets/modelModal.php"; ?>
        <?php include "partials/shared/navbar.php"; ?>
        <?php include "partials/shared/toast.php" ?>
        <div class="container" id="datasets-container">
            <?php if (!isset($login)) { ?>
                <div class = "row align-items-center" style="height: 100vh;" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="col-12 text-center">
                        <h3>We are working very hard to get you the best datasets.</h3>
                        <h5>Please <a href="#loginModal" data-toggle="modal" data-target="#loginModal">login</a> to continue</h5>
                    </div>
                </div>
            <?php } else { ?>
                    <div class="row row-title">
                        <div class="col-12 text-center col-title" data-aos="fade-down">
                            <h1>Datasets</h1>
                        </div>
                    </div>
                    <nav>
                        <ul class="nav nav-tabs my-3">
                            <li class="nav-item w-25"><a href="#view-datasets-tab" data-toggle="tab" data-target="#view-datasets-tab" class="nav-link active">View</a></li>
                            <li class="nav-item w-25"><a href="#upload-datasets-tab" data-toggle="tab" data-target="#upload-datasets-tab" class="nav-link">Upload</a></li>
                        </ul>
                    </nav>
                    <div class="tab-content">
                        <?php include "partials/datasets/datasetTabs.php"; ?>
                    </div>
            <?php } ?>
        </div>
        <?php include "partials/shared/footer.php"; ?>
        <?php include "partials/shared/foot.php"; ?>  
        <script src="js/handlebars-v4.7.6.js"></script>
        <script src="js/datasets.js"></script>
    </body>
</html>