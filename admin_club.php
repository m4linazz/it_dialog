<?php 

    $page = "Клуб";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/club/club_header.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/club/modules/club_add.html");

        $club_users_query = DB::Query("SELECT * FROM `club_users`");

        foreach ($club_users_query as $formatted_value) {
            
            $club_user_id = $formatted_value["id"];
            $club_user_name = $formatted_value["name"];
            $club_user_position = $formatted_value["position"];
            $club_user_photo = $formatted_value["photo"];

            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/club/club_body.html");
            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/club/modules/club_modal.html");
            
        }

        if(isset($_POST['club_add'])) {

            $club_add_name = $_POST['club_add_name'];
            $club_add_position = $_POST['club_add_position'];

            if(isset($club_add_name) && isset($club_add_position)) {

                if ($_FILES && $_FILES["club_add_photo"]["error"]== UPLOAD_ERR_OK) {
                    $club_add_photo = "./dist/admin/uploads/club/" . Base::Translator($_FILES["club_add_photo"]["name"]);
                    move_uploaded_file($_FILES["club_add_photo"]["tmp_name"], $club_add_photo);
                }

                DB::Execute("INSERT INTO `club_users` (`name`,`position`,`photo`) VALUES ('$club_add_name','$club_add_position','$club_add_photo')");

                header("Location: /admin_club");

            } else {

                header("Location: /admin_club");

            }

        }

        if(isset($_POST['club_edit'])) {

            $club_edit_id = $_POST['club_edit_id'];
            $club_edit_name = $_POST['club_edit_name'];
            $club_edit_position = $_POST['club_edit_position'];
            $club_edit_photo_old = $_POST['club_edit_photo_old'];

            if(isset($club_edit_name) && isset($club_edit_position)) {

                if ($_FILES && $_FILES["club_edit_photo"]["error"]== UPLOAD_ERR_OK) {
                    if(Base::Translator($_FILES["club_edit_photo"]["name"]) != $club_edit_photo_old) {
                        $club_edit_photo = "./dist/admin/uploads/club/" . Base::Translator($_FILES["club_edit_photo"]["name"]);
                        unlink($club_edit_photo_old);
                        move_uploaded_file($_FILES["club_edit_photo"]["tmp_name"], $club_edit_photo);
                    } else {
                        $club_edit_photo = $club_edit_photo_old;
                    }
                }

                DB::Execute("UPDATE `club_users` SET `name` = '$club_edit_name', `position` = '$club_edit_position', `photo` = '$club_edit_photo' WHERE `id` = '$club_edit_id'");

                header("Location: /admin_club");

            } else {

                header("Location: /admin_club");

            }

        }

        if(isset($_POST['club_delete'])) {

            $club_delete_id = $_POST['club_delete_id'];
            $club_delete_photo = $_POST['club_delete_photo'];

            if(isset($club_delete_id) && isset($club_delete_photo)) {

                unlink($club_delete_photo);
                DB::Execute("DELETE FROM `club_users` WHERE `id` = '$club_delete_id'");

                header("Location: /admin_club");

            }

        }

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/club/club_footer.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>