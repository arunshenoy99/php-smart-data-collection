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

// Get the models for the dataset and render them in the handlebars template in partials/datasets/modelModal.php
async function getModels(did) {
    const modelContainer = document.getElementById('model-container');
    const modelModalTemplate = document.getElementById('model-template').innerHTML;
    var template = Handlebars.compile(modelModalTemplate);
    const url = `${window.location.protocol}//${window.location.hostname}/datasets.php`;
    const response = await fetch(url, {
        method: 'POST',
        body: JSON.stringify({ did:did, models: true })
    })
    const data = await response.json();
    if (data.error) {
        return console.log(data.error);
    }
    var html = template({models: data.data, DID: did});
    modelContainer.innerHTML = html;
    $('#modelModal').modal('show');
}

// Toggle the contribute slide
function toggleContribute(did) {
    if ($(`#row-contribute-${did}`).is(':visible')) {
        $(`#row-contribute-${did}`).slideUp();
    } else {
        $(`#row-contribute-${did}`).slideDown();
        $('#detail-modal').modal('hide');
        $('#modelModal').modal('hide');
    }
}