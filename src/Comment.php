<?php


class Comment
{
    private $id;
    private $content;
    private $commentDate;
    private $tweetID;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * @param mixed $commentDate
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

    /**
     * @return mixed
     */
    public function getTweetID()
    {
        return $this->tweetID;
    }

    /**
     * @param mixed $tweetID
     */
    public function setTweetID($tweetID)
    {
        $this->tweetID = $tweetID;
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

    public function save(mysqli $conn)
    {

        $sql = sprintf(
            "INSERT INTO `comment` (content, comment_date, user_id, tweet_id) 
                        VALUES ('%s','%s','%s','%s')", $this->content, $this->commentDate, $this->userID, $this->tweetID);

        $result = $conn->query($sql);

        if ($result) {
            $this->id = $conn->insert_id;
        } else {
            die('Error user not saved: ' . $conn->error);
        }

    }

}