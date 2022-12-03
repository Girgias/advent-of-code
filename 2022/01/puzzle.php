<?php

$input = <<<'INPUT'
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
INPUT;

$input = file_get_contents('input.txt');

$elves = explode("\n\n", $input);
$elves = array_map(fn($v) => explode("\n", $v), $elves);
$elves = array_map('array_sum', $elves);
rsort($elves);
// top1
$calories = current($elves);
$top3 = array_slice($elves, 0, length: 3);
$calories = array_sum($top3);
var_dump($calories);
