<?php
require "DB.php";
class Util extends DB
{
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users";
        try {
            $conn = DB::getInstance();
            $stmt = $conn->prepare("SELECT email,password,approved FROM users where email = '$email' AND password = '$password'");
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $res = $stmt->fetchAll();
            if (count($res) == 1) {
                //now check if its approved or not
                if ($res[0]["approved"] == 1) {
                    session_start();
                    $_SESSION["user"] = $res[0]["email"];
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
}
