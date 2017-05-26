<?php


class Tweet
{
    private $id;
    private $post;
    private $postDate;
    private $userID;

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
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * @param mixed $postDate
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public static function loadAllTweets(mysqli $conn)
    {
        $sql = "SELECT * FROM `tweet` LEFT JOIN `user` ON tweet.user_id=user.id ORDER BY `post_date` DESC";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        return $result;
    }

    public function save(mysqli $conn)
    {
            $sql = sprintf(
                "INSERT INTO `tweet` (post, post_date, user_id) VALUES ('%s','%s','%s')", $this->post, $this->postDate, $this->userID);

            $result = $conn->query($sql);

            if ($result) {
                $this->id = $conn->insert_id;
            } else {
                die('Error tweet not saved: ' . $conn->error);
            }

    }

}