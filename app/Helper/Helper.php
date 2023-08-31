<?php

function formatedSize($bytes, $precision = 1)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function fcmSpecificUserTopics($userId, $language)
{
    /*  $topics = array();

    foreach ($languages as $language)
        array_push($topics, 'User_' . $userId . '_' . $language); */

    return 'User_' . $userId . '_' . $language;
}

function fcmAllUserTopics($languages)
{
    /*   $topics = array();

    foreach ($languages as $language)
        array_push(); */

    return  'User_' . $languages;
}
