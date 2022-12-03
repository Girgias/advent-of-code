<?php

$input = <<<'INPUT'
A Y
B X
C Z
INPUT;

$input = file_get_contents('input.txt');

const RESULTS_PART1 = [
    'A X' => 1 + 3,
    'A Y' => 2 + 6,
    'A Z' => 3 + 0,
    'B X' => 1 + 0,
    'B Y' => 2 + 3,
    'B Z' => 3 + 6,
    'C X' => 1 + 6,
    'C Y' => 2 + 0,
    'C Z' => 3 + 3,
];
const RESULTS_PART2 = [
    'A X' => 3 + 0,
    'A Y' => 1 + 3,
    'A Z' => 2 + 6,
    'B X' => 1 + 0,
    'B Y' => 2 + 3,
    'B Z' => 3 + 6,
    'C X' => 2 + 0,
    'C Y' => 3 + 3,
    'C Z' => 1 + 6,
];
$guide = explode("\n", $input);
$guide = array_map(fn($v) => RESULTS_PART2[$v], $guide);
$total = array_sum($guide);
var_dump($total);
