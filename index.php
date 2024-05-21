<?php 

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    $club_users_list = DB::Query("SELECT * FROM `club_users`");
    $events_list = DB::Query("SELECT * FROM `events`");
    $partners_list = DB::Query("SELECT * FROM `partners`");
    $publications_list = DB::Query("SELECT * FROM `publications`");

    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/home/home.html");

?>