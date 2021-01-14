<!-- Bootstrap dark navbar expands on >md and is fixed at the top of the screen -->
<nav class="navbar navbar-dark navbar-expand-md fixed-top">
    <!-- Container for < md screens which holds to navbar toggle button -->
    <div class="container">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#main-navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar brand giving the logo in the navbar -->
        <a href="/" class="navbar-brand "><img src="img/logo.png" alt="Collect.io" width="50" height="50"></a>
        <!-- Navbar content collapses on <md screens -->
        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a href="/index.php" class="nav-link <?php echo $active1; ?>">Home</a></li>
                <li class="nav-item"><a href="/about.php" class="nav-link <?php echo $active2; ?>">About Us</a></li>
                <li class="nav-item"><a href="/contact.php" class="nav-link <?php echo $active3; ?>">Contact Us</a></li>
                <li class="nav-item"><a href="/datasets.php" class="nav-link <?php echo $active4; ?>">Datasets</a></li>
                <!-- If user us not logged in then display links to login and signup modals(<md) -->
                <?php if (!isset($login)) { ?>
                    <li class="nav-item"><a href="#loginModal" data-toggle="modal" data-target="#loginModal" class="nav-link text-white d-block d-md-none">Login</a></li>
                    <li class="nav-item"><a href="#signupModal" data-toggle="modal" data-target="#signupModal" class="nav-link text-white d-block d-md-none">Sign Up</a></li>
                <?php } else { ?>
                <!-- If user us logged in display a dropdown to profile and logout(<md) -->
                    <li class="dropdown show d-block d-md-none">
                        <a class="dropdown-toggle nav-link text-white" href="#small-me-menu" data-toggle="dropdown" data-target="#small-me-menu"><?php echo $login; ?></a>
                        <div class="dropdown-menu" id="small-me-menu">
                            <a href="profile.php?user=<?php echo $uid; ?>" class="dropdown-item">Me</a>
                            <a href="utils/users/logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <!-- If user us not logged in then display links to login and signup modals(>md) shown on the right of navbar -->
            <?php if (!isset($login)) { ?>
                <a href="#loginModal" data-toggle="modal" data-target="#loginModal" class="nav-link text-white d-none d-md-block">Login</a>
                <a href="#signupModal" data-toggle="modal" data-target="#signupModal" class="nav-link text-white d-none d-md-block">Sign Up</a>
            <?php } else { ?>
            <!-- If user us logged in display a dropdown to profile and logout(>md) shown on the right of navbar -->
                <div class="dropdown show d-none d-md-block">
                    <a class="dropdown-toggle nav-link text-white" href="#me-menu" data-toggle="dropdown" data-target="#me-menu"><?php echo $login;?></a>
                    <div class="dropdown-menu" id="me-menu">
                        <a href="profile.php?user=<?php echo $uid; ?>" class="dropdown-item">Me</a>
                        <a href="utils/users/logout.php" class="dropdown-item">Logout</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
<!-- End of navbar -->