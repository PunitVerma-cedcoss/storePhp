<?php
include "classes/utils.php";
session_start();
$util = new Util();
if (isset($_POST["action"])) {
    if ($_POST["action"] == "toggleStatus") {
        if ($util->toggleStatus($_POST["email"])) {
            echo "success";
        } else {
            echo "error";
        }
        // echo "cool";
    } else if ($_POST["action"] == "deleteUser") {
        if ($util->deteUser($_POST["email"])) {
            echo "success";
        } else {
            echo "error";
        }
        // echo "cool";
    }
}
