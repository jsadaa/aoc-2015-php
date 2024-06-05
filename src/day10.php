<?php

ini_set('memory_limit', '1024M'); // Increase memory limit to avoid memory exhausted error for large iterations

$iterations = 50; // 40 for part 1
$input = str_split('1321131112');

for ($i = 0; $i < $iterations; $i++) {
    $next_input_str = "";

    for ($j = 0; $j < count($input); $j++) {
        $counter = 1;

        while ($j + 1 < count($input) && $input[$j] === $input[$j + 1]) {
            $counter++;
            $j++;
        }

        $next_input_str .= $counter . $input[$j];
    }

    $input = str_split($next_input_str);
}

echo count($input) . PHP_EOL;
