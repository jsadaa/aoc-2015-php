<?php

ini_set('memory_limit', '1024M'); // Increase memory limit to avoid memory exhausted error for large iterations

$lines = file(__DIR__ . "/../data/day13.txt");

function permute($items, $perms = []): array
{
    global $permutations;

    if (empty($items)) {
        $permutations[] = $perms;
    } else {
        for ($i = 0; $i < count($items); $i++) {
            $new_items = $items;
            $new_perms = $perms;
            list($item) = array_splice($new_items, $i, 1);
            $new_perms[] = $item;
            permute($new_items, $new_perms);
        }
    }

    return $permutations;
}

function eval_changes(array $permutations, array $map): array
{
    $total_changes = [];

    foreach ($permutations as $permutation) {
        $len = count($permutation);
        $total_change = 0;

        for ($i = 0; $i < count($permutation); $i++) {
            $guest = $permutation[$i];
            $left_neighbor = $i == 0 ? $permutation[$len - 1] : $permutation[$i - 1];
            $right_neighbor = $i == ($len - 1) ? $permutation[0] : $permutation[$i + 1];
            $total_change += ($map[$guest][$left_neighbor] + $map[$guest][$right_neighbor]);
        }

        $total_changes[] = $total_change;
    }

    return $total_changes;
}

// COMPUTE HAPPINESS MAP

$map = [];
$guests = [];

foreach ($lines as $line) {
    $split = explode(" ", $line);
    $first_name = trim($split[0]);
    $last_name = trim(str_replace('.', '', $split[count($split) - 1]));
    $units = preg_replace("/[^0-9]/", '', $line);

    $map[$first_name][$last_name] = str_contains($line, 'gain') ? (int)$units : -(int)$units;
    $guests[] = $first_name;
}

$guests = array_unique($guests);

// PART 1

$permutations = [];
$permutations = permute($guests);
$total_changes = eval_changes($permutations, $map);

echo max($total_changes) . PHP_EOL;

// PART 2

foreach ($guests as $guest) {
    $map["Me"][$guest] = 0;
    $map[$guest]["Me"] = 0;
}

$guests[] = "Me";

$permutations = [];
$permutations = permute($guests);
$total_changes = eval_changes($permutations, $map);

echo max($total_changes) . PHP_EOL;
