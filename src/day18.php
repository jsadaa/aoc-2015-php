<?php

$lines = file(__DIR__ . "/../data/day18.txt");
$grid = array_map(
    fn ($line) => str_split(trim($line)),
    $lines
);

function pre_render_grid(array $grid): string
{
    $pre_render = "";
    $count_i = count($grid);

    for ($i = 0; $i < $count_i; $i++) {
        $pre_render .= implode("", $grid[$i]) . PHP_EOL;
    }

    return $pre_render;
}

function print_grid(string $pre_render): void
{
    echo $pre_render;
    usleep(5000);
    system("clear");
}

function eval_state_part_1(int $x, int $y, array &$grid): string
{
    $n_on = 0;
    $n_off = 0;
    $adj = [[1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0], [-1, -1], [0, -1], [1, -1]];
    $is_on = $grid[$x][$y] == "#";

    foreach ($adj as $pos) {
        if (isset($grid[$x + $pos[0]][$y + $pos[1]])) {
            match ($grid[$x + $pos[0]][$y + $pos[1]]) {
                "#" => $n_on++,
                default => $n_off++
            };
        } else {
            $n_off++;
        }
    }

    if ($is_on) {
        return $n_on == 2 || $n_on == 3 ? "#" : ".";
    }

    return $n_on == 3 ? "#" : ".";
}

// PART 1

$steps = 100;

// Store the pre-rendered grids as an array of strings, then print after to have a nice and fluid animation
$pre_renders = [pre_render_grid($grid)];

// PART 2: corners are always on
$grid[0][0] = "#";
$grid[0][count($grid[0]) - 1] = "#";
$grid[count($grid) - 1][0] = "#";
$grid[count($grid) - 1][count($grid[0]) - 1] = "#";

for ($k = 0; $k < $steps; $k++) {
    $next_grid = $grid;
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {

            if (($i == 0 || $i == count($grid) - 1) && ($j == 0 || $j == count($grid[$i]) - 1)) {
                continue;
            } // PART 2: corners are always on

            $current_state = $grid[$i][$j];
            $next_state = eval_state_part_1($i, $j, $grid);
            $next_grid[$i][$j] = $next_state;
        }
    }

    $grid = $next_grid;
    $pre_renders[] = pre_render_grid($grid);
}

// PRINT THE AMAZING ANIMATION !!!

foreach ($pre_renders as $render) {
    print_grid($render);
}

// PART 1 & 2

$count_on = array_reduce(
    $grid,
    fn (int $carry, array $row) => $carry + count(array_filter($row, fn (string $light) => $light == "#")),
    0
);

echo $count_on;
