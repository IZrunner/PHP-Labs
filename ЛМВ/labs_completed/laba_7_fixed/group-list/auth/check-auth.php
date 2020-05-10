<?php
    session_start();
    if (!$_SESSION['user']) {
        header('Location: auth/login.php');#'Location: /group-list/auth/login.php'
    }

    function CheckRight($object, $right){
        require(__DIR__ . '/../data/declare-users.php');
        $found = false;
        foreach ($data['users'] as $user) {
            if ($user['name'] == $_SESSION['user']) {
                $found = true;
                break;
            }
        }
        if ($found) {
            if ($object == 'group' && $right == 'view' && substr($user['rights'], 0, 1)) {
                return true;
            }            
            if ($object == 'group' && $right == 'create' && substr($user['rights'], 1, 1)) {
                return true;
            }            
            if ($object == 'group' && $right == 'edit' && substr($user['rights'], 2, 1)) {
                return true;
            }
            if ($object == 'group' && $right == 'delete' && substr($user['rights'], 3, 1)) {
                return true;
            }
            if ($object == 'student' && $right == 'view' && substr($user['rights'], 4, 1)) {
                return true;
            }
            if ($object == 'student' && $right == 'create' && substr($user['rights'], 5, 1)) {
                return true;
            }
            if ($object == 'student' && $right == 'edit' && substr($user['rights'], 6, 1)) {
                return true;
            }
            if ($object == 'student' && $right == 'delete' && substr($user['rights'], 7, 1)) {
                return true;
            }
            if ($object == 'user' && $right == 'admin' && substr($user['rights'], 8, 1)) {
                return true;
            }
        }
        return false;
    }