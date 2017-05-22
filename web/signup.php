<?php
include('header.php');
?>

<form class="w3-container w3-display-middle" style="width:600px;" action="#" method="POST">

    <label class="w3-text-black"><b>NICK</b></label>
    <input class="w3-input w3-border" type="text" name="nick" required>

    <label class="w3-text-black"><b>EMAIL</b></label>
    <input class="w3-input w3-border" type="email" name="email" required>

    <label class="w3-text-black"><b>PASSWORD</b></label>
    <input class="w3-input w3-border" type="password" name="password" required>

    <label class="w3-text-black"><b>CONFIRM PASSWORD</b></label>
    <input class="w3-input w3-border" type="password" name="password2" required>
    <br>
    <button class="w3-btn w3-black">Sign up</button>


    <?php
    require_once '../src/Connection.php';
    require_once '../src/User.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['password'])
            && isset($_POST['password2'])
        ) {

            $nick = $_POST['nick'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                echo "<p> Please input the same password twice and try again. </p>";
                die();

            }

            $query = "SELECT id FROM `user` WHERE email = $email";
            $result = $conn->query($query);
            echo gettype($result);
            var_dump($result);
//            if (empty($result)) {
//                echo "puste";
//            } else {
//                echo "nie puste";
//            }
//            if ($result) {
//                $user = new User();
//                $user->setNick($nick);
//                $user->setEmail($email);
//                $user->setPassword($password);
//
//                $user->save($conn);
//                echo "lala";
//            } else {
//                echo "Sorry but user with that email is already registered";
//                die();
//
//                $user = new User();
//                $user->setNick($nick);
//                $user->setEmail($email);
//                $user->setPassword($password);
//
//                $user->save($conn);
//                echo "lala";
//            }
        }
    }

    ?>
</form>