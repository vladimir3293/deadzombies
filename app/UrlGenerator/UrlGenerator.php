<?php

namespace Deadzombies\UrlGenerator;

class UrlGenerator
{
    public function createUrl(string $string)
    {
        //dd($string);
        //#[^\p{L}0-9\s\!\-\_]#iu
        //$url = preg_replace("/[^a-zA-Zа-яА-Я0-9-\s]/",$sdf, $string);
        $url = preg_replace("/[^\w -]/u",'', $string);
        $url = trim($url);
        $url = mb_strtolower($url, 'UTF-8');
        $rus = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $eng = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', 'ie', 'y', '', 'e', 'iu', 'ia',);
        $url = str_replace($rus, $eng, $url);

        $url = preg_replace("/ +/", " ", $url);

        $url = str_replace(' ', '-', $url);
        //dd($url);
        #$createurl=stripcslashes($createurl);
        return $url;
    }

    /**
     * @TODO fix it
     * @param $name
     * @return mixed|string
     */
    public function create_name($name)
    {
        $name = trim($name);    #обрезает пробелы в конце и начале, должна еще и спецсимволы, но что-то через один
        $name = preg_replace('/  +/', ' ', $name);
        $del = array('~', '!', '@', '#', '%', '^', '&', '*', '(', ')', '_', '+', '=', '`', ',', '.', '/', '<', '>', '{', '}', '[', ']', ';', '\'', '\\', ':', '"', '|', '№', '$', '«', '»', '"');
        $name = str_replace($del, '', $name);
        return $name;
    }
}