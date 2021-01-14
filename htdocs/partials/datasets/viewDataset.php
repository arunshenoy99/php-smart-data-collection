<?php 
    // Use simpleXLSX to read xlsx files
    include realpath('../../utils/shared/SimpleXLSX.php');
    session_start();
    // Check if user is logged in, else redirect him to datasets
    if (!isset($_SESSION["login"]) || !isset($_GET["name"]) || !isset($_GET["filename"])) {
        header("Location: /datasets.php");
    }
    // Name of dataset
    $title = $_GET["name"];
    // Filename of dataset
    $filename = $_GET["filename"];
    // Check if viewing stored dataset or requested contribution dataset
    $mode = false;
    if (isset($_GET["mode"]) && $_GET["mode"] == "request") {
        $mode = true;
    }
    // Get extension of the dataset, if csv used csv handler else xlsx handler
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    // CSV handler
    function readCSVDataset($name) {
        global $mode;
        // Create a table for the csv dataset
        echo '<table class="table table-responsive-md table-bordered">';
        if ($mode) {
            $file = realpath('../../files/requests/datasets/'.$name);
        } else {
            $file = realpath('../../files/datasets/'.$name);
        }
        $fp = fopen($file, "r");
        $attributes = fgetcsv($fp);
        // Display the column names
        echo "<tr>";
        $attributes_no = count($attributes);
        foreach ($attributes as $attr) {
            echo "<th>$attr</th>";
        } 
        echo "</tr>";
        $count = 0;
        // Display 30 rows of the csv dataset
        while (! feof($fp)) {
            if ($count > 30) {
                // Show the download to view more link when count crosses 30
                echo "<tr><td colspan='$attributes_no' class='text-center'><a href='/datasets.php' class='text-info'>Download to view more</a></td></tr>";
                break;
            }
            $row = fgetcsv($fp);
            if (!$row) {
                continue;
            }
            echo "<tr>";
            foreach ($row as $col) {
                echo "<td>$col</td>";
            }
            echo "</tr>";
            $count++;
        }
        echo "</table>";
        fclose($fp);
    }

    // XLSX handler
    function readXLSXDataset($name) {
        global $mode;
        if ($mode) {
            $file = realpath('../../files/requests/datasets/'.$name);
        } else {
            $file = realpath('../../files/datasets/'.$name);
        }
        // Parse the xlsx file
        if ($xlsx = SimpleXLSX::parse($file)) {
            echo "<table class='table table-responsive-md table-bordered'>";
            $i = 0;
            // Display 30 rows of the xlsx dataset
            foreach($xlsx->rows() as $row) {
                if ($i >= 30) {
                    // Show the download to view more link when count crosses 30
                    echo "<tr><td colspan='".count($row)."'class='text-center'><a href='/datasets.php' class='text-info'>Download to view more</a></td></tr>";
                    break;
                }
                echo "<tr>";
                if ($i == 0) {
                    // If i is 0 display the table headings
                    for ($j = 0; $j < count($row); $j++) {
                        echo "<th>";
                        echo $row[$j];
                        echo "</th>";
                    }
                } else {
                    // Display the xlsx data
                    for ($j = 0; $j < count($row); $j++) {
                        echo "<td>";
                        echo $row[$j];
                        echo "</td>";
                }
            }
                $i++;
                echo "</tr>";
        }   
    } else {
        echo SimpleXLSX::parseError();
    }
        echo "</table>";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link rel="stylesheet" href="../../css/bootstrap.min.css" >
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <!-- Container to store the dataset table -->
        <div class="container" id="viewdataset-container">
            <div class="row">
                <div class="col-12">
                    <?php if ($extension == 'csv') {
                        readCSVDataset($filename);
                    } else {
                        readXLSXDataset($filename);
                    } ?>
                </div>
            </div>
        </div>
    </body>
</html>
