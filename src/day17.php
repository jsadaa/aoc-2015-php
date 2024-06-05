<?php

function generateCombinations(
    array $containers,
    int $target,
    int $current_index,
    array $current_comb,
    array &$all_combs
): void
{
    if ($target === 0) {
        $all_combs[] = $current_comb;
        return;
    }

    if ($target < 0 || $current_index >= count($containers)) {
        return;
    }

    $current_container = $containers[$current_index];
    $current_comb[] = $current_container;

    generateCombinations($containers, $target - $current_container, $current_index + 1, $current_comb, $all_combs);
    array_pop($current_comb);

    // Backtrack
    generateCombinations($containers, $target, $current_index + 1, $current_comb, $all_combs);
}

$containers = [50,44,11,49,42,46,18,32,26,40,21,7,18,43,10,47,36,24,22,40];
$target = 150;

$all_combs = [];
generateCombinations($containers, $target, 0, [], $all_combs);

// PART 1

echo count($all_combs) . PHP_EOL;

// PART 2

$min = array_reduce(
    $all_combs,
    fn (int $carry, array $comb) => min($carry, count($comb)),
    count($containers)
);

$ways = array_filter(
    $all_combs,
    fn (array $comb) => count($comb) == $min
);

echo count($ways);
