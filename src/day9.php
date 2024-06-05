<?php

$lines = file(__DIR__ . "/../data/day9.txt");
$cities = [];
$map = [];

// PART 1 AND 2

function array_get_permutations(array $array): array
{
    $result = [];

    function permute($items, $current_permutation, &$result): void
    {
        if (empty($items)) {
            $result[] = $current_permutation;
            return;
        }

        for ($i = 0; $i < count($items); $i++) {
            $new_items = $items;
            $new_permutation = $current_permutation;
            array_splice($new_items, $i, 1);
            $new_permutation[] = $items[$i];
            permute($new_items, $new_permutation, $result);
        }
    }

    permute($array, [], $result);

    return $result;
}

foreach ($lines as $line) {
    [$city1, , $city2, ,$distance] = explode(" ", $line);
    array_push($cities, $city1, $city2);
    $map[$city1 . $city2] = $distance;
}

$cities = array_values(array_unique($cities));
$permutations = array_get_permutations($cities);
$distances = [];

foreach ($permutations as $permutation) {
    $distance = 0;

    for ($i = 0; $i < count($permutation) - 1; $i++) {
        $distance += $map[$permutation[$i] . $permutation[$i + 1]] ?? $map[$permutation[$i + 1] . $permutation[$i]];
    }

    $distances[] = $distance;
}

echo min($distances) . PHP_EOL;
echo max($distances);
