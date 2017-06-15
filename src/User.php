<?php

class User
{
    private $id;
    private $nick;
    private $email;
    private $password;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->id = -1;
        $this->nick = "";
        $this->email = "";
        $this->password = "";
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * @param mixed $nick
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function save(mysqli $conn)
    {

        if ($this->id === -1) {

            $sql = sprintf(
                "INSERT INTO `user` (email, nick, password) VALUES ('%s','%s','%s')", $this->email, $this->nick, $this->password);

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
            } else {
                die('Error user not saved: ' . $conn->error);
            }
        }
    }

    public function setHash($hash)
    {

        $this->password = $hash;
    }

    public static function findByEmail(mysqli $conn, $email)
    {
        $query = sprintf(
            "SELECT id FROM `user` WHERE email = '%s'",
        $email);
        $result = $conn->query($query);
        if ($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function loadUserByEmail(mysqli $conn, $email)
    {

        $email = $conn->real_escape_string($email);

        $sql = sprintf(
            "SELECT * FROM `user` WHERE email='%s'",
        $email);

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }
        if ($result->num_rows === 1) {

            $userArray = $result->fetch_assoc();

            $user = new User();

            $user->setId($userArray['id']);
            $user->setEmail($userArray['email']);
            $user->setNick($userArray['nick']);
            $user->setHash($userArray['password']);

            return $user;
        } else {
            return false;
        }
    }

    public static function findByNick(mysqli $conn, $nick)
    {
        $nick = $conn->real_escape_string($nick);

        $query = sprintf(
            "SELECT id FROM `user` WHERE nick = '%s'",
        $nick);
        $result = $conn->query($query);
        if ($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function loadUserByID(mysqli $conn, $id)
    {
        $query = sprintf(
            "SELECT * FROM `user` WHERE id = '%d'",
        $id);
        $result = $conn->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->nick = $row['nick'];
            $loadedUser->password = $row['password'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    public function deleteUserFromDB(mysqli $conn)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM `user` WHERE `id`=$this->id";
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = -1;
                return true;
            } else {
                die('Changes not saved ' . $conn->error);
            }
        }
        return true;
    }

    public function saveToDB(mysqli $conn)
    {
        $sql = "UPDATE `user` SET password='$this->password' WHERE id=$this->id";
        $result = $conn->query($sql);
        if ($result == true) {
            return true;
        } else {
            die('Changes not saved ' . $conn->error);
        }
    }
}