<?php

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    $login = $_POST["user_auth_login"];
    $password = $_POST["user_auth_password"];

    if(isset($login) && isset($password)) {

        $user_exist = DB::Query("SELECT `login`, `password`, `token` FROM `users` WHERE `login` = '$login'", true);

        if(is_null($user_exist)) {

            header("Location: /auth");
            
        } else {

            $user_login = $user_exist["login"];
            $user_password = $user_exist["password"];
            $user_token = $user_exist["token"];

            if($user_login == $login && password_verify($password,$user_password)) {

                $_SESSION["authed_user"] = $user_token;
                header("Location: /admin");

            } else {

                header("Location: /auth");

            }

        }

    } else {

        header("Location: /auth");

    }

?>