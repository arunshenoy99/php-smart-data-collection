// Get the details of the dataset and render it in the handlebars template in partials/datasets/detailModal.php
async function getDatasetDetail(dataset) {
    const $detailModalContainer = document.getElementById('detail-modal-container');
    const $detailModalTemplate = document.getElementById('detail-template');
    var source = $detailModalTemplate.innerHTML;
    var template = Handlebars.compile(source);
    const url = `${window.location.protocol}//${window.location.hostname}/datasets.php`;
    const response = await fetch(url, {
        method: 'POST',
        body: JSON.stringify({ did: dataset.id, metadata: true})
    });
    const data = await response.json();
    if (data.error) {
        console.log(data.error);
        return null;
    }
    const datasetDetail = data.dataset;
    if (datasetDetail.CONTRIBUTABLE == "0") {
        datasetDetail.CONTRIBUTABLE = "NO";
        datasetDetail.C = null;    
    } else {
        datasetDetail.CONTRIBUTABLE = "YES";
        datasetDetail.C = 1;
    }
    datasetDetail.contributors = data.contributors;
    var html = template(datasetDetail);
    $detailModalContainer.innerHTML = html;
    $('#detail-modal').modal('show');
}

//Called when the user clicks on approve button for a request
async function approveRequest(rid, type) {
    const url = `${window.location.protocol}//${window.location.hostname}/utils/datasets/requests.php`;
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({rid: rid, type: type, approve: true})
    })
    const data = await response.json();
    if (data.error) {
        console.log(data.error);
    } else {
        if (type == 'model') {
            $(`#col-model-recieved-request-${rid}`).html("<h5 class='text-success'>The request was approved</h5>");
        } else {
            $(`#col-dataset-recieved-request-${rid}`).html("<h5 class='text-success'>The request was approved</h5>");
        }
    }
}

//Called when the user clicks on decline button for a request
async function declineRequest(rid, type) {
    const url = `${window.location.protocol}//${window.location.hostname}/utils/datasets/requests.php`;
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({rid:rid, type: type, decline: true})
    })
    const data = await response.json();
    if (data.error) {
        console.log(data.error);
    } else {
        if (type == 'model') {
            $(`#col-model-recieved-request-${rid}`).html("<h5 class='text-success'>The request was declined</h5>");
        } else {
            $(`#col-dataset-recieved-request-${rid}`).html("<h5 class='text-success'>The request was declined</h5>");
        }
    }
}

//Called when the user clicks on withdraw button for a sent request
async function withdrawRequest(rid, type) {
    const url = `${window.location.protocol}//${window.location.hostname}/utils/datasets/requests.php`;
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({rid:rid, type: type, withdraw: true})
    })
    const data = await response.json();
    if (data.error) {
        console.log(data.error);
    } else {
        $('#recieved-requests-pill').html("<h5 class='text-success'>Please refresh the page to see the requests</h5>");
        if (type == 'model') {
            $(`#col-model-sent-request-${rid}`).html("<h5 class='text-success'>The request was withdrawn</h5>");
        } else {
            $(`#col-dataset-sent-request-${rid}`).html("<h5 class='text-success'>The request was withdrawn</h5>");
        }
    }
}

// This is used to toggle the partials/datasets/deleteDatasetModal.php which contains the confirmation message for deleting the modal
function toggleDeleteDatasetModal(did, name) {
    const $deleteModalTemplate = document.getElementById('delete-dataset-template').innerHTML;
    const $deleteModalContainer = document.getElementById('delete-dataset-container');
    var template = Handlebars.compile($deleteModalTemplate);
    var html = template({ did: did, name: name })
    $deleteModalContainer.innerHTML = html;
    $('#deleteDatasetModal').modal('show');
}

// Toggle the edit dataset slide called when the user clicks on Edit Dataset
function toggleEditDataset(did) {
    if ($(`#row-edit-${did}`).is(':visible')) {
        $(`#row-edit-${did}`).slideUp();
    } else {
        $(`#row-edit-${did}`).slideDown();
    }
}

// Toggle the edit profile slide called when the user clicks on Edit Profile
function toggleEdit() {
   if ($('#edit-profile-form').is(':visible')) {
        $('#toggle-edit').show();
        $('#edit-profile-form').hide();
        $('#user-data').fadeIn();
   } else {
        $('#toggle-edit').hide();
        $('#user-data').hide();
        $('#edit-profile-form').fadeIn();
   }
}

// Toggle the custom request approval function slide called when user clicks on a link pointing to the request function
function toggleRequestFunction() {
    if ($('#request-function-form').is(':visible')) {
        $('#request-function-form').slideUp();
    } else {
        $('#request-function-form').slideDown();
    }
}

// Called when the user clicks on Yes on the confirmation modal
async function deleteDataset(did) {
    const url = `${window.location.protocol}//${window.location.hostname}/datasets.php`;
    const response = await fetch(url, {
        method: 'POST',
        header: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ did: did, delete: true })
    });
    const data = await response.json();
    if (data.error) {
        return console.log(error)
    }
    $('#deleteDatasetModal').modal('hide');
    $(`#col-upload-${did}`).html('<h5 class="text-success">The dataset was deleted sucessfully');
    $('#requests-tab').html("<h5 class='text-success'>Please refresh the page to see the requests</h5>");
}