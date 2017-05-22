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



}