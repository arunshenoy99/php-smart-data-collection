<?php 
    include "class.Diff.php";
    include "sanitize.php";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!isset($_GET["name"]) || !isset($_GET["filename"])) {
            header('Location: /index.php');
            exit;
        }
    }
    $old = sanitize($_GET["name"]);
    $new = sanitize($_GET["filename"]);
    $old = realpath('../../files/datasets/'.$old);
    $new = realpath('../../files/requests/datasets/'.$new);
    $output = Diff::compareFiles($old, $new);
    $deleted = '';
    $unmodified = '';
    $inserted = '';
    for ($i=0; $i < sizeof($output); $i++) {
        if ($output[$i][1] == Diff::UNMODIFIED) {
            $unmodified .= "<span>".$output[$i][0]."</span><br>";
        } else if ($output[$i][1] == DIFF::DELETED) {
            $deleted .= "<del>".$output[$i][0]."</del><br>";
        } else {
            $inserted .= "<ins>".$output[$i][0]."</ins><br>";
        }
    } 
    if ($deleted == '') {
        $deleted = "<h5>Nothing was deleted</h5>";
    }
    if ($inserted == '') {
        $inserted = "<h5>Nothing was inserted</h5>";
    }
    $title = "View Diff";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            del {
                color: red;
                text-decoration: none;
            }
            ins {
                color: green;
                text-decoration: none;
            }
        </style>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="icon" href="img/icon.png">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="nav nav-pills mb-3">
                        <a href="#deleted-pill" data-toggle="pill" data-target="#deleted-pill" class="nav-link active">Deleted</a>
                        <a href="#inserted-pill" data-toggle="pill" data-target="#inserted-pill" class="nav-link">Inserted</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="deleted-pill">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $deleted; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="inserted-pill">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $inserted; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../js/jquery.min.js"></script>  
        <script src="../../js/popper.min.js"></script>  
        <script src="../../js/bootstrap.min.js"></script>  
    </body>
</html>