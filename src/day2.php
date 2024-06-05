<?php

$lines = file(__DIR__ . "/../data/day2.txt");

function calc_paper_surface(string $line): int
{
    $line = trim($line);
    $split = explode("x", $line);

    $l = (int) $split[0];
    $w = (int) $split[1];
    $h = (int) $split[2];

    $lw = $l * $w;
    $wh = $w * $h;
    $hl = $h * $l;

    $min = min([$lw, $wh, $hl]);

    return (2 * $lw) + (2 * $wh) + (2 * $hl) + $min;
}

function calc_ribbon_len(string $line): int
{
    $line = trim($line);
    $split = explode("x", $line);

    $l = (int) $split[0];
    $w = (int) $split[1];
    $h = (int) $split[2];
    $dimensions = [$l, $w, $h];

    sort($dimensions);
    array_pop($dimensions);

    return ($dimensions[0] * 2) + ($dimensions[1] * 2) + ($l * $w * $h);
}

// PART 1

$total_surface = array_reduce(
    $lines,
    fn (int $carry, string $line) => $carry + calc_paper_surface($line),
    0
);

echo $total_surface . PHP_EOL;

// PART 2

$total_feet = array_reduce(
    $lines,
    fn (int $carry, string $line) => $carry + calc_ribbon_len($line),
    0
);

echo $total_feet . PHP_EOL;
