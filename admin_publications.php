<?php 

    $page = "Публикации";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/publications/publications_header.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/publications/modules/publications_add.html");

        $publications_query = DB::Query("SELECT * FROM `publications`");

        foreach ($publications_query as $formatted_value) {
            
            $publications_id = $formatted_value["id"];
            $publications_title = $formatted_value["title"];
            $publications_text = $formatted_value["text"];
            $publications_photo = $formatted_value["photo"];

            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/publications/publications_body.html");
            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/publications/modules/publications_modal.html");
            
        }

        if(isset($_POST['publication_add'])) {

            $publication_add_title = $_POST['publication_add_title'];
            $publication_add_text = $_POST['publication_add_text'];

            if(isset($publication_add_title) && isset($publication_add_text)) {

                if ($_FILES && $_FILES["publication_add_photo"]["error"]== UPLOAD_ERR_OK) {
                    $publication_add_photo = "./dist/admin/uploads/publications/" . Base::Translator($_FILES["publication_add_photo"]["name"]);
                    move_uploaded_file($_FILES["publication_add_photo"]["tmp_name"], $publication_add_photo);
                }

                DB::Execute("INSERT INTO `publications` (`title`,`text`,`photo`) VALUES ('$publication_add_title','$publication_add_text','$publication_add_photo')");

                header("Location: /admin_publications");

            } else {

                header("Location: /admin_publications");

            }

        }

        if(isset($_POST['publication_edit'])) {

            $publication_edit_id = $_POST['publication_edit_id'];
            $publication_edit_title = $_POST['publication_edit_title'];
            $publication_edit_text = $_POST['publication_edit_text'];
            $publication_edit_photo_old = $_POST['publication_edit_photo_old'];

            if(isset($publication_edit_title) && isset($publication_edit_text)) {

                if ($_FILES && $_FILES["publication_edit_photo"]["error"]== UPLOAD_ERR_OK) {
                    if(Base::Translator($_FILES["publication_edit_photo"]["name"]) != $publication_edit_photo_old) {
                        $publication_edit_photo = "./dist/admin/uploads/publications/" . Base::Translator($_FILES["publication_edit_photo"]["name"]);
                        unlink($publication_edit_photo_old);
                        move_uploaded_file($_FILES["publication_edit_photo"]["tmp_name"], $publication_edit_photo);
                    } else {
                        $publication_edit_photo = $publication_edit_photo_old;
                    }
                }

                DB::Execute("UPDATE `publications` SET `title` = '$publication_edit_title', `text` = '$publication_edit_text', `photo` = '$publication_edit_photo' WHERE `id` = '$publication_edit_id'");

                header("Location: /admin_publications");

            } else {

                header("Location: /admin_publications");

            }

        }

        if(isset($_POST['publication_delete'])) {

            $publication_delete_id = $_POST['publication_delete_id'];
            $publication_delete_photo = $_POST['publication_delete_photo'];

            if(isset($publication_delete_id) && isset($publication_delete_photo)) {

                unlink($publication_delete_photo);
                DB::Execute("DELETE FROM `publications` WHERE `id` = '$publication_delete_id'");

                header("Location: /admin_publications");

            }

        }

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/publications/publications_footer.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>