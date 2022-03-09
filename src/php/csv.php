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
    case "csvToArray":
        csvToArray($_POST["data"]);
        break;
    case "insert":
        insert($_POST["data"]);
        break;
    default:
        echo "inavlid ";
        break;
}

function readCsv($data)
{
    $csv = str_getcsv($data);
    echo '<pre>';
    print_r($csv);
    echo '</pre>';
}
function csvToArray($data)
{
    $fp = fopen("php://temp", 'r+');
    fputs($fp, $data);
    rewind($fp);
    $csv = [];
    while (($data = fgetcsv($fp)) !== false) {
        $csv[] = $data;
    }
    echo json_encode($csv);
    fclose($fp);
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
function insert($data)
{
    $util = new Util();
    $sql = "INSERT INTO Products VALUES ";
    for ($i = 1; $i < count($data) - 1; $i++) {
        $sql .= " (NULL,";
        for ($j = 1; $j < count($data[0]); $j++) {
            if (is_numeric($data[$i][$j])) {
                $sql .= "'" . (int) $data[$i][$j] . "'";
                if ($j != count($data[0]) - 1) {
                    $sql .= ", ";
                }
            } else {
                $sql .= "'" . $data[$i][$j] . "'";
                if ($j != count($data[0]) - 1) {
                    $sql .= ", ";
                }
            }
        }
        $sql .= ")";
        if ($i != count($data) - 2) {
            $sql .= ", ";
        }
    }
    $sql .= ";";
    // echo $sql;
    echo $util->query($sql);
}
