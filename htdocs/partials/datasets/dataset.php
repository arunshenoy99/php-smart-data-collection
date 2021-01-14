<!-- 
    Used in: datasetTabs.php
 -->

<?php   
    // Get the count of models to help decide whether the view models button must be shown or not
    $models = getModelsCount($row["DID"]); 
?>
<!-- Each dataset is a card  -->
<div class="col-12 my-2 col-datasets">
    <div class="card card-datasets">
        <div class="card-body py-0">
            <div class="row">
                <div class="col-12" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="row my-0 py-0">
                        <div class="col-12 col-md-6">
                            <!-- Name of the dataset  -->
                            <h5><?php echo $row["NAME"]; ?></h5>
                            <!-- Description of the dataset -->
                            <p class="my-0 py-0"><?php echo $row["DESCRIPTION"]; ?></p>
                            <!-- Link to user who uploaded the dataset -->
                            <span class="fa fa-user text-secondary my-0 py-0"></span>
                            <a class="my-0 py-0" target="_blank" href="/profile.php?user=<?php echo $row["UID"]; ?>"><?php echo $row["USERNAME"]; ?></a>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- View dataset details link, calls a js function to place a fetch request -->
                            <span class="fa fa-info-circle text-secondary"></span><a href="#" id="<?php echo $row["DID"]; ?>" onclick="getDatasetDetail(this);" class="text-secondary">View details</a>
                            <!-- View raw dataset link -->
                            <span class="fa fa-eye text-secondary ml-3"></span><a href="partials/datasets/viewDataset.php?filename=<?php echo $row["FILENAME"]; ?>&name=<?php echo $row["NAME"]; ?>" class="text-secondary" target="_blank">View Raw</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-0 py-0" data-aos="zoom-in" data-aos-duration="1000">
                    <!-- Timestamp for the date the dataset was uploaded -->
                    <span class="fa fa-table text-secondary"></span><i class="mx-2"><?php echo $row["CREATED"]; ?></i>
                    <!-- Size of the dataset in bytes -->
                    <span class="fa fa-database text-secondary "></span><i class="mx-2"><?php echo $row["SIZE"];?>B</i>
                    <!-- Number of downloads of the dataset -->
                    <span class="fa fa-download text-secondary"></span><i class="mx-2"><?php echo $row["DOWNLOADS"]; ?></i>
                    <!-- If dataset is contributable provide toggle link to contribute row else don't-->
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?did=<?php echo $row["DID"]; ?>&downloadName=<?php echo $row["FILENAME"]; ?>" class="ml-3 text-success" role="button">Download Dataset</a>
                    <?php if ($row["CONTRIBUTABLE"] == 1) { ?>
                        <a href="#row-contribute-<?php echo $row['DID']; ?>" onclick="toggleContribute(<?php echo $row['DID']; ?>);" class="ml-3 text-warning">Contribute</a>
                    <?php } ?>
                    <!-- If models exist using its count retrieved above provide a link to trained models -->
                    <?php if ($models) { ?>
                        <a href="#" onclick="getModels(<?php echo $row['DID']; ?>);" class="text-info ml-3">Trained Models</a>
                    <?php } ?>
                </div>
            </div>
            <!-- Row containing contribution form -->
            <div class="row mt-2 row-contribute" id="row-contribute-<?php echo $row['DID']; ?>">
                <div class="col-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="contribute-dataset-id" value="<?php echo $row['DID']; ?>">
                        <input type="hidden" name="contributeForm">
                        <!-- Readonly filename of the file being contributed to-->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="contribute-dataset-name" value="<?php echo $row['FILENAME']; ?>" readonly required>
                            </div>
                        </div>
                        <!-- File upload for the contribution -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="file" name="contribute-dataset-file" class="form-control-file" required>
                            </div>
                        </div>
                        <!-- Select the type of contribution -->
                        <div class="form-group row">
                            <label for="contribute-dataset-type-<?php echo $row['DID'];?>" class="col-md-2 col-form-label">Type:</label>
                            <div class="col-md-5">
                                <select name="contribute-dataset-type" id="contribute-dataset-type-<?php echo $row['DID']; ?>" class="form-control custom-select">
                                    <option value="dataset">Dataset</option>
                                    <option value="model">Trained Model</option>
                                </select>
                            </div>
                        </div>
                        <!-- Enter a message which will be displayed with the contribution request -->
                        <div class="form-group row">
                            <div class="col-12">
                                <textarea class="form-control" name="contribute-dataset-message" rows="5" placeholder="Enter a simple message about the request" required></textarea>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-dark">Contribute request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
