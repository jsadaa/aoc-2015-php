<?php

$lines = file(__DIR__ . "/../data/day5.txt");

// PART 1

echo count(
    array_filter(
        $lines,
        function (string $line) {
            $line = trim($line);

            $three_vowels = preg_match_all("/[aeiou]/", $line) >= 3;
            $twice_in_a_row = preg_match("/(.)\\1/", $line) == 1;
            $disallowed_strings = preg_match("/ab|cd|pq|xy/", $line) == 1;

            return $three_vowels && $twice_in_a_row && !$disallowed_strings;
        }
    )
) . PHP_EOL;

// PART 2

echo count(
    array_filter(
        $lines,
        function (string $line) {
            $line = trim($line);

            $pair_repeats = preg_match("/(..).*\\1/", $line);
            $repeats_around_another_char = preg_match("/(.).\\1/", $line);

            return $pair_repeats && $repeats_around_another_char;
        }
    )
);
