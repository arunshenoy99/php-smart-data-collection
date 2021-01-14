$(document).ready(function() {
    // Initialize the animate on scroll library
    AOS.init();
    // Show any toasts if the exist
    $('.toast').toast('show');
    // When the page loads remove the spinner
    $('.spinner-container').fadeOut(500);
})

// Toggle the signupModal
function toggleSignupModal() {
    $('#loginModal').modal('hide');
    $('#signupModal').modal('show');
}


// Toggle the loginModal
function toggleLoginModal() {
    $('#signupModal').modal('hide');
    $('#loginModal').modal('show');
}