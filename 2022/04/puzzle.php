<?php

$input = <<<'INPUT'
2-4,6-8
2-3,4-5
5-7,7-9
2-8,3-7
6-6,4-6
2-6,4-8
INPUT;

$input = file_get_contents('input.txt');

/* Part 1 */
$pairs = explode("\n", $input);
$pairs = array_map(fn($v) => explode(",", $v), $pairs);
$pairs = array_map(fn($v) => array_map(fn($e) => explode('-', $e), $v), $pairs);
// Compare the beginning and ending of the ranges
$pairs = array_map(fn($v) => [$v[0][0] <=> $v[1][0], $v[0][1] <=> $v[1][1]], $pairs);
// Completely overlap?
$pairs = array_map(fn($v) => $v[0] != $v[1] || ($v[0] == 0 && $v[1] == 0), $pairs);
$total = array_sum($pairs);
var_dump($total);

/* Part 2 */
$pairs = explode("\n", $input);
$pairs = array_map(fn($v) => explode(",", $v), $pairs);
$pairs = array_map(fn($v) => array_map(fn($e) => explode('-', $e), $v), $pairs);
// Compare the start range of one with the end range of the other
$pairs = array_map(fn($v) => [$v[0][0] <=> $v[1][1], $v[0][1] <=> $v[1][0]], $pairs);
// Has overlap?
$pairs = array_map(fn($v) => $v[0] != $v[1] || ($v[0] == 0 && $v[1] == 0), $pairs);
$total = array_sum($pairs);
var_dump($total);

