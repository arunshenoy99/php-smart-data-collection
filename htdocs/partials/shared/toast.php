<!-- Toasts are used to display responses from the server -->
<?php
    if (isset($new)) {
        if ($new == true) {
?>
<!-- If $new is set to true it means something has succeeded on the server and we use a green color toast using $message set on the server -->
<div class="toast" style="position: absolute; top: 0px; right: 0px; z-index: 9999;" data-delay="2000" style="width: 300px;">
    <div class="toast-header bg-success text-white" style="width: 100%;">
        <h4 class="mr-auto">Status</h4>
        <button class="close ml-auto" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
        <p class="text-success"><?php echo $message; ?></p>
    </div>
</div>

<?php
        } else {
?>
<!-- If $new is false it means something has failed on the server and hence we display a red color toast with $message set on the server  -->
<div class="toast" style="position: absolute; top: 0px; right: 0px; z-index: 9999;" data-delay="2000" style="width: 300px;">
    <div class="toast-header bg-danger text-white" style="width: 100%;">
        <h4 class="mr-auto">Status</h4>
        <button class="close ml-auto" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
        <p class="text-danger"><?php echo $message; ?></p>
    </div>
</div>

<?php
        } } 
?>

<!-- If $new is not set i.e null then server has nothing to send to the client, then the toast is not rendered and hence not displayed  -->