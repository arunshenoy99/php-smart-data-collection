<?php
    // user.php has all the user related functions
    include "utils/users/user.php";
    $active1 = "";
    $active2 = "";
    //$active3 specifies Contact Us link to be active used in navbar.php
    $active3 = "active";
    $active4 = "";
    //Title for the webpage used in head.php
    $title = "Contact Us";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <?php include "partials/shared/head.php"; ?>
        <link rel="stylesheet" href="css/contact.css">
    </head>
    <body>
        <?php include "partials/shared/spinner.php" ?>
        <?php include "partials/users/loginModal.php"; ?>
        <?php include "partials/users/signupModal.php"; ?>
        <?php include "partials/shared/navbar.php"; ?>
        <?php include "partials/shared/toast.php"; ?>
        <!-- Container for about page -->
        <div class="container" id="contact-container">
            <!-- Row giving a large title of the webpage at the top -->
            <div class="row row-title">
                <div class="col col-title text-center" data-aos="fade-down">
                    <h1>Contact Us</h1>
                </div>
            </div>
            <!-- Row giving the content of the contact us page -->
            <div class="row row-content">
            <!-- Col giving the links to email, linkedin and email of the creators using font awesome and bootstrap social -->
                <div class="col-12 col-md-6" style="margin-bottom: 30px;" data-aos="fade-right" data-aos-duration="1000">
                    <h5>A.R Sumukha</h5>
                    <a href="mailto:1by17cs002@bmsit.in" class="btn btn-social-icon"><span class="fa fa-envelope-square fa-lg"></span></a>
                    <a href="https://www.linkedin.com/in/arsumukha/" class="btn btn-social-icon btn-linkedin"><span class="fa fa-linkedin fa-lg"></span></a>
                    <a href="tel:+919449102497" class="btn btn-social-icon"><span class="fa fa-phone fa-lg"></span></a>
                    <h5 style="padding-top: 20px;">Arun R Shenoy</h5>
                    <a href="mailto:1by17cs032@bmsit.in" class="btn btn-social-icon"><span class="fa fa-envelope-square fa-lg"></span></a>
                    <a href="https://www.linkedin.com/in/arunrshenoy/" class="btn btn-social-icon btn-linkedin"><span class="fa fa-linkedin fa-lg"></span></a>
                    <a href="tel:+918105317567" class="btn btn-social-icon"><span class="fa fa-phone fa-lg"></span></a>
                    <h5 style="padding-top: 20px;">Charan Kalshetty</h5>
                    <a href="mailto:1by17cs041@bmsit.in" class="btn btn-social-icon"><span class="fa fa-envelope-square fa-lg"></span></a>
                    <a href="https://www.linkedin.com/in/charan-kalshetty/" class="btn btn-social-icon btn-linkedin"><span class="fa fa-linkedin fa-lg"></span></a>
                    <a href="tel:+919660759833" class="btn btn-social-icon"><span class="fa fa-phone fa-lg"></span></a>
                </div>
                <!-- Col giving the reach out online form -->
                <div class="col-12 col-md-6" data-aos="fade-left" data-aos-duration="1000">
                    <h5>Reach out online</h5>
                    <?php if(isset($login)) { ?>
                        <!-- If the user has logged in display the contact online form -->
                        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                            <input type="hidden" name="contactForm">
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Subject:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject of message" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="message" class="col-md-2 col-form-label">Message:</label>
                                <div class="col-md-10">
                                    <textarea name="message" id="message" class="form-control" rows="10" placeholder="Your message" required="true"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-md-2 col-md-10">
                                    <button class="btn btn-submit text-white" type="submit">Send</button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                    <!-- If the user has not logged in provide a link to login modal -->
                        <p>Please <a href="#loginModal" data-toggle="modal" data-target="#loginModal">login</a> to contact us using a form</p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php include "partials/shared/footer.php"; ?>
        <?php include "partials/shared/foot.php"; ?>
    </body>
</html>