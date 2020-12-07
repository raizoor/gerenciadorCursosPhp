<?php
    require_once("config.php");
    session_unset();
    session_destroy();
    sleep(2);
    header('location: login.html');
?>