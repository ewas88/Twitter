<?php
include('header.php');
require_once '../src/Connection.php';
require_once '../src/User.php';

<div class="w3-container big-font w3-white w3-round-xlarge" id="center">
        <?php
        foreach ($tweets as $tweet) {
            ?>
            <div class='w3-panel w3-pink'>
                <a> tweet: </a>
            </div>
            <div class='w3-panel w3-white'>
                <?php
                echo "<a><b>" . $tweet['post'] . "</b></a>";
                ?>
            </div>
            <div class='w3-panel w3-pink'>
                <a> tweet author: </a>
            </div>
            <div class='w3-panel w3-white'>
                <?php
                echo "<a>" . $tweet['nick'] . "</a>";
                ?>
            </div>
            <div class='w3-panel w3-pink'>
                <a> comments: </a>
            </div>
            <?php
        }
        foreach ($comments as $comment) {
            ?>
            <div class='w3-panel w3-white'>
                <?php
                echo "<a>@" . $comment['nick'] .": ". $comment['content'] . "</a>";
                ?>
            </div>
            <?php
        }
        ?>
</div>
