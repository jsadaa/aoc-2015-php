<?php

$lines = file(__DIR__ . "/../data/day6.txt");

class Position
{
    public function __construct(
        public int $x,
        public int $y,
    )
    {

    }
}

function extract_pos(string $subject): Position
{
    $split = explode(',', $subject);
    return new Position((int) $split[0], (int) $split[1]);
}

function eval_pt_one(string $action, int $state): int
{
    return match ($action) {
        "on" => 1,
        "off" => 0,
        "toggle" => $state == 1 ? 0 : 1,
    };
}

function eval_pt_two(string $action, int $state): int
{
    return match ($action) {
        "on" => $state + 1,
        "off" => $state > 0 ? $state - 1 : 0,
        "toggle" => $state + 2,
    };
}

// PART 1 & 2

$grid = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach ($lines as $line) {
    preg_match("/(\w+\s+)(\d+,\d+) through (\d+,\d+)/", $line, $matches);

    $action = trim($matches[1]);
    $from = extract_pos($matches[2]);
    $to = extract_pos($matches[3]);

    for ($x = $from->x; $x <= $to->x ; $x++) {
        for ($y = $from->y; $y <= $to->y; $y++) {
            // PART 1 => eval_pt_one($action, $grid[$x][$y]);
            $grid[$x][$y] = eval_pt_two($action, $grid[$x][$y]);
        }
    }
}

echo array_reduce(
    $grid,
    fn (int $carry, array $column) => $carry + array_sum($column),
    0
);
