<?php

$lines = file(__DIR__ . "/../data/day8.txt");

$in_code_len = 0;
$in_mem_len = 0;
$encoded_len = 0;

function str_mem_len($string): int
{
    $string = str_replace(['\\"', '\\\\'], ['"', '\\'], trim($string, '"'));
    $string = preg_replace_callback('/\\\\x([0-9A-Fa-f]{2})/', function($matches) {
        return chr(hexdec($matches[1]));
    }, $string);

    return strlen($string);
}

foreach ($lines as $line) {
    $line = trim($line);
    $in_code_len += strlen($line);
    $in_mem_len += str_mem_len($line);
    $encoded_len += strlen('"' . addslashes($line) . '"');
}

// PART 1

echo $in_code_len . PHP_EOL;
echo $in_mem_len . PHP_EOL;
echo $in_code_len - $in_mem_len . PHP_EOL;
echo PHP_EOL;


// PART 2

echo $in_code_len . PHP_EOL;
echo $encoded_len . PHP_EOL;
echo $encoded_len - $in_code_len;
