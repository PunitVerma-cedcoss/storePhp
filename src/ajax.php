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
    } else if ($_POST["action"] == "updateProfile") {
        if ($util->updateProfile($_POST)) {
            echo "success";
        } else {
            echo "error";
        }
    } else if ($_POST["action"] == "addCategory") {
        if ($util->addCategory($_POST["category"])) {
            echo "success";
        } else {
            echo "error";
        }
    } else if ($_POST["action"] == "pagination") {
        print_r(json_encode($util->pagination($_POST["offset"])));
    } else if ($_POST["action"] == "getTotalPages") {
        print_r(ceil($util->countPages()[0]["count"] / 5));
    } else if ($_POST["action"] == "deleteProduct") {
        if ($util->deleteProduct($_POST["id"])) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
