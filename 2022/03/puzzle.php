<?php

$input = <<<'INPUT'
vJrwpWtwJgWrhcsFMMfFFhFp
jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL
PmmdzqPrVvPwwTWBwg
wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn
ttgJtRGJQctTZtZT
CrZsJsPPZsGzwwsLwLmpwMDw
INPUT;

$input = file_get_contents('input.txt');
const ALPHABET_SHIFT = 26;

/* Part 1 */
$rucksacks = explode("\n", $input);
$rucksacks = array_map(fn($v) => str_split($v, strlen($v)/2), $rucksacks);
$rucksacks = array_map(fn($v) => array_map('str_split', $v), $rucksacks);
$rucksacks = array_map(fn($v) => array_intersect(...$v), $rucksacks);
/* We take the ASCII value of the char, but because it is not continuous we first remove the gap by modding by 97 (ascii a)
 * We then shift by 26 so that after our second mode of 65 (ascii A) + 26 both lowercase and uppercase don't overlap
 * We perform a third shift and mod by 52 so that we reverse the order of lower and uppercase, add 1 to get priority from 1 to 52
 */
$rucksacks = array_map(fn($v) => (((((ord(current($v))%97)+ALPHABET_SHIFT)%(65+ALPHABET_SHIFT))+ALPHABET_SHIFT)%52)+1, $rucksacks);
$total = array_sum($rucksacks);
var_dump($total);

/* Part 2 */
$groups = [];
$rucksacks = explode("\n", $input);
while ($rucksacks) {
    $groups[] = array_splice($rucksacks, offset:0, length: 3);
}
$groups = array_map(fn($v) => array_map('str_split', $v), $groups);
$groups = array_map(fn($v) => array_intersect(...$v), $groups);
$groups = array_map(fn($v) => (((((ord(current($v))%97)+ALPHABET_SHIFT)%(65+ALPHABET_SHIFT))+ALPHABET_SHIFT)%52)+1, $groups);
$total = array_sum($groups);
var_dump($total);

