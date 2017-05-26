<?php
include('header.php');
require_once '../src/Connection.php';
require_once '../src/Tweet.php';

session_start();
if (!isset($_SESSION['user'])) {
    ?>
    <div class="container w3-display-middle">
        <a href="login.php" class="w3-black w3-btn w3-round-xlarge">ALREADY A USER?<br>LOG IN!</a>
        <a href="signup.php" class="w3-black w3-btn w3-round-xlarge">ARE YOU NEW?<br>SIGN UP!</a>
    </div>
    <?php
} else {
    ?>
    <div>
        <a class="w3-right w3-pink" style="font-family:Sofia; font-size: 150%" href="profile.php">
            <b>&nbsp; my profile &nbsp;</b></a>
    </div>
    <div class="after-box">
        <a class="w3-right w3-black" style="font-family:Sofia; font-size: 150%" href="logout.php">
            <b>&nbsp; log out &nbsp;</b></a>
    </div>

    <form class="w3-container w3-display-topleft" style="margin-top: 150px;" action="#" method="POST">

        <input class="w3-input w3-border" type="text" maxlength="140" name="tweet" required>

        <button class="w3-btn w3-black">add tweet</button>

<br>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tweet'])) {

        $post = $_POST['tweet'];
        $date = date("Y-m-d G:i:s");

        $tweet = new Tweet();
        $tweet->setPost($post);
        $tweet->setPostDate($date);
        $tweet->setUserID($_SESSION['user']);

        $tweet->save($conn);
    }
    ?>
<div class="w3-white" style="margin-left: 300px;font-size: 120%">
        <?php
        $tweets = Tweet::loadAllTweets($conn);

        foreach ($tweets as $tweet) {
                echo "<a>" . date("F j, Y, g:i a", strtotime($tweet['post_date'])) . "</a><br>";
                echo "<a>" . " @" . $tweet['nick'] . "</a><br>";
                echo "<a>" . $tweet['post'] . "</a><hr>";
                ?>
            <?php
        }
        ?>
</div>
</form>

    <?php
}