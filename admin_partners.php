<?php 

    $page = "Партнёры";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/partners/partners_header.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/partners/modules/partners_add.html");

        $partners_query = DB::Query("SELECT * FROM `partners`");

        foreach ($partners_query as $formatted_value) {
            
            $partners_id = $formatted_value["id"];
            $partners_title = $formatted_value["title"];
            $partners_photo = $formatted_value["photo"];
            $partners_link = $formatted_value["link"];

            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/partners/partners_body.html");
            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/partners/modules/partners_modal.html");
            
        }

        if(isset($_POST['partner_add'])) {

            $partner_add_title = $_POST['partner_add_title'];
            $partner_add_link = $_POST['partner_add_link'];

            if(isset($partner_add_title) && isset($partner_add_link)) {

                if ($_FILES && $_FILES["partner_add_photo"]["error"]== UPLOAD_ERR_OK) {
                    $partner_add_photo = "./dist/admin/uploads/partners/" . Base::Translator($_FILES["partner_add_photo"]["name"]);
                    move_uploaded_file($_FILES["partner_add_photo"]["tmp_name"], $partner_add_photo);
                }

                DB::Execute("INSERT INTO `partners` (`title`,`photo`,`link`) VALUES ('$partner_add_title','$partner_add_photo','$partner_add_link')");

                header("Location: /admin_partners");

            } else {

                header("Location: /admin_partners");

            }

        }

        if(isset($_POST['partner_edit'])) {

            $partner_edit_id = $_POST['partner_edit_id'];
            $partner_edit_title = $_POST['partner_edit_title'];
            $partner_edit_link = $_POST['partner_edit_link'];
            $partner_edit_photo_old = $_POST['partner_edit_photo_old'];

            if(isset($partner_edit_title)) {

                if ($_FILES && $_FILES["partner_edit_photo"]["error"]== UPLOAD_ERR_OK) {
                    if(Base::Translator($_FILES["partner_edit_photo"]["name"]) != $partner_edit_photo_old) {
                        $partner_edit_photo = "./dist/admin/uploads/partners/" . Base::Translator($_FILES["partner_edit_photo"]["name"]);
                        unlink($partner_edit_photo_old);
                        move_uploaded_file($_FILES["partner_edit_photo"]["tmp_name"], $partner_edit_photo);
                    } else {
                        $partner_edit_photo = $partner_edit_photo_old;
                    }
                }

                DB::Execute("UPDATE `partners` SET `title` = '$partner_edit_title', `photo` = '$partner_edit_photo', `link` = '$partner_edit_link' WHERE `id` = '$partner_edit_id'");

                header("Location: /admin_partners");

            } else {

                header("Location: /admin_partners");

            }

        }

        if(isset($_POST['partner_delete'])) {

            $partner_delete_id = $_POST['partner_delete_id'];
            $partner_delete_photo = $_POST['partner_delete_photo'];

            if(isset($partner_delete_id) && isset($partner_delete_photo)) {

                unlink($partner_delete_photo);
                DB::Execute("DELETE FROM `partners` WHERE `id` = '$partner_delete_id'");

                header("Location: /admin_partners");

            }

        }

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/partners/partners_footer.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>