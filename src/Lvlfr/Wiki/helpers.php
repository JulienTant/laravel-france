<?php

function slugWithSlash($str, $sep)
{
    $parts = explode('/', $str);
    foreach ($parts as &$part) {
        $part = \Str::slug($part, $sep);
    }
    return implode('/', $parts);
}