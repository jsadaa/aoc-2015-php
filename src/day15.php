<?php

ini_set('memory_limit', '1024M'); // Increase memory limit to avoid memory exhausted error for large iterations

$lines = file(__DIR__ . "/../data/day15.txt");
$map = [];

function generateDistributions($n, $total, $current = [], &$results = []): void
{
    if ($n == 1) {
        $current[] = $total;
        $results[] = $current;
        return;
    }

    for ($i = 0; $i <= $total; $i++) {
        $newCurrent = array_merge($current, [$i]);
        generateDistributions($n - 1, $total - $i, $newCurrent, $results);
    }
}

foreach ($lines as $line) {
    $split = explode(" ", $line);
    $map[] = [
        "cap" => (int) trim($split[2], ","),
        "dur" => (int) trim($split[4], ","),
        "flav" => (int) trim($split[6], ","),
        "text" => (int) trim($split[8], ","),
        "cal" => (int) trim($split[10])
    ];
}

$count = count($map);
$distributions = [];
generateDistributions($count, 100, [], $distributions);

$scores = [];

// PART 1

foreach ($distributions as $distribution) {
    $cap = 0;
    $dur = 0;
    $flav = 0;
    $text = 0;
    $cal = 0;

    for ($i = 0; $i < $count; $i++) {
        $cap += ($distribution[$i] * $map[$i]["cap"]);
        $dur += ($distribution[$i] * $map[$i]["dur"]);
        $flav += ($distribution[$i] * $map[$i]["flav"]);
        $text += ($distribution[$i] * $map[$i]["text"]);
        $cal += ($distribution[$i] * $map[$i]["cal"]);
    }

    // THIS FOR PART 2
    if ($cal !== 500) {
        continue;
    }
    // END PART 2

    $cap = max(0, $cap);
    $dur = max(0, $dur);
    $flav = max(0, $flav);
    $text = max(0, $text);

    $score = $cap * $dur * $flav * $text;
    $scores[] = $score;
}

echo max($scores) . PHP_EOL;
