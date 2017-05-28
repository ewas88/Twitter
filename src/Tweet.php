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

    public function setId($id)
    {
        $this->id = $id;
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
        $sql = "SELECT user.id AS user, tweet.id AS id, user.nick AS nick, tweet.post AS post, tweet.post_date AS post_date
                FROM `tweet` LEFT JOIN `user` ON tweet.user_id=user.id ORDER BY `post_date` DESC";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        return $result;
    }

    public function save(mysqli $conn)
    {
        $sql = sprintf(
            "INSERT INTO `tweet` (post, post_date, user_id) VALUES ('%s','%s','%s')",
            $this->post, $this->postDate, $this->userID);

        $result = $conn->query($sql);

        if ($result) {
            $this->id = $conn->insert_id;
        } else {
            die('Error tweet not saved: ' . $conn->error);
        }

    }

    public static function loadUserByTweetID(mysqli $conn, $tweetID)
    {

        $sql = "SELECT * FROM `user` JOIN `tweet` ON user.id=tweet.user_id WHERE tweet.id='$tweetID'";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        if ($result->num_rows === 1) {
            return $result;
        } else {
            return false;
        }
    }

    public static function loadCommentsByTweetID(mysqli $conn, $tweetID)
    {

        $sql = "SELECT * FROM `comment` JOIN `user` ON comment.user_id=user.id 
                WHERE comment.tweet_id='$tweetID' ORDER BY comment.comment_date DESC";

        $result = $conn->query($sql);

        if (!$result) {
            die('Query error: ' . $conn->error);
        }

        return $result;

    }

}