<?php
session_start();
include('header.php');
require_once '../src/Connection.php';
require_once '../src/User.php';

$user = User::loadUserByID($conn, $_SESSION['user']);

?>
    <div class="big-font w3-round-xlarge" id="right" style="font-size: 150%">
        <div class="w3-right w3-panel w3-round-xlarge">
            <form action="#" method="POST" style="font-size: 100%">
                <input class="w3-btn w3-black" type="submit" name="delete" value="delete account">
            </form>
        </div>
        <div class="after-box w3-panel w3-round-xlarge w3-right">
            <a class="w3-btn w3-black"  href="logout.php">log out</a>
        </div>
        <div class="after-box w3-panel w3-round-xlarge w3-right">
            <a class="w3-btn w3-pink"  href="message.php">messages</a>
        </div>
    </div>
    <div class="w3-container big-font w3-round-xlarge" id="middle">
        <div class='w3-panel w3-white big-font w3-round-xlarge'>
            <a> <?php echo $user->getNick() ?></a>
        </div>
        <div class='w3-panel w3-black w3-round-xlarge'>
            <a> change your password: </a>
        </div>
        <form action="#" method="POST">
            <label class="w3-text-black"><b>old password</b></label>
            <input class="w3-input w3-border" type="password" name="old_password" required>
            <label class="w3-text-black"><b>new password</b></label>
            <input class="w3-input w3-border" type="password" name="password" required>
            <label class="w3-text-black"><b>confirm new password</b></label>
            <input class="w3-input w3-border" type="password" name="password2" required>
            <button class="w3-btn w3-black">change password</button>
        </form>

    </div>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $user->deleteUserFromDB($conn);
    unset($_SESSION['user']);
    session_unset();
    echo "<meta http-equiv=\"refresh\" content=\"0;url='/Twitter/web/index.php'\">";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['old_password']) && isset($_POST['password'])
    && isset($_POST['password2'])
) {
    $oldPassword = $_POST['old_password'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (password_verify($oldPassword, $user->getPassword()) == FALSE) {
        echo "<p class='w3-pink w3-round' id='middle'> Incorrect old password. </p>";
        exit;
    }

    if ($password != $password2) {
        echo "<p class='w3-pink w3-round' id='middle'> Please input the same new password twice and try again. </p>";
        exit;
    }

    $user->setPassword($password);
    $user->saveToDB($conn);
    echo "<p class='w3-pink w3-round' id='middle'> Password changed. </p>";
}