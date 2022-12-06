<?php

$input = <<<'INPUT'
mjqjpqmgbljsphdztnvjfqwrcgsmlb
INPUT;

$input = file_get_contents('input.txt');
const N = 14;

$last = str_split(substr($input, offset: 0, length: N));
var_dump($last);
for ($i = N; $i < strlen($input); ++$i) {
    if (count(array_unique($last)) === N) {
        var_dump($i);
        exit(0);
    }
    array_shift($last);
    $last[] = $input[$i];
}
