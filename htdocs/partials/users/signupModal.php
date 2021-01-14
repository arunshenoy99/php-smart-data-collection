<!-- This contains the modal which displays a sign up form when the user chooses to sign up via various links
    Used in:
        profile.php
        dataset.php
        about.php
        contact.php
        index.php
 -->

<div id="signupModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="content">
        <div class="modal-content">
            <!-- Modal header in dark -->
            <div class="modal-header text-white">
                <h4>Sign Up</h4>
                <!-- Close button to close the modal -->
                <button class="close text-white" data-dismiss="modal" data-target="signupModal">&times;</button>
            </div>
            <!-- This form is used to store the user details and request for an otp via javascript below-->
            <div class="modal-body" id="signupModalBody">
                <form id="signupForm">
                    <!-- Email -->
                    <div class="form-group row">
                        <label for="signup-email" class="col-md-2 col-form-label">Email:</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" name="email" id="signup-email" placeholder="Your Email" required="true">
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="form-group row">
                        <label for="signup-name" class="col-md-2 col-form-label">Name:</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" id="signup-name" placeholder="Your Name" required="true">
                        </div>
                    </div>
                    <!-- Username -->
                    <div class="form-group row">
                        <label for="signup-username" class="col-md-2 col-form-label">Username:</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" name="username" id="signup-username" placeholder="Username" required="true">
                            </div>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group row">
                        <label for="signup-password" class="col-form-label col-md-2">Password:</label>
                        <div class="col-12 col-md-10">
                            <input type="password" class="form-control" name="password" id="signup-password" placeholder="Password" required="true">
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group row">
                        <div class="offset-md-2 col-md-10">
                            <button id="login-button" type="submit" class="btn text-white">Sign Up</button>
                            <!-- Cancel and close the modal -->
                            <button type="close" data-dismiss="modal" data-target="#loginModal" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
                <!-- Contains the form to enter the otp, initially hidden -->
                <div id="otp-div" class="d-none">
                    <form action='<?php echo sanitize($_SERVER['PHP_SELF']); ?>' method='post' id="otp-form">
                        <!-- This input will be used to route the request to the correct handler function in php -->
                        <input type="hidden" name="signupForm">
                        <!-- Details entered in signupForm stored as hidden inputs whose values will be assigned by below javascript -->
                        <input type="hidden" name="email" id="otp-email">
                        <input type="hidden" name="name" id="otp-name">
                        <input type="hidden" name="password" id="otp-password">
                        <input type="hidden" name="username" id="otp-username">
                        <!-- OTP -->
                        <div class='form-group row'>
                            <div class='col-12 text-center'>
                                <p>OTP was sent to your email</p>
                                <input type='number' name='otp' class="form-control" placeholder='Enter the OTP'>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class='form-group row'>
                            <div class='col-12 '>
                                <button type='submit' class='btn btn-dark'>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- If the user already has an account provide the login link to toggle the loginModal -->
                <div class="row">
                    <div class="col-12 offset-md-2">
                        <p>Already a member?<a href="#signupModal" onclick="toggleLoginModal();" class="ml-2">Log In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Find the signupModal and its elements
    const $form = document.getElementById('signupForm');
    const $email = document.getElementById('signup-email');
    const $name = document.getElementById('signup-name');
    const $username = document.getElementById('signup-username');
    const $password = document.getElementById('signup-password');
    // Find the otp div and form
    const $otpDiv = document.getElementById('otp-div');
    const $otpForm = document.getElementById('otp-form');
    // This function is called when signupForm is submitted
    $form.addEventListener('submit', async function(e){
        // Prevent refreshing of page
        e.preventDefault();
        const $modalBody = document.getElementById('signupModalBody');
        // Show a spinner in the signupModal body
        $modalBody.innerHTML = "<div class='spinner-border' role='status'></div>"; 
        const email = $email.value;
        const url = `${window.location.protocol}//${window.location.hostname}/utils/shared/sendMail.php`;
        // Place a request to php to send the otp to the users mail
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify({email})
        });
        const data = await response.json();
        if (data.error) {
            return console.log(data.error);
        }
        // Store the otp div in the signupModal body
        $modalBody.innerHTML = $otpDiv.innerHTML;
        // Clear the data in the otp div to prevent id clashes with the new form placed in the modal body
        $otpDiv.innerHTML = "";
        // Store values of the hidden inputs in the otp form
        const $otpEmail = document.getElementById('otp-email');
        const $otpName = document.getElementById('otp-name');
        const $otpUsername = document.getElementById('otp-username');
        const $otpPassword = document.getElementById('otp-password');
        $otpEmail.value = $email.value;
        $otpName.value = $name.value;
        $otpUsername.value = $username.value;
        $otpPassword.value = $password.value;
    }) 
</script>