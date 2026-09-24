<?php

namespace Core\Helpers;

function dateFormator(string $date, string $format = "d/m/Y"): string
{
    return date($format, strtotime($date));
}


function slugify(string $text): string
{
    // replace non letter or digits by -   
    $text2 = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // unset $text to free up space
    unset($text);
    // trim   
    $text2 = trim($text2, '-');

    // transliterate   
    $text2 = iconv('utf-8', 'us-ascii//TRANSLIT', $text2);

    // lowercase
    $text2 = strtolower($text2);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text2);

    // unset $text2 to free up space
    unset($text2);

    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function truncate(string $text, $limit = 100)
{
    if (strlen($text) <= $limit) return $text;


    // Coupe à la limite
    $text = substr($text, 0, $limit);
    // Recherche la position du dernier espace dans la chaîne tronquée
    $last_space = strrpos($text, ' ');
    // Recoupe la chaîne à cet espace
    return substr($text, 0, $last_space) . '...';
}
