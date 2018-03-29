<?php

namespace Deadzombies\UrlGenerator;

class UrlGenerator
{
    public function createUrl(string $string)
    {
        $url = preg_replace("/[^a-zA-Zа-яА-Я0-9-\s]/", "", $string);
        $url = trim($url);
        $url = mb_strtolower($url, 'UTF-8');
        $rus = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $eng = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', 'ie', 'y', '', 'e', 'iu', 'ia',);
        $url = str_replace($rus, $eng, $url);
        $url = preg_replace("/ +/", " ", $url);

        $url = str_replace(' ', '-', $url);
        #$createurl=stripcslashes($createurl);
        return $url;
    }
}