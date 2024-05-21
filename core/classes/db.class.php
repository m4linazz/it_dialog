<?php 

    require_once($_SERVER["DOCUMENT_ROOT"]."/core/config.php");

    class DB 
    {

        private static mysqli $connection;

        public static function Connect(): mysqli 
        {

            $con = new mysqli(Config::mysql_host,Config::mysql_username,Config::mysql_password,Config::mysql_database);

            if(!$con) return false;

            self::$connection = $con;

            return self::$connection;

        }

        public static function Query(string $query, bool $oneRow = false): ?array
        {

            $query_result = DB::Connect()->query($query);

            if(!$query_result) return null;

            $fetch_result = $oneRow ? $query_result->fetch_assoc() : $query_result->fetch_all(MYSQLI_ASSOC);

            return is_array($fetch_result) ? $fetch_result : null;

        }

        public static function Execute(string $query)
        {

            if(empty($query)) return null;

            DB::Connect()->query($query);

        }

        public static function NumRows(string $query, bool $oneRow = false) : int 
        {

            $query_result = DB::Connect()->query($query);

            if(!$query_result) return null;

            $fetch_result = $oneRow ? $query_result->fetch_assoc() : $query_result->fetch_all(MYSQLI_ASSOC);

            return is_array($fetch_result) ? count($fetch_result) : null;

        }

    }

?>