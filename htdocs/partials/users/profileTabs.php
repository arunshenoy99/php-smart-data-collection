<!-- This file contains the 3 tabs used in the profile page 
    Used in: profile.php
-->

<!-- Show the activity of the user i.e uploads, contributions -->
<div class="tab-pane fade show active" id="activity-tab">
    <?php
        $activity = getUserActivity(sanitize($_GET["user"]));
        if (!$activity) {
    ?>
        <!-- If there is no activity show this -->
        <div class="row">
            <div class="col-12 text-center">
                <h3>No activity to show</h3>
            </div>
        </div>
        <!-- Else show activity as cards -->
        <?php } else { ?>
        <?php while ($row = mysqli_fetch_assoc($activity)) { ?>
            <div class="row">
                <div class="col-12" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="card card-datasets" style="border: none;">
                        <div class="card-body">
                            <div class="row my-0 py-0">
                                <div class="col-12 col-md-6 my-0">
                                    <!-- Name of contribution -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Description of contribution -->
                                    <p class="my-0 py-0"><?php echo $row["DESCRIPTION"] ?></p>
                                    <!-- Message of contribution -->
                                    <p class="my-0 py-0"><i><?php echo $row["MESSAGE"]; ?></i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } ?>
</div>

<!-- This  tab is used to show user uploads of datasets and not modals(modals are already contributed and must not be allowed to be deleted) -->

<div class="tab-pane fade" id="uploads-tab">
    <?php 
        $uploads = getUserUploads(sanitize($_GET["user"]));
        if (!$uploads) {
    ?>
    <!-- If there are no uploads show this -->
    <div class="row">
            <div class="col-12 text-center">
                <h3>No uploads to show</h3>
            </div>
    </div>
    <!-- Else show each upload as a card -->
        <?php } else { ?>
        <?php while($row = mysqli_fetch_assoc($uploads)) { ?>
            <div class="row">
                <div class="col-12" id="col-upload-<?php echo $row['DID']; ?>" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="card card-datasets" style="border: none;">
                        <div class="card-body">
                            <div class="row my-0 py-0">
                                <div class="col-12 col-md-6 my-0">
                                    <!-- Name of dataset -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Description of dataset -->
                                    <p class="my-0 py-0"><?php echo $row["DESCRIPTION"] ?></p>
                                    <!-- Date the dataset was created -->
                                    <p class="my-0 py-0"><span class="fa fa-table text-secondary mr-2"></span><i class="text-secondary"><?php echo $row["CREATED"]; ?></i></p>
                                </div>
                                <!-- If the user logged in is the owner of the dataset then show the edit and delete links -->
                                <?php if (sanitize($_GET["user"]) == $uid) { ?>
                                <div class="col-12 col-md-6">
                                    <!-- Link to toggle delete dataset modal -->
                                    <a href="#" class="text-danger" onclick="toggleDeleteDatasetModal(<?php echo $row['DID']; ?>, '<?php echo $row['NAME']; ?>');">Delete</a>
                                    <!-- Link to toggle edit dataset slide down -->
                                    <a href="#" class="ml-3 text-warning" onclick="toggleEditDataset(<?php echo $row['DID']; ?>);">Edit Dataset</a>
                                <?php } ?>
                                <!-- If the dataset is private the allow the user to download the dataset -->
                                <?php if ($row["PUBLIC"] == "0") { ?>
                                    <a href="/datasets.php?downloadName=datasets/<?php echo $row['FILENAME']; ?>" class="text-success mx-2">Download</a>
                                <?php } ?>
                                </div>
                            </div>
                            <!-- Edit dataset form row -->
                            <div class="row row-edit mx-3" id="row-edit-<?php echo $row['DID']; ?>">
                                <div class="col-12">
                                    <form action="/datasets.php" method="post">
                                        <!-- This input is used to route the request to the correct handler function -->
                                        <input type="hidden" name="editDatasetForm">
                                        <!-- Dataset ID of the dataset being edited -->
                                        <input type="hidden" name="did" value=<?php echo $row["DID"]; ?>>
                                        <!-- Name of the dataset -->
                                        <div class="form-group row">
                                            <label for="edit-name" class="col-form-label col-md-2">Name:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="edit-name" id="edit-name" placeholder="Name of Dataset" value=<?php echo $row["NAME"]; ?>>
                                            </div>
                                        </div>
                                        <!-- Description of the dataset -->
                                        <div class="form-group row">
                                            <label for="edit-description" class="col-form-label col-md-2">Description</label>
                                            <div class="col-md-10">
                                                <textarea name="edit-description" class="form-control" id="edit-description" rows="5" placeholder="Description"><?php echo $row["DESCRIPTION"]; ?></textarea>
                                            </div>
                                        </div>
                                        <!-- Checkboxes for public, contributable and custom request approval function -->
                                        <div class="form-check row">
                                            <div class="offset-md-2 col-md-10">
                                                <input type="checkbox" name="edit-public" id="name-public" class="form-check-input" <?php if ($row["PUBLIC"] == "1"){echo "checked";} ?>>
                                                <label for="#edit-public" class="form-check-label col-4">Public</label>
                                                <input type="checkbox" name="edit-contributable" id="edit-contributable" class="form-check-input" <?php if ($row["CONTRIBUTABLE"] == "1"){echo "checked";} ?>>
                                                <label for="edit-contributable" class="form-check-label col-4">Contributable</label><br>
                                                <input type="checkbox" name="custom-request-contributable" id="custom-request-contributable" class="form-check-input" <?php if ($row["CUSTOM_FUNCTION"] == "1"){echo "checked";} ?>>
                                                <label for="custom-request-contributable" class="form-check-label col-4">Custom Request Function?</label>
                                            </div>
                                        </div>
                                        <!-- Submit -->
                                        <div class="form-group row mt-4">
                                            <div class="offset-md-2 col-md-10">
                                                <button type="submit" class="btn btn-dark">Edit</button>
                                            </div>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                            <!-- Row that gives details on the custom request approval function -->
                            <div class="row">
                                <div class="col-12">
                                    <?php if ($row["CUSTOM_FUNCTION"] == -1) { ?> 
                                    <p>Tired of approving requests manually? Try writing a function to automate the process <a href="#" onclick="toggleRequestFunction();">here</a></p>
                                    <?php } else if ($row["CUSTOM_FUNCTION"] == 1) { ?>
                                    <p class="text-info">Custom request approval function is enabled on this dataset. Click <a href="#" onclick="toggleRequestFunction();">here</a> to change it</p>
                                    <?php } else { ?>
                                    <p class="text-info">Custom request approval function is disabled on this dataset.</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Row contaning the form for the custom request approval function -->
                            <div class="row">
                                <div class="col-12">
                                    <form id="request-function-form" style="display: none;" action="<?php echo sanitize($_SERVER["PHP_SELF"]); ?>?user=<?php echo $uid; ?>" method="post">
                                        <!-- This input is used to route the request to the correct handler function -->
                                        <input type="hidden" name="requestFunctionForm">
                                        <!-- Dataset for which the function is being added -->
                                        <input type="hidden" name="did" value="<?php echo $row["DID"]; ?>">
                                        <!-- Textarea to type the function, may contain an old function or blank cuntom function -->
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <?php $requestFunction = getRequestFunction($row["DID"]); ?>
                                                <textarea name="requestFunction" id="request-function" rows="10" class="form-control"><?php echo $requestFunction; ?></textarea>
                                            </div>
                                        </div>
                                        <!-- Submit -->
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-dark">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } ?>
</div>

<!-- Only if the logged in users profile is being viewed will this tab be shown -->
<?php 
    if ($uid == sanitize($_GET["user"])) {
?>

<!-- Tab containing details about the sent and recieved requests by and for the user -->
<div class="tab-pane fade" id="requests-tab">
    <!-- This row contains two nav pills placed vertically -->
    <div class="row">
        <div class="col-12 col-md-2">
            <div class="nav nav-pills flex-column">
                <!-- Link to show the recieved requests pill -->
                <a href="#recieved-requests-pill" data-toggle="pill" data-target="#recieved-requests-pill" class="nav-link active">Recieved</a>
                <!-- Link to show the sent requests pill -->
                <a href="#sent-requests-pill" data-toggle="pill" data-target="#sent-requests-pill" class="nav-link">Sent</a>
            </div>
        </div>
        <!-- Container for the tab content(pills) -->
        <div class="tab-content col-12 col-md-10">
            <!-- Recieved requests pill -->
            <div class="tab-pane fade show active" id="recieved-requests-pill">
            <!-- If there are no requests(recieved) this is shown -->
            <?php if ($totalRecievedRequests == 0) { ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>No requests to show</h3>
                    </div>
                </div>
            <?php } ?>
            <!-- Show recieved requests(datasets) as cards if the exist -->
            <?php if ($recievedDatasetRequests) { ?>
                <?php while($row = mysqli_fetch_assoc($recievedDatasetRequests)) { ?>
                <div class="row">
                    <div class="col-12" id="col-dataset-recieved-request-<?php echo $row['RID']; ?>">
                        <div class="card-body card-datasets">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <!-- Name of the dataset -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Message of the request -->
                                    <p class="my-0 py-0"><b>Message: </b><?php echo $row["MESSAGE"] ?></p>
                                    <!-- Type of the contribution being made -->
                                    <p class="my-0 py-0 "><b>Contribution Type: </b><?php echo $row["TYPE"]; ?></p>
                                    <span class="fa fa-user text-secondary my-0 py-0"></span>
                                    <!-- Link to profile of the user who has sent the request -->
                                    <a class="my-0 py-0" target="_blank" href="/profile.php?user=<?php echo $row["UID"]; ?>"><?php echo $row["USERNAME"]; ?></a><br>
                                    <!-- Approve the request button -->
                                    <button class="btn btn-success text-white my-0" onclick="approveRequest(<?php echo $row['RID']; ?>, 'dataset');">Approve</button>
                                    <!-- Decline the request button -->
                                    <button class=" my-o btn btn-danger text-white" onclick="declineRequest(<?php echo $row['RID']; ?>, 'dataset');">Decline</button>
                                </div>
                                <div class="col-12 col-md-6 my-0">
                                    <!-- Link to download and view the request file -->
                                    <a class="text-success" href="/datasets.php?downloadName=requests/datasets/<?php echo $row["UID"]."_".$row["FILENAME"]; ?>">Download</a>
                                    <!-- Link to view the request file raw in a new tab -->
                                    <span class="fa fa-eye text-secondary ml-3"></span><a href="/partials/datasets/viewDataset.php?name=<?php echo $row["NAME"]; ?>&filename=<?php echo $row["UID"]."_".$row["FILENAME"]; ?>&mode=request" target="_blank" class="text-secondary">View Raw</a>
                                    <!-- If the request file is a csv file then give then view the differences between the old and new file -->
                                    <?php if (pathinfo($row["FILENAME"],PATHINFO_EXTENSION) == "csv") { ?>
                                        <span class="fa fa-eye text-secondary ml-3"></span><a target="_blank" class="text-secondary" href="/utils/shared/diff.php?name=<?php echo $row["FILENAME"]; ?>&filename=<?php echo $row["UID"]."_".$row["FILENAME"]; ?>">View Diff</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Show recieved requests(models) as cards if they exist -->
            <?php } } if ($recievedModelRequests) { while ($row = mysqli_fetch_assoc($recievedModelRequests)) {  ?>
                <div class="row">
                    <div class="col-12" id="col-model-recieved-request-<?php echo $row['MRID']; ?>">
                        <div class="card-body card-datasets">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <!-- Name of the dataset -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Message of the request -->
                                    <p class="my-0 py-0"><b>Message: </b><?php echo $row["MESSAGE"] ?></p>
                                    <!-- Type of the contribution being made -->
                                    <p class="my-0 py-0 "><b>Contribution Type: </b><?php echo $row["TYPE"]; ?></p>
                                    <span class="fa fa-user text-secondary my-0 py-0"></span>
                                    <!-- Link to profile of the user who has sent the request -->
                                    <a class="my-0 py-0" target="_blank" href="/profile.php?user=<?php echo $row["UID"]; ?>"><?php echo $row["USERNAME"]; ?></a><br>
                                    <!-- Approve the request button -->
                                    <button class="btn btn-success text-white my-0" onclick="approveRequest(<?php echo $row['MRID']; ?>, 'model');">Approve</button>
                                    <!-- Decline the request button -->
                                    <button class=" my-o btn btn-danger text-white" onclick="declineRequest(<?php echo $row['MRID']; ?>,'model');">Decline</button>
                                </div>
                                <div class="col-12 col-md-6 my-0">
                                    <!-- Link to download and view the request file -->
                                    <a class="text-success" href="/datasets.php?downloadName=requests/models/<?php echo $row["UID"]."_".$row["FILENAME"]; ?>">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
            <!-- This pill shows all the sent requests which the user can withdraw -->
            <div class="tab-pane fade" id="sent-requests-pill">
            <!-- If there are no requests(sent) this is shown -->
            <?php if ($totalSentRequests == 0) { ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>No requests to show</h3>
                    </div>
                </div>
            <?php } ?>
            <!-- Show sent requests(datasets) as cards if they exist -->
            <?php if ($sentDatasetRequests) { while ($row = mysqli_fetch_assoc($sentDatasetRequests)) { ?>
                <div class="row">
                    <div class="col-12" id="col-dataset-sent-request-<?php echo $row['RID']; ?>">
                        <div class="card-body card-datasets">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <!-- Name of the dataset -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Message of the request -->
                                    <p class="my-0 py-0"><b>Message: </b><?php echo $row["MESSAGE"] ?></p>
                                    <!-- Type of the contribution being made -->
                                    <p class="my-0 py-0 "><b>Contribution Type: </b><?php echo $row["TYPE"]; ?></p>
                                    <!-- If the request has not been approved or rejected then allow the user to withdraw the request -->
                                    <?php if ($row["STATUS"] == "0") { ?>
                                    <button class="btn btn-danger" onclick="withdrawRequest(<?php echo $row['RID']; ?>, 'dataset')">Withdraw Request</button>
                                    <?php } else if ($row["STATUS"] == "1") { ?>
                                    <p class="text-success">The request was approved</p>
                                    <?php } else if ($row["STATUS"] == "-1") { ?>
                                    <p class="text-danger">The request was declined</p>
                                    <?php } ?>
                                </div>
                                <div class="col-12 col-md-6 my-0">
                                    <!-- If the request has not yet been approved allow the user to download and view the request file -->
                                    <?php if ($row["STATUS"] == "0") { ?>
                                    <a class="text-success" href="/datasets.php?downloadName=requests/datasets/<?php echo $row["UID"]."_".$row["FILENAME"]; ?>">Download</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Show sent requests(models) as cards if they exist -->
                <?php } } if ($sentModelRequests) { while ($row = mysqli_fetch_assoc($sentModelRequests)) { ?>
                <div class="row">
                    <div class="col-12" id="col-model-sent-request-<?php echo $row['MRID']; ?>">
                        <div class="card-body card-datasets">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <!-- Name of the dataset -->
                                    <h5 class="my-0 py-0"><?php echo $row["NAME"]; ?></h5>
                                    <!-- Message of the request -->
                                    <p class="my-0 py-0"><b>Message: </b><?php echo $row["MESSAGE"] ?></p>
                                    <!-- Type of the contribution being made -->
                                    <p class="my-0 py-0 "><b>Contribution Type: </b><?php echo $row["TYPE"]; ?></p>
                                    <!-- If the request has not been approved or rejected then allow the user to withdraw the request -->
                                    <?php if ($row["STATUS"] == "0") { ?>
                                    <button class="btn btn-danger" onclick="withdrawRequest(<?php echo $row['MRID']; ?>, 'model')">Withdraw Request</button>
                                    <?php } else if ($row["STATUS"] == "1") { ?>
                                    <p class="text-success">The request was approved</p>
                                    <?php } else if ($row["STATUS"] == "-1") { ?>
                                    <p class="text-danger">The request was declined</p>
                                    <?php } ?>
                                </div>
                                <div class="col-12 col-md-6 my-0">
                                <!-- If the request has not yet been approved allow the user to download and view the request file -->
                                <?php if ($row["STATUS"] == "0") { ?>
                                    <a class="text-success" href="/datasets.php?downloadName=requests/models/<?php echo $row["UID"]."_".$row["FILENAME"]; ?>">Download</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>