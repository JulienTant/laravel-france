<?php

use Carbon\Carbon;


function diffForHumans(Carbon $initial)
{
    $other = Carbon::now();
    $isNow = true;

    $isFuture = $initial->gt($other);

    $delta = $other->diffInSeconds($initial);

    // 30 days per month, 365 days per year... good enough!!
    $divs = array(
        'seconde' => Carbon::SECONDS_PER_MINUTE,
        'minute' => Carbon::MINUTES_PER_HOUR,
        'heure'   => Carbon::HOURS_PER_DAY,
        'jour'    => 30,
        'mois'  => Carbon::MONTHS_PER_YEAR
        );

    $unit = 'année';

    foreach ($divs as $divUnit => $divValue) {
        if ($delta < $divValue) {
            $unit = $divUnit;
            break;
        }

        $delta = floor($delta / $divValue);
    }

    if ($delta == 0) {
        $delta = 1;
    }

    $txt = $delta . ' ' . $unit;
    $txt .= $delta == 1 && $unit != 'mois' ? '' : 's';

    if ($isNow) {
        if ($isFuture) {
            return 'dans ' . $txt;
        }

        return 'il y a '. $txt;
    }

    if ($isFuture) {
        return $txt . ' après';
    }

    return $txt . ' avant';
}

function markdownThis($text)
{
    $markdown = new \dflydev\markdown\MarkdownParser();

    return $markdown->transformMarkdown($text);
}

function recursiveCopy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recursiveCopy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function hasRole($role)
{
    return Auth::guest() ? false : Auth::user()->hasRole($role);
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); 
                else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}