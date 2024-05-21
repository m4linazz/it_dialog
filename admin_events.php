<?php 

    $page = "Мероприятия";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/events/events_header.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/events/modules/events_add.html");

        $events_query = DB::Query("SELECT * FROM `events`");

        foreach ($events_query as $formatted_value) {
            
            $events_id = $formatted_value["id"];
            $events_title = $formatted_value["title"];
            $events_photo = $formatted_value["photo"];
            $events_date = $formatted_value["date"];

            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/events/events_body.html");
            include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/events/modules/events_modal.html");
            
        }

        if(isset($_POST['event_add'])) {

            $event_add_title = $_POST['event_add_title'];
            $event_add_date = $_POST['event_add_date'];

            if(isset($event_add_title) && isset($event_add_date)) {

                if ($_FILES && $_FILES["event_add_photo"]["error"]== UPLOAD_ERR_OK) {
                    $event_add_photo = "./dist/admin/uploads/events/" . Base::Translator($_FILES["event_add_photo"]["name"]);
                    move_uploaded_file($_FILES["event_add_photo"]["tmp_name"], $event_add_photo);
                }

                DB::Execute("INSERT INTO `events` (`title`,`photo`,`date`) VALUES ('$event_add_title','$event_add_photo','$event_add_date')");

                header("Location: /admin_events");

            } else {

                header("Location: /admin_events");

            }

        }

        if(isset($_POST['event_edit'])) {

            $event_edit_id = $_POST['event_edit_id'];
            $event_edit_title = $_POST['event_edit_title'];
            $event_edit_date = $_POST['event_edit_date'];
            $event_edit_photo_old = $_POST['event_edit_photo_old'];

            if(isset($event_edit_title) && isset($event_edit_date)) {

                if ($_FILES && $_FILES["event_edit_photo"]["error"]== UPLOAD_ERR_OK) {
                    if(Base::Translator($_FILES["event_edit_photo"]["name"]) != $event_edit_photo_old) {
                        $event_edit_photo = "./dist/admin/uploads/events/" . Base::Translator($_FILES["event_edit_photo"]["name"]);
                        unlink($event_edit_photo_old);
                        move_uploaded_file($_FILES["event_edit_photo"]["tmp_name"], $event_edit_photo);
                    } else {
                        $event_edit_photo = $event_edit_photo_old;
                    }
                }

                DB::Execute("UPDATE `events` SET `title` = '$event_edit_title', `photo` = '$event_edit_photo', `date` = '$event_edit_date' WHERE `id` = '$event_edit_id'");

                header("Location: /admin_events");

            } else {

                header("Location: /admin_events");

            }

        }

        if(isset($_POST['event_delete'])) {

            $event_delete_id = $_POST['event_delete_id'];
            $event_delete_photo = $_POST['event_delete_photo'];

            if(isset($event_delete_id) && isset($event_delete_photo)) {

                unlink($event_delete_photo);
                DB::Execute("DELETE FROM `events` WHERE `id` = '$event_delete_id'");

                header("Location: /admin_events");

            }

        }

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/admin/events/events_footer.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>