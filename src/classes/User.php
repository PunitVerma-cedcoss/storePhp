<?php
require "DB.php";
class User extends DB
{
    public string $username;
    public string $password;
    public string $email;

    public function __construct($username, $password, $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function addUser()
    {
        $sql = "INSERT INTO `users` (`id`, `userName`, `email`, `password`, `type`, `approved`) VALUES (NULL,'$this->username', '$this->email', '$this->password', 'customer', '0')";
        try {
            DB::getInstance()->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }
}
