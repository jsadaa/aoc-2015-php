<?php

$lines = file(__DIR__ . "/../data/day14.txt");
$seconds = 2503;
$reindeer_map = [];
$distances = [];

foreach ($lines as $line) {
    $split = explode(" ", $line);
    $reindeer_map[$split[0]] = [
        "speed" => (int) $split[3],
        "fly" => (int) $split[6],
        "rest" => (int) $split[13],
        "is_flying" => true,
        "current_counter" => 0, // for PART 2
    ];
}

// PART 1

foreach ($reindeer_map as $reindeer => &$props) {
    $i = 0;
    $distance = 0;

    while ($i < $seconds) {
       if ($props["is_flying"]) {
           $remainder = $seconds - $i;
           $distance += $remainder < $props["fly"] ?
               ($remainder * $props["speed"]) :
               ($props["fly"] * $props["speed"]);

           $i += $props["fly"];
           $props["is_flying"] = false;
       } else {
           $i += $props["rest"];
           $props["is_flying"] = true;
       }
    }

    $distances[$reindeer] = $distance;
    $props["is_flying"] = true; // reset for PART 2
}

echo max($distances) . PHP_EOL;

// PART 2

$distances = array_fill_keys(array_keys($reindeer_map), 0);
$scores = array_fill_keys(array_keys($reindeer_map), 0);

for ($j = 1; $j <= $seconds; $j++) {
    foreach ($reindeer_map as $reindeer => &$props) {
        if ($props["is_flying"]) {
            $distances[$reindeer] += $props["speed"];
            $props["current_counter"]++;
            if ($props["current_counter"] == $props["fly"]) {
                $props["is_flying"] = false;
                $props["current_counter"] = 0;
            }
        } else {
            $props["current_counter"]++;
            if ($props["current_counter"] == $props["rest"]) {
                $props["is_flying"] = true;
                $props["current_counter"] = 0;
            }
        }
    }

    $max_distance = max($distances);
    $leaders = array_keys($distances, $max_distance);

    foreach ($leaders as $leader) {
        $scores[$leader]++;
    }
}

echo max($scores) . PHP_EOL;
