<?php 
    // user.php has all the user related functions
    include "utils/users/user.php";
    $active1 = "";
    //$active2 specifies About Us link to be active used in navbar.php
    $active2 = "active";
    $active3 = "";
    $active4 = ""; 
    //Title for the webpage used in head.php
    $title = "About Us"
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "partials/shared/head.php"; ?>
        <link rel="stylesheet" href="css/about.css">
    </head>
    <body>
        <?php include "partials/shared/spinner.php" ?>
        <?php include "partials/users/loginModal.php"; ?>
        <?php include "partials/users/signupModal.php"; ?>
        <?php include "partials/shared/navbar.php"; ?>
        <?php include "partials/shared/toast.php"; ?>
        <!-- Container for about page -->
        <div class="container" id="about-container">
            <!-- Row giving a large title of the webpage at the top -->
            <div class="row row-title">
                <div class="col-12 text-center col-title" data-aos="fade-down">
                    <h1>About Us</h1>
                </div>
            </div>
            <!-- Row giving the jist of the website -->
            <div class="row row-content">
                <div class="col-12 text-center">
                    <!-- collect.io logo -->
                    <img class="img-fluid" src="img/logo.png" alt="Collect.io" data-aos="zoom-in" data-aos-duration="2000">
                    <!-- Brief description of collect.io -->
                    <p style="text-align: justify; margin-top: 50px;">Smart data mining and collection as the name suggests is a smart way to manage datasets and machine learning models for these datasets on an online platform. The system provides some awesome features such as uploading/downloading datasets and uploading/downloading models for a particular dataset. The system also allows users to control who can view and contribute to their datasets. Users can download public datasets and contribute more data or trained machine learning models to them if it has been allowed by the original uploader of the dataset. Uploading new data to the dataset or uploading a new trained machine learning model for the data in it is called a contribution. Any contribution request will reach the original uploader of the dataset who can then approve or reject it. Similarly any contribution request made can be withdrawn by the requester given that it has not yet been accepted or rejected. The smart part is that the original uploader of the dataset can write code under a function called the Custom Request Approval Function which automates the process of accepting or rejecting requests hence rapidly speeding up the data/trained model collection in a smart way.</p>
                </div>
            </div>
            <!-- Row giving the heading for creators -->
            <div class="row row-title">
                <div class="col-12 text-center col-title" data-aos="fade-up" data-aos-duration="1000">
                    <h3 class="title-main">Our Creators</h3>
                </div>
            </div>
            <!-- 3 creators with images and name -->
            <div class="row row-content">
                <div class="col-12 col-md-4 text-center" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="img/sumukha.png" alt="Sumukha" class="img-thumbnail rounded-circle" width="150" height="150">
                    <p class="creator-name"><b>A.R Sumukha</b></p>
                </div>
                <div class="col-12 col-md-4 text-center" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="img/arun.jpg" alt="Arun" class="img-thumbnail rounded-circle" width="150" height="150">
                    <p class="creator-name"><b>Arun R Shenoy</b></p>
                </div>
                <div class="col-12 col-md-4 text-center" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="img/charan.png" alt="Charan" class="img-thumbnail rounded-circle" width="150" height="150">
                    <p class="creator-name"><b>Charan Kalshetty</b></p>
                </div>
            </div>
        </div>
        <?php include "partials/shared/footer.php"; ?>
        <?php include "partials/shared/foot.php"; ?>
    </body>
</html>