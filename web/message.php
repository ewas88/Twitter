<?php
session_start();
include('header.php');
require_once '../src/Connection.php';
require_once '../src/User.php';
require_once '../src/Message.php';

$user = User::loadUserByID($conn, $_SESSION['user']);
$sent = Message::loadSentMassages($conn, $user->getId());
$received = Message::loadReceivedMassages($conn, $user->getId());

?>

    <div class="w3-container w3-black big-font">MESSAGES</div>
    <div class="w3-container big-font w3-round-xlarge" id="left">
        <div class='w3-panel w3-pink w3-round-xlarge'>
            <a> received: </a>
        </div>

        <?php
        foreach ($received as $mes) {
            $sender = User::loadUserByID($conn, $mes->getSenderID());
            if ($mes->getRead() == NULL) {
                echo "<div class='w3-panel w3-white w3-round-xlarge'>";
                echo '<img src="https://cdn4.iconfinder.com/data/icons/flat-color-sale-tag-set/512/Accounts_label_promotion_sale_tag_21-128.png">';
                echo "<b>from: " . $sender->getNick() . "</b><br>";
                echo "<b>date: " . date("F j, Y", strtotime($mes->getMessageDate())) . "</b><br>";
                echo "<b>message: " . substr($mes->getMessage(), 0, 10) . "...</b><br>";
                echo '<b><a href="message.php?id=' . $mes->getId() . '"><u>' . "view whole message" . '</u></b></a><br>';
                echo "</div>";
            } else {
                echo "<div class='w3-panel w3-white w3-round-xlarge'>";
                echo "from: " . $sender->getNick() . "<br>";
                echo "date: " . date("F j, Y", strtotime($mes->getMessageDate())) . "<br>";
                echo "message: " . substr($mes->getMessage(), 0, 10) . "...<br>";
                echo '<a href="message.php?id=' . $mes->getId() . '"><u>' . "view whole message" . '</u></a><br>';
                echo "</div>";
            }
        }
        ?>

    </div>
    <div class="w3-container big-font w3-round-xlarge" id="center">
        <div class='w3-panel w3-pink w3-round-xlarge'>
            <a> sent: </a>
        </div>

        <?php
        foreach ($sent as $mes) {
            echo "<div class='w3-panel w3-white w3-round-xlarge'>";
            $recipient = User::loadUserByID($conn, $mes->getRecipientID());
            echo "to: " . $recipient->getNick() . "<br>";
            echo "date: " . date("F j, Y", strtotime($mes->getMessageDate())) . "<br>";
            echo "message: " . substr($mes->getMessage(), 0, 10) . "...<br>";
            echo '<a href="message.php?id=' . $mes->getId() . '"><u>' . "view whole message" . '</u></a><br>';
            echo "</div>";
        }
        ?>
    </div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $message = Message::loadMessageByID($conn, $_GET['id']);
    $message->setRead('READ');
    $message->saveToDB($conn);
    ?>

    <div class="w3-container big-font w3-round-xlarge" id="right">
        <div class='w3-panel w3-pink w3-round-xlarge'>
            <a> message details: </a>
        </div>
        <div class='w3-panel w3-white w3-round-xlarge'>

            <?php
            $recipient = User::loadUserByID($conn, $message->getRecipientID());
            $sender = User::loadUserByID($conn, $message->getSenderID());
            echo "from: " . $sender->getNick() . "<br>";
            echo "to: " . $recipient->getNick() . "<br>";
            echo "date: " . date("d-m-y, h:s", strtotime($message->getMessageDate())) . "<br>";
            echo "message: " . $message->getMessage() . "<br>";
            ?>

        </div>
        <a class="w3-right w3-black" href="message.php">
            <b>&nbsp; close message &nbsp;</b></a>
    </div>

    <?php
}