<?php

$input = <<<'INPUT'
R 4
U 4
L 3
D 1
R 4
D 1
L 5
R 2
INPUT;

$input = file_get_contents('input.txt');
$commands = explode("\n", $input);
$commands = array_map(fn($v) => explode(' ', $v), $commands);

//       X, Y
$head = [0, 0];
$tail = [0, 0];
$grid[0][0] = true;
foreach ($commands as [$direction, $value]) {
    $direction = match ($direction) {
        'R' => [+1, 0],
        'L' => [-1, 0],
        'U' => [0, +1],
        'D' => [0, -1],
    };
    for ($i = 0; $i < $value; ++$i) {
        $head[0] += $direction[0];
        $head[1] += $direction[1];
        //var_dump('Head:', $head);
        /* Tail is to the left of Head */
        if ($tail[0] == $head[0]-2) {
            $tail[0] += 1;
            $tail[1] = $head[1];
        }
        if ($tail[0] == $head[0]+2) {
            $tail[0] -= 1;
            $tail[1] = $head[1];
        }
        if ($tail[1] == $head[1]-2) {
            $tail[1] += 1;
            $tail[0] = $head[0];
        }
        if ($tail[1] == $head[1]+2) {
            $tail[1] -= 1;
            $tail[0] = $head[0];
        }
        if (abs($head[1]-$tail[1]) > 1 || abs($head[0]-$tail[0]) > 1) {
            var_dump('Head:', $head);
            var_dump('Tail:', $tail);
            throw new Exception("SHOULDN'T HAPPEN");
        }
        //var_dump('Tail:', $tail);
        $grid[$tail[0]][$tail[1]] = true;
    }
}

//var_dump($grid);
file_put_contents('grid_visual.txt', print_r($grid, true));
$sum = array_reduce($grid, fn ($carry, $item) => $carry + count($item), initial: 0);
var_dump($sum);
