<?php 

    $page = "Пользователи";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/users/user_header.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/users/modules/user_add.html");

        $users_query = DB::Query("SELECT * FROM `users`");

        foreach ($users_query as $formatted_value) {
            
            $user_id = $formatted_value["id"];
            $user_login = $formatted_value["login"];
            $user_password = $formatted_value["password"];
            $user_token = $formatted_value["token"];

            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/users/user_body.html");
            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/users/modules/user_modal.html");
            
        }

        if(isset($_POST['user_add'])) {

            $user_add_login = $_POST['user_add_login'];
            $user_add_password = $_POST['user_add_password'];

            if(isset($user_add_login) && isset($user_add_password)) {

                $user_already_exist = DB::Query("SELECT `login` FROM `users` WHERE `login` = '$user_add_login'");

                if(count($user_already_exist) == 0) {

                    if(strlen($user_add_password) >= 8) {

                        $user_add_password = password_hash($_POST['user_add_password'],PASSWORD_DEFAULT);
                        $user_add_token = Base::RandomString(32);
                        $user_add_created = time();

                        DB::Execute("INSERT INTO `users` (`login`,`password`,`token`,`created`) VALUES ('$user_add_login','$user_add_password','$user_add_token','$user_add_created')");

                        header("Location: /admin_users");

                    } else {

                        header("Location: /admin_users");
    
                    }

                } else {

                    header("Location: /admin_users");

                }

            } else {

                header("Location: /admin_users");

            }

        }

        if(isset($_POST['user_edit'])) {

            $user_edit_id = $_POST['user_edit_id'];
            $user_edit_password = $_POST['user_edit_password'];

            if(isset($user_edit_id) && isset($user_edit_password)) {

                if(strlen($user_edit_password) >= 8) {

                    $user_edit_password = password_hash($_POST['user_edit_password'],PASSWORD_DEFAULT);

                    DB::Execute("UPDATE `users` SET `password` = '$user_edit_password' WHERE `id` = '$user_edit_id'");

                    header("Location: /admin_users");

                } else {

                    header("Location: /admin_users");

                }

            } else {

                header("Location: /admin_users");

            }

        }

        if(isset($_POST['user_delete'])) {

            $user_delete_id = $_POST['user_delete_id'];

            if(isset($user_delete_id)) {

                DB::Execute("DELETE FROM `users` WHERE `id` = '$user_delete_id'");

                header("Location: /admin_users");

            }

        }

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/users/user_footer.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>