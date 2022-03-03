<?php
require "DB.php";
class Util extends DB
{
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users";
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT * FROM users where email = '$email' AND password = '$password'");
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $res = $stmt->fetchAll();
            if (count($res) == 1) {
                //now check if its approved or not
                if ($res[0]["approved"] == 1) {
                    session_start();
                    $_SESSION["user"] = $res[0]["email"];
                    $_SESSION["type"] = $res[0]["type"];
                    $_SESSION["data"] = $res[0];
                    return "ok";
                } else {
                    return "notapproved";
                }
            } else {
                return "incorrect";
            }
        } catch (PDOException $e) {
            echo $e;
            return "error";
        }
    }
    public function addProduct($productName, $productPrice, $productQuantity, $productCategory, $productRating)
    {
        $sql = "INSERT INTO `Products` (`id`, `product_name`, `product_price`, `product_quantity`, `product_category`, `product_rating`) VALUES (NULL, '$productName', '$productPrice', '$productQuantity', '$productCategory', '$productRating');";
        try {
            DB::getInstance()->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
    public function getProducts()
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT * from Products LIMIT 5");
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $e) {
            echo $e;
            return "error";
        }
    }
    public function getUsers()
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT * from users");
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $e) {
            echo $e;
            return "error";
        }
    }
    public function toggleStatus($email)
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT approved from users WHERE email = '$email'");
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $res = $stmt->fetchAll();
            print_r($res[0]);
            echo $email;
            //   if status is approved 
            $sql = "UPDATE users SET approved = IF(approved=1, 0, 1) WHERE email = '$email';";
            try {
                DB::getInstance()->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }

            return $res;
        } catch (PDOException $e) {
            echo $e;
            return "error";
        }
    }
    public function deteUser($email)
    {
        if ($_SESSION["user"] == "admin@store.com") {
            $sql = "DELETE FROM users WHERE email = '$email'";
            try {
                DB::getInstance()->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        } else "user is not admin";
    }
}
