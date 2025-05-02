<?php 
// Truncate Copy
function trimStringToFullWord($length, $string)
{
    if (mb_strlen($string) <= $length) {
        $string = $string; //do nothing
    } else {
        $string = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length)) . '...';
    }
    return $string;
}

// Return Cleaned Phone Number
function cleanPhone($phoneNumber)
{
    $cleanedNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    return $cleanedNumber;
}

// Parse Link field and return a target value
function returnLinkTarget($link)
{
    if (isset($link) && is_array($link)) {
        if (isset($link['target']) && $link['target'] != '') {
            return $link['target'];
        } else {
            return '_self';
        }
    } else {
        return '_self';
    }
}

// Return buttons for use in templates
function buildButton($btnObject, $classes)
{
    if (isset($btnObject) && $btnObject != '') {
        $btnClass = '';
        $btnTarget = '_self';

        if (isset($classes) && $classes != '') {
            $btnClass = $classes;
        }

        if (isset($btnObject['target']) && $btnObject['target'] != '') {
            $btnTarget = $btnObject['target'];
        }

        return '<p class="btn-p"><a href="' . $btnObject['url'] . '" target="' . $btnTarget . '" class="btn ' . $btnClass . '">' . $btnObject['title'] . '</a></p>';
    } else {
        return '';
    }
}

// Get Icon Markup from SVG file
function GetIconMarkup($url)
{
    $html = file_get_contents($url);

    return $html;
}