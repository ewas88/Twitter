<?php
session_start();
include('header.php');
require_once '../src/Connection.php';
require_once '../src/Tweet.php';
require_once '../src/Comment.php';

?>
    <div id="left" class="container">
        <form action="#" method="POST">
            <br><br>
            <input class="w3-input w3-border" type="text" maxlength="140" name="comment" required>
            <button class="w3-btn w3-black">add comment</button>
        </form>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {

    $content = $conn->real_escape_string($_POST['comment']);
    $date = date("Y-m-d G:i:s");

    $comment = new Comment();
    $comment->setContent($content);
    $comment->setCommentDate($date);
    $comment->setUserID($_SESSION['user']);
    $comment->setTweetID($_SESSION['post_id']);

    $comment->save($conn);

    $t = $_SESSION['post_id'];
    echo "<meta http-equiv=\"refresh\" content=\"0;url='/Twitter/web/tweetSite.php?id=$t'\">";
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $_SESSION['post_id'] = $_GET['id'];
    $tweetID = $_GET['id'];
    $tweets = Tweet::loadUserByTweetID($conn, $tweetID);
    $comments = Tweet::loadCommentsByTweetID($conn, $tweetID);

    echo '<div class="w3-container big-font w3-white w3-round-xlarge" id="center">';
    foreach ($tweets as $tweet) {
        echo '<div class="w3-panel w3-pink">';
        echo "<a> tweet: </a>";
        echo "</div>";
        echo '<div class="w3-panel w3-white">';
        echo "<a><b>" . $tweet['post'] . "</b></a>";
        echo "</div>";
        echo '<div class="w3-panel w3-pink">';
        echo "<a> tweet author: </a>";
        echo "</div>";
        echo '<div class="w3-panel w3-white">';
        echo "<a>" . $tweet['nick'] . "</a>";
        echo "</div>";
        echo '<div class="w3-panel w3-pink">';
        echo "<a> comments: </a>";
        echo "</div>";
    }
    foreach ($comments as $comment) {
        echo '<div class="w3-panel w3-white">';
        echo "<a>@" . $comment['nick'] . ": " . $comment['content'] . "</a>";
        echo "</div>";
    }
    echo "</div>";
}
