<?php 
    include "utils/shared/requestFunctions.php";
    include "utils/users/user.php";
    $active1 = "";
    $active2 = "";
    $active3 = "";
    $active4 = "";
    if (!isset($login) || !isset($_GET["user"])) {
        header("Location: index.php");
    }
    $user = getProfile(sanitize($_GET["user"]));
    if (!$user) {
        header("Location: index.php");
    }
    $title = $user["NAME"];
    $recievedDatasetRequests = getRecievedDatasetRequests(); 
    $recievedModelRequests = getRecievedModelRequests();
    $sentDatasetRequests = getSentDatasetRequests();
    $sentModelRequests = getSentModelRequests();
    $totalRecievedRequests = 0;
    $totalSentRequests = 0;
    if ($recievedDatasetRequests) {
        $totalRecievedRequests += mysqli_num_rows($recievedDatasetRequests);
    } 
    if ($recievedModelRequests) {
        $totalRecievedRequests += mysqli_num_rows($recievedModelRequests);
    }
    if ($sentDatasetRequests) {
        $totalSentRequests += mysqli_num_rows($sentDatasetRequests);
    }
    if ($sentModelRequests) {
        $totalSentRequests += mysqli_num_rows($sentModelRequests);
    }

    $totalRequests = $totalSentRequests + $totalRecievedRequests;
    
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <?php include "partials/shared/head.php"; ?>
            <link rel="stylesheet" href="css/profile.css"; ?>
            <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
        </head>
        <body>
            <?php include "partials/shared/spinner.php" ?>
            <?php include "partials/shared/navbar.php"; ?>
            <?php include "partials/shared/toast.php"; ?>
            <?php include "partials/datasets/detailModal.php"; ?>
            <?php include "partials/datasets/deleteDatasetModal.php"; ?>
            <?php include "partials/users/deleteUserModal.php"; ?>
            <div class="container-fluid" id="profile-container">
                <div class="row" style="overflow-x: none; height: 100vh;">
                    <div class="col-12 col-md-4" style="border-right: 1px solid grey;" data-aos="fade-right" data-aos-duration="1000">
                        <div id="user-data" class="text-center">
                            <h1><?php echo $user["NAME"]; ?></h1>
                            <p class="text-secondary">@<?php echo $user["USERNAME"]; ?></p>
                            <p><span class="fa fa-envelope fa-lg mr-2"></span><?php echo $user["EMAIL"]; ?></p>
                            <p>Joined on: <?php echo $user["JOINED"]; ?></p>
                            <a href="#" id="toggle-edit" onclick="toggleEdit();" class="text-warning">Edit Profile</a>
                        </div>
                        <div id="edit-profile-form" style="display: none;">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?user=$uid"; ?>" method="post">
                                <input type="hidden" name="editProfile">
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <input style="font-size: 2em;" type="text" id="edit-name" class="form-control" placeholder="Name" name="edit-name" value="<?php echo $user["NAME"]; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">@</span>
                                            </div>
                                            <input type="text" id="edit-username" placeholder="Username" class="form-control" name="edit-username" value="<?php echo $user["USERNAME"]; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fa fa-envelope-o"></span>
                                            </div>
                                            <input type="email" id="edit-email" class="form-control" placeholder="Email" name="edit-email" value="<?php echo $user["EMAIL"]; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fa fa-key"></span>
                                            </div>
                                            <input type="password" id="edit-password-old" class="form-control" placeholder="Current Password" name="edit-password-old" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-md-2 col-md-10">
                                        <a href="#edit-password" data-toggle="collapse" data-target="#edit-password" class="text-secondary">Edit Password</a>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center collapse" id="edit-password">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fa fa-key"></span>
                                            </div>
                                            <input type="password" id="edit-password-new" class="form-control" placeholder="New Password" name="edit-password-new">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-md-2 col-md-10">
                                        <button class="btn btn-warning text-white" type="submit">Edit</button>
                                        <button class="btn btn-secondary" type="button" onclick="toggleEdit();">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="offset-md-2 col-md-10">
                                <?php if ($uid == $_GET["user"]) { ?>
                                    <a href="#" data-toggle="modal" data-target="#deleteUserModal" class="text-danger mb-3">Delete my Account</a>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8" data-aos="fade-left" data-aos-duration="1000" style="height: 100vh;">
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item w-25"><a href="#activity-tab" class="nav-link active" data-toggle="tab" data-target="#activity-tab">Activity</a></li>
                            <li class="nav-item w-25"><a href="#uploads-tab" class="nav-link" data-toggle="tab" data-target="#uploads-tab">Uploads</a></li>
                            <?php if ($uid == $_GET["user"]) { ?>
                            <li class="nav-item w-25"><a href="#requests-tab" class="nav-link" data-toggle="tab" data-target="#requests-tab">Requests <span class="text-danger"><?php if ($totalRecievedRequests != 0) {echo $totalRecievedRequests;}?></span></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php include "partials/users/profileTabs.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "partials/shared/footer.php"; ?>
            <?php include "partials/shared/foot.php"; ?>
            <script src="js/handlebars-v4.7.6.js"></script>
            <script src="js/profile.js"></script>
        </body>
    </html>