<!-- This contains the modal which displays a feedback form when the user chooses to delete his account
    Used in:
        profile.php
 -->


<div class="modal fade" role="dialog" id="deleteUserModal">
    <div class="modal-dialog" role="content">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="d-inline">We're sorry to see you go <?php echo $login; ?>.</h5>
                        <!-- Close button to close the details modal -->
                        <a href="#" class="close" data-dismiss="modal" data-target="deleteUserModal">&times;</a>
                        <!-- Form for the feedback -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <!-- This input will be used to route the request to the correct handler function in php -->
                            <input type="hidden" name="deleteUser">
                            <!-- Feedback textarea -->
                            <div class="form-group row">
                                <label for="deleteMessage" class="col-12 col-form-label">Please take a moment to tell us why</label>
                                <div class="col-12">
                                    <textarea name="deleteMessage" id="deleteMessage" class="form-control"  rows="3" placeholder="Reason here"></textarea>
                                </div>
                            </div>
                            <!-- Confirm deletion -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <p>Are you sure you want to delete your account?</p>
                                    <!-- If yes submit the form -->
                                    <button class="btn btn-danger" type="submit">Yes</button>
                                    <!-- If no close the modal -->
                                    <a href="#" data-dismiss="modal" data-target="#deleteUserModal" class="btn btn-success">No</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>