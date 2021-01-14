<!-- This contains the modal which displays a login form when the user chooses to login to his account via various links
    Used in:
        profile.php
        dataset.php
        about.php
        contact.php
        index.php
 -->

<div class="modal fade" role="dialog" id="loginModal">
    <div class="modal-dialog" role="content">
        <div class="modal-content">
            <!-- Modal header in dark -->
            <div class="modal-header text-white">
                <h4>Login</h4>
                <!-- Close button to close the modal -->
                <button class="close text-white" data-dismiss="modal" data-target="#loginModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="loginForm" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <!-- This input will be used to route the request to the correct handler function in php -->
                    <input type="hidden" name="loginForm">
                    <!-- Username -->
                    <div class="form-group row">
                        <label for="username" class="col-form-label col-md-2">Username:</label>
                        <div class="col-12 col-md-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="true">
                            </div>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group row">
                        <label for="password" class="col-form-label col-md-2">Password:</label>
                        <div class="col-12 col-md-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="true">
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-md-10">
                            <button id="login-button" type="submit" class="btn text-white">Login</button>
                            <!-- Cancel and close the modal -->
                            <button type="close" data-dismiss="modal" data-target="#loginModal" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
                <!-- If the user does not have an account provide the sign up link to toggle the signupModal -->
                <div class="row">
                    <div class="col-12 offset-md-2">
                        <p>Not a member?<a href="#signupModal" onclick="toggleSignupModal();" class="ml-2">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>