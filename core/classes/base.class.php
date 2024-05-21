<?php 

    class Base 
    {

        public static function Translator(string $text): string 
        {

            $replace_list = array(
                'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
                'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
                'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
                'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
                'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
                'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
                'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
         
                'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
                'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
                'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
                'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
                'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
                'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
                'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
            );
         
            $value = strtr($text, $replace_list);
            return $value;

        }

        public static function RandomString(int $length = 10): string 
        {

            $characters_list = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $characters_length = strlen($characters_list);
            $generated_string = "";

            for ($i = 0; $i < $length; $i++) {
                $generated_string .= $characters_list[random_int(0, $characters_length - 1)];
            }

            return $generated_string;

        }

    }

?>