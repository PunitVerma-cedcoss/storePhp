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
    public function addProduct($productName, $productPrice, $productQuantity, $productCategory, $productRating, $productImages, $productDesc, $productTags)
    {
        $sql = "INSERT INTO `Products` (`id`, `product_name`, `product_price`, `product_quantity`, `product_category`, `product_uploader`, `product_images`, `product_desc`, `product_rating`, `product_tags`) VALUES (NULL, '$productName', '$productPrice', '$productQuantity', '$productCategory', '" . $_SESSION["user"] . "', '$productImages', '$productDesc', '$productRating', '$productTags');";
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
            $stmt = $conn->prepare("SELECT id,product_name,product_price,product_quantity,product_category,product_uploader,product_desc,product_rating from Products  ORDER BY id DESC LIMIT 5");
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
    public function getUsers($limit = true)
    {
        try {
            $conn = DB::getInstance();
            $stmt = $limit ? $conn->prepare("SELECT * from users LIMIT 5") : $conn->prepare("SELECT * from users");
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
    public function updateProfile($data)
    {
        try {
            $username = $data["userName"];
            $email = $data["email"];
            $password = $data["password"];
            $_SESSION["user"] = $email;
            $_SESSION["data"]["email"] = $email;
            $_SESSION["data"]["userName"] = $username;
            $_SESSION["data"]["password"] = $password;
            DB::getInstance()->exec("UPDATE users SET userName = '$username',email='$email',password='$password' WHERE email='$email'");
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
    public function getCategories()
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT category from productCategory");
            $stmt->execute();
            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $res = $stmt->fetchAll();
            return $res;
        } catch (PDOException $e) {
            echo $e;
            return "error";
        }
    }
    public function addCategory($categoryName)
    {
        $categoryName = strtolower($categoryName);
        try {
            DB::getInstance()->exec("INSERT INTO productCategory VALUES ('$categoryName')");
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
    public function getAllProducts()
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT * from Products  ORDER BY id DESC");
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
    public function pagination($offset)
    {
        try {
            $conn = DB::getInstance();
            $query = 'SELECT * from Products  ORDER BY id LIMIT ' . 5 . ' OFFSET ' . $offset;
            $stmt = $conn->prepare($query);
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
    public function countPages()
    {
        try {
            $conn = DB::getInstance();
            $query = 'SELECT COUNT(id) as count from Products';
            $stmt = $conn->prepare($query);
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
    public function getProductById($id)
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT * from Products WHERE id='$id'");
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
    public function query($sql)
    {
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare($sql);
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
    public function deleteProduct($id)
    {
        if ($_SESSION["user"] == "admin@store.com") {
            $sql = "DELETE FROM Products WHERE id = '$id'";
            try {
                DB::getInstance()->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        } else "user is not admin";
    }
    public function updateProduct($id, $product_name, $product_price, $product_quantity, $product_category, $product_images, $product_desc, $product_rating, $product_tags)
    {
        try {
            DB::getInstance()->exec("UPDATE `Products` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_quantity` = '$product_quantity', `product_category` = '$product_category', `product_images` = '$product_images', `product_desc` = '$product_desc', `product_rating` = '$product_rating', `product_tags` = '$product_tags' WHERE `Products`.`id` = $id;");
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
}
