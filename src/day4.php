<?php

$input = file(__DIR__ . "/../data/day4.txt");
$hash = "";
$pos_int = 0;
$needle = "00000"; // PART 2 => "000000"

while (!str_starts_with($hash, $needle)) {
    $pos_int++;
    $hash = md5($input . $pos_int);
}

echo $pos_int;
