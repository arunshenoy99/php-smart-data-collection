<!-- Footer styled with dark background in css -->
<footer class="footer">
    <div class="container" style="padding-top: 50px;">
        <!-- Row for the footer main content -->
        <div class="row">
        <!-- Col specifying information about collect.io -->
            <div class="col-12 col-md-3 pb-2">
                <h2 data-aos="fade-up" data-aos-duration="1000">Collect.io</h2>
                <p data-aos="zoom-in" data-aos-duration="500"><i>We are a team dedicated to providing services to download, train and contribute to public datasets around the world.</i></p>
                <div class="mb-2" data-aos="zoom-in" data-aos-duration="500">
                    <span class="fa fa-phone mr-2 mt-2"></span><i>+91 8105317567</i><br>
                    <span class="fa fa-envelope-square mr-2 mt-2"></span><i>devarunshenoy99@gmail.com</i><br>
                    <span class="fa fa-map-marker mr-2 mt-2"></span><i>Bengaluru, Karnataka, India</i><br>
                </div>
            </div>
            <!-- Col giving the navigation links -->
            <div class="col-6 col-md-3 pb-2">
                <h5 data-aos="fade-up" data-aos-duration="1000">Explore</h5>
                <ul class="list-unstyled" data-aos="zoom-in" data-aos-duration="500">
                    <li class="mt-2"><a href="/index.php" class="text-white">Home</a></li>
                    <li class="mt-2"><a href="/about.php" class="text-white">About Us</a></li>
                    <li class="mt-2"><a href="/contact.php" class="text-white">Contact Us</a></li>
                    <li class="mt-2"><a href="/datasets.php" class="text-white">Datasets</a></li>
                </ul>
            </div>
            <!-- Col giving user account related links -->
            <div class="col-6 col-md-3 pb-2">
                <h5 data-aos="fade-up" data-aos-duration="1000">Join Us</h5>
                <ul class="list-unstyled" data-aos="zoom-in" data-aos-duration="500">
                    <?php
                        if (!isset($login)) { ?>
                            <!-- If the user has not logged in display the login and signup buttons -->
                            <li class="mt-2"><a href="#loginModal" data-toggle="modal" data-target="#loginModal" class="text-white">Login</a></li>
                            <li class="mt-2"><a href="#signupModal" data-toggle="modal" data-target="#signupModal" class="text-white">Sign Up</a></li>
                    <?php } else { ?>
                            <!-- If the user has logged in display the profile and logout links -->
                            <li class="mt-2"><a href="/profile.php?user=<?php echo $uid; ?>" class="text-white"><?php echo $login;?></a></li>
                            <li class="mt-2"><a href="/utils/users/logout.php" class="text-white">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Col giving the social media links -->
            <div class="col-12 col-md-3 pb-2">
                <h5 data-aos="fade-up" data-aos-duration="1000">Follow us</h5>
                <div>
                    <a href="https://www.linkedin.com/in/arunrshenoy/" class="btn btn-social-icon btn-linkedin"><span class="fa fa-linkedin fa-lg text-white"></span></a>
                    <a href="https://www.instagram.com/arunshenoy99" class="btn btn-social-icon btn-instagram"><span class="fa fa-instagram fa-lg text-white"></span></a>
                </div>
            </div>
        </div>
        <!-- row specifying the copyright for the webpage -->
        <div class="row justify-content-center mt-3">
            <div class="col-auto">
                <p>&copy; 2020 Collect.io, All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>