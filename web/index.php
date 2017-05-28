<?php
session_start();
include('header.php');
require_once '../src/Connection.php';
require_once '../src/Tweet.php';

if (!isset($_SESSION['user'])) {
    ?>
    <div class="container w3-display-middle big-font">
        <a href="login.php" class="w3-black w3-btn w3-round-xlarge">ALREADY A USER?<br>LOG IN!</a>
        <a href="signup.php" class="w3-black w3-btn w3-round-xlarge">ARE YOU NEW?<br>SIGN UP!</a>
    </div>
    <?php
} else {
    ?>
    <div id="left" class="container">
        <form action="#" method="POST">
            <br><br>
            <input class="w3-input w3-border" type="text" maxlength="140" name="tweet" required>

            <button class="w3-btn w3-black">add tweet</button>
        </form>
    </div>
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
    <div id="center" style="font-size: 120%">
        <?php
        $tweets = Tweet::loadAllTweets($conn);

        foreach ($tweets as $tweet) {
            ?>
            <div class="w3-panel w3-white w3-round-xlarge">
                <?php
                echo "<a>" . date("F j, Y, g:i a", strtotime($tweet['post_date'])) . "</a><br>";
                echo '<a href="userSite.php?id='.$tweet['user'] .'"><u>'. " @" .$tweet['nick'] .'</u></a><br>';
                echo '<a href="tweetSite.php?id='.$tweet['id'] .'"><b>'. $tweet['post'] .'</b></a>';
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div id="right">
        <div>
            <a class="w3-right w3-pink" style="font-family:Sofia; font-size: 150%" href="profile.php">
                <b>&nbsp; my profile &nbsp;</b></a>
        </div>
        <div class="after-box">
            <a class="w3-right w3-black" style="font-family:Sofia; font-size: 150%" href="logout.php">
                <b>&nbsp; log out &nbsp;</b></a>
        </div>
    </div>

    <?php
}