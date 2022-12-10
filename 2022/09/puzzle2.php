<?php

$input = <<<'INPUT'
R 5
U 8
L 8
D 3
R 17
D 10
L 25
U 20
INPUT;

$input = file_get_contents('input.txt');
$commands = explode("\n", $input);
$commands = array_map(fn($v) => explode(' ', $v), $commands);

const KNOTS_NB = 10;
//                                           X, Y
$knots = array_fill(0, KNOTS_NB, [0, 0]);
$grid[0][0] = true;
foreach ($commands as [$directionS, $value]) {
    $direction = match ($directionS) {
        'R' => [+1, 0],
        'L' => [-1, 0],
        'U' => [0, +1],
        'D' => [0, -1],
    };
    for ($i = 0; $i < $value; ++$i) {
        $head = &$knots[0];
        $head[0] += $direction[0];
        $head[1] += $direction[1];
        for ($j = 1; $j < KNOTS_NB; ++$j) {
            $head = &$knots[$j-1];
            $tail = &$knots[$j];
            //var_dump('Head:', $head);
            // Tail is to the left of Head
            if ($tail[0] == $head[0] - 2) {
                $tail[0] += 1;
                $tail[1] += $head[1] <=> $tail[1];
            }
            if ($tail[0] == $head[0] + 2) {
                $tail[0] -= 1;
                $tail[1] -= $tail[1] <=> $head[1];
            }
            if ($tail[1] == $head[1] - 2) {
                $tail[1] += 1;
                $tail[0] += $head[0] <=> $tail[0];
            }
            if ($tail[1] == $head[1] + 2) {
                $tail[1] -= 1;
                $tail[0] -= $tail[0] <=> $head[0];
            }
            if (abs($head[1] - $tail[1]) > 1 || abs($head[0] - $tail[0]) > 1) {
                var_dump('Command: ' . $directionS . ' ' . $value);
                var_dump("Head[$j-1]:", $head);
                var_dump("Tail[$j]:", $tail);
                file_put_contents('knots_visual.txt', print_r($knots, true));
                throw new Exception("SHOULDN'T HAPPEN");
            }
        }
        //var_dump('Tail:', $tail);
        assert($tail = $knots[9]);
        $grid[$tail[0]][$tail[1]] = true;
    }
}
$sum = array_reduce($grid, fn ($carry, $item) => $carry + count($item), initial: 0);
var_dump($sum);
