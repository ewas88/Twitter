<?php


class Message
{
    private $id;
    private $message;
    private $messageDate;
    private $recipientID;
    private $senderID;
    private $read;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessageDate()
    {
        return $this->messageDate;
    }

    /**
     * @param mixed $messageDate
     */
    public function setMessageDate($messageDate)
    {
        $this->messageDate = $messageDate;
    }

    /**
     * @return mixed
     */
    public function getRecipientID()
    {
        return $this->recipientID;
    }

    /**
     * @param mixed $recipientID
     */
    public function setRecipientID($recipientID)
    {
        $this->recipientID = $recipientID;
    }

    /**
     * @return mixed
     */
    public function getSenderID()
    {
        return $this->senderID;
    }

    /**
     * @param mixed $senderID
     */
    public function setSenderID($senderID)
    {
        $this->senderID = $senderID;
    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @param mixed $read
     */
    public function setRead($read)
    {
        $this->read = $read;
    }



}