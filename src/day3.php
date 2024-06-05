<?php

function update_pos(string $direction, array $pos): array
{
     match ($direction) {
        "^" => $pos[1]++,
        "v" => $pos[1]--,
        ">" => $pos[0]++,
        "<" => $pos[0]--,
        default => null
    };

     return $pos;
}

$line = file_get_contents(__DIR__ . "/../data/day3.txt");
$split = str_split($line);

// PART 1

$pos = [0,0];
$cache = ["0,0"];

foreach ($split as $direction) {
    $pos = update_pos($direction, $pos);
    $cache[] = $pos[0] . "," . $pos[1];
}

echo count(array_unique($cache)) . PHP_EOL;

// PART 2

$santa_pos = [0,0];
$robot_pos = [0,0];
$cache = ["0,0"];

for ($i = 0; $i < count($split); $i += 2) {
    $dir_s = $split[$i];
    $dir_r = $split[$i + 1];

    $santa_pos = update_pos($dir_s, $santa_pos);
    $robot_pos = update_pos($dir_r, $robot_pos);

    $cache[] = $santa_pos[0] . "," . $santa_pos[1];
    $cache[] = $robot_pos[0] . "," . $robot_pos[1];
}

echo count(array_unique($cache)) . PHP_EOL;
