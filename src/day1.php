<?php

$line = file(__DIR__ . "/../data/day1.txt");
$split = str_split($line);

// PART 1

$floor = 0;

foreach ($split as $par) {
    match ($par) {
        '(' => $floor += 1,
        ')' => $floor -= 1,
        default => null
    };
}

echo $floor . PHP_EOL;

// PART 2

$floor = 0;
$index = 0;

for ($i = 0; $i < count($split); $i++) {
    match ($split[$i]) {
        '(' => $floor += 1,
        ')' => $floor -= 1,
        default => null
    };

    if ($floor < 0) {
        $index = $i + 1;
        break;
    }
}

echo $index . PHP_EOL;
