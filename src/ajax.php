<?php
// include "classes/utils.php";
include "../src/vendor/autoload.php";
use App\Util;

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
        if (isset($_POST["orderby"])) {
            print_r(json_encode($util->pagination($_POST["offset"], $_POST["orderby"])));
        } else {
            print_r(json_encode($util->pagination($_POST["offset"])));
        }
    } else if ($_POST["action"] == "getTotalPages") {
        print_r(ceil($util->countPages()[0]["count"] / 5));
    } else if ($_POST["action"] == "deleteProduct") {
        if ($util->deleteProduct($_POST["id"])) {
            echo "success";
        } else {
            echo "error";
        }
    } else if ($_POST["action"] == "search") {
        print_r(json_encode($util->searchProduct($_POST["query"])));
    } else if ($_POST["action"] == "addToCart") {
        print_r(json_encode($util->addToCart($_POST["id"])));
    } else if ($_POST["action"] == "getCart") {
        print_r(json_encode($util->getCart()));
    } else if ($_POST["action"] == "updateCart") {
        echo $util->updateCart($_POST["productId"], $_POST["quantity"]);
    } else if ($_POST["action"] == "deleteCart") {
        echo $util->deleteCart($_POST["productId"]);
    } else if ($_POST["action"] == "applyPromo") {
        print_r(json_encode($util->applyPromo($_POST["promoCode"])));
        // if ($util->applyPromo($_POST["promoCode"])) {
        //     return "success";
        // } else {
        //     "error";
        // }
    } else if ($_POST["action"] == "checkout") {
        if ($util->checkout($_POST)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
