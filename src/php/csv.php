<?php

use App\Util;

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

session_start();

switch ($_POST["action"]) {
    case "import":
        readCsv($_POST["path"]);
        break;
    case "export":
        writeCsv();
        break;
    default:
        echo "inavlid ";
        break;
}

function readCsv($path)
{
    $file = fopen($path, "r");
    print_r(fgetcsv($file));
    fclose($file);
}
function writeCsv()
{
    $util = new Util();
    $data = ($util->getProducts());
    $filename = random_int(0, 100000000000000000) . ".csv";
    $f = fopen("../csv/" . $filename, 'w');
    //write headings to the csv file
    fputcsv($f, array_keys($data[0]));
    //writing values to the csv file
    foreach ($data as $row) {
        fputcsv($f, $row);
    }
    fclose($f);
    echo "csv/" . $filename;
}
