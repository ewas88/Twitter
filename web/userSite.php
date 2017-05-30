<?php
session_start();
include('header.php');
require_once '../src/Connection.php';
require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/Message.php';

$user = User::loadUserByID($conn, $_GET['id']);

?>
    <div id="left" class="container">
    <form action="#" method="POST">
        <br><br>
        <input class="w3-input w3-border" type="text" maxlength="500" name="message" required>
        <?php
        echo '<button class="w3-btn w3-black">' . "send message to " . $user->getNick() . '</button>';
        ?>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $content = $_POST['message'];
    $date = date("Y-m-d G:i:s");

    $message = new Message();
    $message->setMessage($content);
    $message->setMessageDate($date);
    $message->setRecipientID($user->getId());
    $message->setSenderID($_SESSION['user']);
    $message->setRead(NULL);

    $message->save($conn);

    $t = $user->getId();
    echo "<meta http-equiv=\"refresh\" content=\"0;url='/Twitter/web/userSite.php?id=$t'\">";

}

echo "</div>";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

    $userID = $_GET['id'];
    $tweets = Tweet::loadTweetsByUserID($conn, $userID);


    ?>
    <div class="w3-container big-font" id="center">
    <div class="w3-panel w3-pink w3-round-xlarge">
        <?php
        echo "<a class='big-font'>" . $user->getNick() . "</a>";
        ?>
    </div>
    <?php
    foreach ($tweets as $tweet) {
        echo '<div class="w3-panel w3-white w3-round-xlarge">';
        echo "<a> tweet: </a>";
        echo '<a href="tweetSite.php?id=' . $tweet['id'] . '"><b>' . $tweet['post'] . '</b></a><br>';
        echo "<a> tweet date: </a>";
        echo "<a>" . date('Y-m-d', strtotime($tweet['post_date'])) . "</a><br>";
        $comments = Tweet::loadCommentsByTweetID($conn, $tweet['id']);
        echo '<a class="fa fa-comment">' . $comments->num_rows . '</a><br>';
        echo "</div>";
    }
    echo "</div>";
}
