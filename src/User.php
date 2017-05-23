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

    public function setId($id) {
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
                die('Error user not saved: ' . $conn->errno);
            }
        }
    }

    public function setHash($hash)
    {

        $this->password = $hash;
    }

    public static function findByEmail (mysqli $conn, $email)
    {
        $query = "SELECT id FROM `user` WHERE email = '" . $email . "'";
        $result = $conn->query($query);
        if ($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    static public function loadUserByEmail(mysqli $conn, $email) {

        $email = $conn->real_escape_string($email);

        $sql = "SELECT * FROM `user` WHERE email='$email'";

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

}