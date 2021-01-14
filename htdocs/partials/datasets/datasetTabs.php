<!-- This file contains the 2 tabs used in the datasets page 
    Used in: datasets.php
-->
<div class="tab-pane fade show active" id="view-datasets-tab">
<?php
    // Get the datasets
    $datasets = getDatasets();
    if (!$datasets) { ?>
        <!-- If there are no datasets display this -->
        <div class="row align-items-center" data-aos="zoom-in" data-aos-duration="1000">
            <div class="col-12 text-center">
                <h5>There are no datasets at the moment, be the first one to upload a dataset.</h5>
            </div>
        </div>
    <?php } else { ?>
            <!-- For each dataset display the dataset.php card -->
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($datasets)) { include "partials/datasets/dataset.php";} ?> 
            </div>
    <?php } ?>
</div>

<!-- Tab to upload dataset -->
<div class="tab-pane fade" id="upload-datasets-tab" style="min-height: 100vh;">
    <div class="col-12">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <!-- This input will be used to route the request to the correct handler function in php -->
            <input type="hidden" name="datasetForm">
            <!-- Name of the dataset -->
            <div class="form-group row">
                <label for="dataset-name" class="col-md-2 col-form-label">Name:</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" required="true" name="dataset-name" id="dataset-name" placeholder="Dataset Name">
                </div>
            </div>
            <!-- Description of the dataset -->
            <div class="form-group row">
                <label for="dataset-description" class="col-md-2 col-form-label">Description</label>
                <div class="col-md-10">
                    <textarea name="dataset-description" id="dataset-description" rows="10" required="true" class="form-control" placeholder="What is the dataset about?, Fields, Usage etc"></textarea>
                </div>
            </div>
            <!-- Format of the dataset csv or xlsx -->
            <div class="form-group row">
                <label for="dataset-format" class="col-md-2 col-form-label">Format:</label>
                <div class="col-md-5">
                    <select name="dataset-format" id="dataset-format" class="form-control custom-select">
                        <option value="csv">CSV</option>
                        <option value="xlsx">Excel(XLSX)</option>
                    </select>
                </div>
            </div>
            <!-- Choose whether the dataset is public or contributable -->
            <div class="form-check row">
                <div class="offset-md-2 col-md-10">
                    <input type="checkbox" name="dataset-public" id="dataset-public" class="form-check-input" checked>
                    <label for="dataset-public" class="col-4 form-check-label">Public</label>
                    <input type="checkbox" name="dataset-contributable" id="dataset-contributable" class="form-check-input">
                    <label for="dataset-contributable" class="col-4 form-check-label">Contributable</label>
                </div>
            </div>
            <!-- File upload for the dataset -->
            <div class="form-group row mt-4">
                <div class="offset-md-2">
                    <label for="dataset-file">Upload file</label>
                    <input type="file" class="form-control-file" name="dataset-file" id="dataset-file">
                </div>
            </div>
            <!-- Submit -->
            <div class="form-group row mt-4">
                <div class="offset-md-2 col-md-10">
                    <button class="btn btn-dark" type="submit">Upload</button>
                </div>
            </div>
        </form >
    </div>
</div>