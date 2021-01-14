<!-- This contains a handlebars template to dynamically render dataset details returned from php to javascript
    Used in:
        datasets.php
        profile.php
 -->

 <!-- Container to render the modal -->
<div id="detail-modal-container"></div>
<!-- Modal template -->
<script id="detail-template" type="text/x-handlebars-template">
    <div id="detail-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="content">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Name and description of the dataset -->
                    <div class="row">
                        <div class="col-10">
                            <h2>{{NAME}}</h2>
                            <p>{{DESCRIPTION}}</p>
                        </div>
                        <!-- Close button to close the details modal -->
                        <div class="col-2">
                            <button class="close" data-dismiss="modal" data-target="#detail-modal">&times;</button>
                        </div>
                    </div>
                    <!-- Metadata of the dataset -->
                    <div class="row">
                        <div class="col-12 col-md-6" style="border-right: 1px solid grey;">
                            <h5 class="text-secondary"><b>Metadata</b></h5>
                            <dl class="row text-secondary">
                                <dt class="col-6">Format:</dt>
                                <dd class="col-6">{{FORMAT}}</dd>
                                <dt class="col-6">Created:</dt>
                                <dd class="col-6">{{CREATED}}</dd>
                                <dt class="col-6">Last Modified:</dt>
                                <dd class="col-6">{{LAST_MODIFIED}}</dd>
                                <dt class="col-6">Contributable:</dt>
                                <dd class="col-6">{{CONTRIBUTABLE}}</dd>
                            </dl>
                        </div>
                        <div class="col-12 col-md-6">
                            <h5 class="text-secondary mb-0"><b>Files</b></h5>
                            <dl class="row text-secondary">
                                <dt class="col-6">Filename:</dt>
                                <dd class="col-6">{{FILENAME}}</dd>
                                <dt class="col-6">Size:</dt>
                                <dd class="col-6">{{SIZE}}B</dd>
                            </dl>
                            <!-- For each of the contributors display links to their profile -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-secondary mb-0"><b>Contributors</b></h5>
                                </div>
                                {{#each contributors}}
                                    <div class="col-12">
                                        <a class="mb-0 pb-0" target="_blank" href="/profile.php?user={{UID}}">{{USERNAME}}</a>
                                    </div>
                                {{else}}
                                    <div class="col-12">
                                        <p class="text-secondary">No contributors</p>
                                    </div>
                                {{/each}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Download button -->
                            <a href="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>?did={{DID}}&downloadName={{FILENAME}}" class="btn btn-dark">Download</a>
                            <!-- If contributable a toggle button for the contribute row in dataset.php -->
                            {{#if C}}
                                <a href="#row-contribute-{{DID}}" onclick="toggleContribute({{DID}});" class="ml-3 btn btn-warning text-white">Contribute</a>
                            {{/if}}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</script>