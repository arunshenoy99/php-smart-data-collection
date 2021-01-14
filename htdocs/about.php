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
                    <p style="text-align: justify; margin-top: 50px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Laoreet sit amet cursus sit amet dictum sit amet. Mauris nunc congue nisi vitae suscipit tellus mauris. A arcu cursus vitae congue mauris. Viverra suspendisse potenti nullam ac. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Viverra tellus in hac habitasse platea dictumst vestibulum rhoncus. Tristique risus nec feugiat in fermentum. Eu volutpat odio facilisis mauris sit amet massa vitae tortor. Ac ut consequat semper viverra nam libero justo laoreet sit. Laoreet suspendisse interdum consectetur libero id. Vivamus at augue eget arcu dictum. Nisi porta lorem mollis aliquam ut porttitor. Consequat mauris nunc congue nisi vitae suscipit tellus. Leo duis ut diam quam. At lectus urna duis convallis convallis tellus. Orci eu lobortis elementum nibh tellus. Et magnis dis parturient montes nascetur ridiculus mus mauris.</p>
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