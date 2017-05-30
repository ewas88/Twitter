<?php
session_start();
include('header.php');

unset($_SESSION['user']);
session_unset();

echo "<meta http-equiv=\"refresh\" content=\"0;url='/Twitter/web/index.php'\">";

