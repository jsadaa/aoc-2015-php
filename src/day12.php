<?php

$line = file_get_contents(__DIR__ . '/../data/day12.txt');

function arr_count_int(array $array): int
{
    return array_reduce($array, function ($carry, $item) {
        return $carry + (is_array($item) ? arr_count_int($item) : (is_int($item) ? $item : 0));
    }, 0);
}

function json_count_int(array|object $structure, bool $parent_is_obj): int
{
    $acc = 0;

    foreach ($structure as $item) {
        switch (true) {
            case $item == "red" && $parent_is_obj:
                break 2;
            case is_object($item) && !in_array("red", (array) $item, true):
                $acc += json_count_int($item, true);
                break;
            case is_array($item):
                $acc += json_count_int($item, false);
                break;
            case is_int($item):
                $acc += $item;
                break;
            default:
        }
    }

    return $acc;
}

// PART 1

$input_arr = json_decode($line, true);

echo arr_count_int($input_arr) . PHP_EOL;

// PART 2

$input_arr = json_decode($line);

echo $line[0] === "{" ?
    json_count_int($input_arr, true) :
    json_count_int($input_arr, false);
