<?php 
    // user.php has all the user related functions
    include "utils/users/user.php"; 
    //$active1 specifies Home link to be active used in navbar.php
    $active1 = "active";
    $active2 = "";
    $active3 = "";
    $active4 = "";
    //Title for the webpage used in head.php
    $title = "Collect.io"
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include "partials/shared/head.php"; ?>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <?php include "partials/shared/spinner.php" ?>
        <?php include "partials/users/loginModal.php"; ?>
        <?php include "partials/users/signupModal.php"; ?>
        <?php include "partials/shared/navbar.php"; ?>
        <?php include "partials/shared/toast.php"; ?>
        <!-- Carousel container how to animate -->
        <div class="carousel slide carousel-fade d-none d-md-block" id="main-carousel" data-ride="carousel" data-pause="false">
        <!-- Carousel inner, what to animate -->
            <div class="carousel-inner d-none d-md-block" role="listbox">
            <!-- Items of carousel to be displayed -->
                <div class="carousel-item active">
                    <!-- A 100vh by 100 vw image occupying the entire screen -->
                    <img src="img/c1.jpg" alt="Collect.io" class="carousel-image img-fluid">
                    <!-- Caption for the image placed at the center on top of it -->
                    <div class="carousel-caption" data-aos="fade-in" data-aos-duration="3000">
                        <h2 class="carousel-header">Collect.io</h2>
                        <p>Smart Data Mining and Collection.</p>
                        <a href="/about.php" class="btn btn-warning">Know more</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/c2.jpg" alt="Datasets" class="carousel-image img-fluid">
                    <div class="carousel-caption" data-aos="fade-in" data-aos-duration="3000">
                        <h2 class="carousel-header">Datasets</h2>
                        <p>Create, download and contribute to datasets around the world.</p>
                        <a href="/datasets.php" class="btn btn-warning">Explore Datasets</a>
                    </div>
                </div>
                <div class="carousel-item">
                <img src="img/c3.jpg" alt="Transfer Learning" class="carousel-image img-fluid">
                    <div class="carousel-caption" data-aos="fade-in" data-aos-duration="3000">
                        <h2 class="carousel-header">Transfer Learning</h2>
                        <p>Train on datasets, analyze results and download models.</p>
                        <a href="/datasets.php" class="btn btn-warning">Explore Models</a>
                    </div>
                </div>
            </div>
            <!-- Carousel indicators to navigate among the carousel -->
            <ol class="carousel-indicators">
                <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#main-carousel" data-slide-to="1"></li>
                <li data-target="#main-carousel" data-slide-to="2"></li>
            </ol>
            </a>
        </div>
        <!-- Alternative for carousel on small screens -->
        <div class="container d-block d-md-none" id="carousel-alternative">
            <div class="row align-items-center" id="carousel-alternative-info">
                <div class="col-12 text-center">
                    <!-- Logo of collect.io(<md) -->
                    <img src="img/logo.png" alt="Collect.io" class="img-fluid" style="margin-bottom: 30px;" width="200" height="200" data-aos="flip-up" data-aos-duration="1000"> 
                    <h2 class="title-main" data-aos="fade-up" data-aos-duration="2000">Collect.io</h2>
                    <!-- Login and signup links below the heading(<md) -->
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <p>Smart Data Mining and Collection</p>
                        <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                        <a href="#" class="ml-2" data-toggle="modal" data-target="#signupModal">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of carousel alternative -->
        <?php include "partials/shared/footer.php"; ?>
        <?php include "partials/shared/foot.php"; ?>
    </body>
</html>