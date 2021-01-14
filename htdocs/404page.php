<?php 
    // Title of the webpage used in head.php
    $title = "Not Found !" 
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "partials/shared/head.php"; ?>
    </head>
    <body>
    <!-- Container for 404 page -->
        <div class="container" style="height: 100vh;">
            <!-- row of height 100vh -->
            <div class="row" style="height:100vh;">
                <!-- place column at the center of the row which spans the height of the viewport(100vh) -->
                <div class="col-12 text-center align-self-center" data-aos="zoom-in">
                    <h1>404</h1>
                    <h5>The page you were looking for was not found!</h5>
                    <h5><a href="/index.php">Return Home</a></h5>
                </div>
            </div>
        </div>
        <?php include "partials/shared/foot.php"; ?>
    </body>
</html>