<!-- This contains a handlebars template to dynamically render model details returned from php to javascript for each dataset
    Used in:
        datasets.php
 -->

 <!-- Container to render the modal -->
<div id="model-container"></div>
<!-- Modal template -->
<script id="model-template" type="text/x-handlebars-template">
    <div class="modal fade" id="modelModal" role="dialog">
        <div class="modal-dialog" role="content">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Models heading -->
                    <h1 class="d-inline">Models</h1>
                    <!-- Close button to close the models modal -->
                    <a href="#" data-dismiss="modal" data-target="#modelModal" class="close">&times;</a>
                    <!-- For each model out of many -->
                    {{#each models}}
                        <div class="row models-row my-3">
                            <div class="col-12">
                                <!-- Filename of the model -->
                                <p class="my-0 py-0 d-inline">{{FILENAME}}</p>
                                <!-- Link to profile of the contributor who uploaded the model -->
                                <div class="float-right">
                                    <span class="fa fa-user text-secondary my-0 py-0 ml-auto"></span><a href="/profile.php?user={{UID}}" target="_blank"> {{USERNAME}}</a>
                                </div>
                                <!-- Description of the model -->
                                <p class="text-secondary my-0 py-0">{{DESCRIPTION}}</p>
                                <!-- Button to download the model -->
                                <a href="/datasets.php?downloadName=models/{{FILENAME}}" class="text-success my-0 py-0">Download</a>
                            </div>
                        </div>
                    {{/each}}
                </div>
            </div>
        </div>
    </div>
</script>