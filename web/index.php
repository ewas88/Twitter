<?php
include('header.php');


if (!isset($_SESSION['user'])) {
    ?>
    <div class="container w3-display-middle">
        <a href="login.php" class="w3-black w3-btn w3-round-xlarge">ALREADY A USER?<br>LOG IN!</a>
        <a href="signup.php" class="w3-black w3-btn w3-round-xlarge">ARE YOU NEW?<br>SIGN UP!</a>
    </div>
    <?php
} else {

}