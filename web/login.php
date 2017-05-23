

<?php
session_start();
include('header.php');
?>

<form class="w3-container w3-display-middle" style="width:600px;" action="#" method="POST">

    <h2 class="w3-black" style="font-family:Sofia; font-size: 200%"><b> < LOG IN FORM ></b></h2>

    <label class="w3-text-black"><b>EMAIL</b></label>
    <input class="w3-input w3-border" type="email" name="email" required>

    <label class="w3-text-black"><b>PASSWORD</b></label>
    <input class="w3-input w3-border" type="password" name="password" required>

    <br>
    <button class="w3-btn w3-black">Log in</button>

    <?php
    require_once '../src/Connection.php';
    require_once '../src/User.php';



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::loadUserByEmail($conn, $email);

            if ($user === false) {
                echo "<p class='w3-pink'> Incorrect email or password. </p>";
                exit;
            }

            if (password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user->getId();
            } else {
                echo "<p class='w3-pink'> Incorrect email or password. </p>";
                exit;
            }
            echo "<meta http-equiv=\"refresh\" content=\"0;url='/Twitter/web/index.php'\">";
        }
    }
    ?>
</form>