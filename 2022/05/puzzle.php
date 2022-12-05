<?php

$input = <<<'INPUT'
    [D]    
[N] [C]    
[Z] [M] [P]
 1   2   3 

move 1 from 2 to 1
move 3 from 1 to 3
move 2 from 2 to 1
move 1 from 1 to 2
INPUT;

$input = file_get_contents('input.txt');

[$inputStacks, $moves] = explode("\n\n", $input);

$inputStacks = explode("\n", $inputStacks);
$inputStacks = array_map(fn($v) => str_split($v, 4), $inputStacks);
$inputStacks = array_map(fn($v) => str_replace(['[', ']', ' '], '', $v), $inputStacks);
array_pop($inputStacks); // Don't care about the number line
$inputStacks = array_reverse($inputStacks);

$stacks = array_fill(1, count($inputStacks[0]), []);
foreach ($inputStacks as $stackLine) {
    foreach ($stackLine as $key => $item) {
        if ($item) {
            $stacks[$key+1][] = $item;
        }
    }
}

$moves = str_replace(['move ', ' from ', ' to '], ['', ',', ','], $moves);
$moves = explode("\n", $moves);
$moves = array_map(fn($v) => explode(',', $v), $moves);

foreach ($moves as $move) {
    /* Part 1 */
    /*
    for ($i = 0; $i < $move[0]; ++$i) {
        $stacks[$move[2]][] = array_pop($stacks[$move[1]]);
    }
    */
    /* Part 2 */
    $stacks[$move[2]] = [...$stacks[$move[2]], ...array_splice($stacks[$move[1]], -$move[0], $move[0])];
}

$top_elements = @array_map('end', $stacks); // Ignore not by ref warning
$top_elements = array_reduce($top_elements, fn($carry, $item) => $carry.$item, '');
var_dump($top_elements);

