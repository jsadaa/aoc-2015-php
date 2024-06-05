<?php

$lines = file(__DIR__ . "/../data/day7.txt");

if (!$lines) {
    echo "Error reading file";
    exit();
}

$signals = [];
$operations = [];

function evaluate(string $wire): int
{
    global $operations, $signals;

    if (is_numeric($wire)) {
        return (int) $wire;
    }

    if (isset($signals[$wire])) {
        return $signals[$wire];
    }

    $op = $operations[$wire];

    $signals[$wire] = match (true) {
        str_contains($op, 'AND') => (function($op) {
            [$x, , $y] = explode(' ', $op);
            return evaluate($x) & evaluate($y);
        })($op),
        str_contains($op, 'OR') => (function($op) {
            [$x, , $y] = explode(' ', $op);
            return evaluate($x) | evaluate($y);
        })($op),
        str_contains($op, 'LSHIFT') => (function($op) {
            [$x, , $shift] = explode(' ', $op);
            return evaluate($x) << (int)$shift;
        })($op),
        str_contains($op, 'RSHIFT') => (function($op) {
            [$x, , $shift] = explode(' ', $op);
            return evaluate($x) >> (int)$shift;
        })($op),
        str_contains($op, 'NOT') => (function($op) {
            [, $x] = explode(' ', $op);
            return ~evaluate($x) & 0xFFFF;
        })($op),
        default => evaluate($op),
    };

    return $signals[$wire];
}

function parse_instruction(string $line): array
{
    $split = explode("->", $line);
    $operation = trim($split[0]);
    $destination = trim($split[1]);

    return [$destination, $operation];
}

foreach ($lines as $line) {
    [$destination, $operation] = parse_instruction($line);
    $operations[$destination] = $operation;
}

$a = evaluate("a");

echo $a . PHP_EOL;

$signals = [];
$signals["b"] = $a;

echo evaluate("a");
