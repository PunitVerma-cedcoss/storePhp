<?php

use App\Util;

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

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
    } elseif ($_POST["action"] == "deleteUser") {
        if ($util->deteUser($_POST["email"])) {
            echo "success";
        } else {
            echo "error";
        }
        // echo "cool";
    } elseif ($_POST["action"] == "updateProfile") {
        if ($util->updateProfile($_POST)) {
            echo "success";
        } else {
            echo "error";
        }
    } elseif ($_POST["action"] == "addCategory") {
        if ($util->addCategory($_POST["category"])) {
            echo "success";
        } else {
            echo "error";
        }
    } elseif ($_POST["action"] == "pagination") {
        if (isset($_POST["orderby"])) {
            print_r(json_encode($util->pagination($_POST["offset"], $_POST["orderby"])));
        } else {
            print_r(json_encode($util->pagination($_POST["offset"])));
        }
    } elseif ($_POST["action"] == "getTotalPages") {
        print_r(ceil($util->countPages()[0]["count"] / 5));
    } elseif ($_POST["action"] == "deleteProduct") {
        if ($util->deleteProduct($_POST["id"])) {
            echo "success";
        } else {
            echo "error";
        }
    } elseif ($_POST["action"] == "search") {
        print_r(json_encode($util->searchProduct($_POST["query"])));
    } elseif ($_POST["action"] == "addToCart") {
        if (isset($_POST["quantity"])) {
            print_r(json_encode($util->addToCart($_POST["id"], $_POST["quantity"])));
        } else {
            print_r(json_encode($util->addToCart($_POST["id"])));
        }
    } elseif ($_POST["action"] == "getCart") {
        print_r(json_encode($util->getCart()));
    } elseif ($_POST["action"] == "updateCart") {
        echo $util->updateCart($_POST["productId"], $_POST["quantity"]);
    } elseif ($_POST["action"] == "deleteCart") {
        echo $util->deleteCart($_POST["productId"]);
    } elseif ($_POST["action"] == "applyPromo") {
        print_r(json_encode($util->applyPromo($_POST["promoCode"])));
        // if ($util->applyPromo($_POST["promoCode"])) {
        //     return "success";
        // } else {
        //     "error";
        // }
    } elseif ($_POST["action"] == "checkout") {
        if ($util->checkout($_POST)) {
            echo "success";
        } else {
            echo "error";
        }
    } elseif ($_POST["action"] == "changeStatus") {
        if ($util->changeStatus($_POST["id"], $_POST["status"])) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
