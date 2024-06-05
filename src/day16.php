<?php

$lines = file(__DIR__ . "/../data/day16.txt");

$ref_props = [
    "children",
    "cats",
    "samoyeds",
    "pomeranians",
    "akitas",
    "vizslas",
    "goldfish",
    "trees",
    "cars",
    "perfumes",
];

$ref_vals = [
    "children" => 3,
    "cats" => 7,
    "samoyeds" => 2,
    "pomeranians" => 3,
    "akitas" => 0,
    "vizslas" => 0,
    "goldfish" => 5,
    "trees" => 3,
    "cars" => 2,
    "perfumes" => 1,
];

// My approach is to generate a score for each aunt based on the properties she has.

function eval_score_pt_1(array $props): int
{
    global $ref_props, $ref_vals;
    $score = 0;

    foreach ($props as $prop => $value) {
        if (in_array($prop, $ref_props) && $value === $ref_vals[$prop]) {
            $score += 2;
            continue;
        }

        if (!in_array($prop, $ref_props) && $value === 0) {
            $score += 1;
        }
    }

    return $score;
}

function eval_score_pt_2(array $props): int
{
    global $ref_props, $ref_vals;
    $score = 0;

    foreach ($props as $prop => $value) {
        if (in_array($prop, ["trees", "cats"]) && $value > $ref_vals[$prop]) {
            $score += 3;
            continue;
        }

        if (in_array($prop, ["pomeranians", "goldfish"]) && $value < $ref_vals[$prop]) {
            $score += 3;
            continue;
        }

        if (in_array($prop, $ref_props) && $value === $ref_vals[$prop]) {
            $score += 2;
            continue;
        }

        if (!in_array($prop, $ref_props) && $value === 0) {
            $score += 1;
        }
    }

    return $score;
}

$map = [];
$scores = [];

foreach ($lines as $line) {
    $split = explode(" ", $line);
    $index = (int) trim($split[1], ":");
    $map[$index] = [
        trim($split[2], ":") => (int) trim($split[3], ","),
        trim($split[4], ":") => (int) trim($split[5], ","),
        trim($split[6], ":") => (int) trim($split[7]),
    ];

    // PART 1 : $scores[$index] = eval_score_pt_1($map[$index]);
    $scores[$index] = eval_score_pt_2($map[$index]); // PART 2
}

echo array_keys(
    $scores,
    max($scores)
)[0];
