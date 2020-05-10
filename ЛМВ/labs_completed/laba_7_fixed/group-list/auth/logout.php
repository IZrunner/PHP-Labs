<?php
    session_start();
    unset($_SESSION['user']);
    header('Location: login.php');#'Location: /group-list/auth/login.php'