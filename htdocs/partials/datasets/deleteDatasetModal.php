<!-- This modal displays a confirmation message whenever the user deletes a dataset
    Used in:
    profile.php
 -->
<div id="delete-dataset-container"></div>
<script id="delete-dataset-template" type="text/x-handlebars-template">
    <div class="modal fade" role="dialog" id="deleteDatasetModal">
        <div class="modal-dialog" role="content">
            <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12">
                        <h5>Are you sure you want to delete {{name}}</h5>
                        <p>The change is permanent, once you click yes the dataset will be deleted from the server.</p>
                        <a href="#" onclick="deleteDataset({{did}})" class="btn btn-danger">Yes</a>
                        <a href="#" data-dismiss="modal" data-target="#deleteDatasetModal" class="btn btn-success">No</a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</script>