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

    public function save(mysqli $conn)
    {
        $sql = sprintf(
            "INSERT INTO `message` (message, message_date, recipient_id, sender_id, `read`) 
                        VALUES ('%s','%s','%d','%d','%s')",
            $this->message, $this->messageDate, $this->recipientID, $this->senderID, $this->read);

        $result = $conn->query($sql);

        if ($result) {
            $this->id = $conn->insert_id;
        } else {
            die('Error message not saved: ' . $conn->error);
        }
    }

    public static function loadSentMassages(mysqli $conn, $id)
    {
        $query = sprintf(
            "SELECT * FROM `message` WHERE sender_id ='%d' ORDER BY `message_date` DESC",
        $id);
        $ret = [];
        $result = $conn->query($query);
        if ($result == true) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->message = $row['message'];
                $loadedMessage->messageDate = $row['message_date'];
                $loadedMessage->recipientID = $row['recipient_id'];
                $loadedMessage->senderID = $row['sender_id'];
                $loadedMessage->read = $row['read'];

                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    public static function loadReceivedMassages(mysqli $conn, $id)
    {
        $query = sprintf(
            "SELECT * FROM `message` WHERE recipient_id ='%d' ORDER BY `message_date` DESC",
        $id);
        $ret = [];
        $result = $conn->query($query);
        if ($result == true) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->message = $row['message'];
                $loadedMessage->messageDate = $row['message_date'];
                $loadedMessage->recipientID = $row['recipient_id'];
                $loadedMessage->senderID = $row['sender_id'];
                $loadedMessage->read = $row['read'];

                $ret[] = $loadedMessage;
            }
        }
        return $ret;
    }

    public static function loadMessageByID(mysqli $conn, $id)
    {
        $query = sprintf(
            "SELECT * FROM `message` WHERE id='%d'",
        $id);
        $result = $conn->query($query);
        if ($result == true && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->message = $row['message'];
            $loadedMessage->messageDate = $row['message_date'];
            $loadedMessage->recipientID = $row['recipient_id'];
            $loadedMessage->senderID = $row['sender_id'];
            $loadedMessage->read = $row['read'];

            return $loadedMessage;
        }
        return null;
    }

    public function saveToDB(mysqli $conn)
    {
        $sql = "UPDATE `message` SET `read`='$this->read' WHERE id=$this->id";
        $result = $conn->query($sql);
        if ($result == true) {
            return true;
        } else {
            die('Changes not saved ' . $conn->error);
        }
    }

}