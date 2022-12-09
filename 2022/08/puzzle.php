<?php

$input = <<<'INPUT'
30373
25512
65332
33549
35390
INPUT;

$input = file_get_contents('input.txt');
$trees = explode("\n", $input);
$trees = array_map('str_split', $trees);
$treesPerRow = count($trees[0]);
$treesPerCol = count($trees);

/* Part 1 */
$colLastIndex = $treesPerCol-1;
$rowLastIndex = $treesPerRow-1;

$visibleTrees = [];

/* Rows */
foreach ($trees as $index => $row) {
    $rowRTL = $rowLTR = $row;
    $heightLTR = $rowLTR[0];
    $heightRTL = $rowRTL[$rowLastIndex];
    for ($i = 1; $i <= $rowLastIndex; ++$i) {
        if ($heightLTR < $rowLTR[$i]) {
            $heightLTR = $rowLTR[$i];
        } else {
            unset($rowLTR[$i]);
        }
    }
    for ($i = $rowLastIndex-1; $i >= 0; --$i) {
        if ($heightRTL < $rowRTL[$i]) {
            $heightRTL = $rowRTL[$i];
        } else {
            unset($rowRTL[$i]);
        }
    }
    $visibleTrees[$index] = $rowLTR + $rowRTL;
}

/* Cols */
for ($i = 0; $i < $treesPerRow; ++$i) {
    $heightTTB = $trees[0][$i]; // Top To Bottom
    $heightBTT = $trees[$colLastIndex][$i]; // Bottom To Top
    $visibleTreesTTB[0][$i] = $heightTTB;
    $visibleTreesBTT[$colLastIndex][$i] = $heightBTT;
    for ($j = 1; $j <= $colLastIndex; ++$j) {
        if ($heightTTB < $trees[$j][$i]) {
            $heightTTB = $trees[$j][$i];
            $visibleTreesTTB[$j][$i] = $heightTTB;
        }
    }
    for ($j = $colLastIndex-1; $j >= 0; --$j) {
        if ($heightBTT < $trees[$j][$i]) {
            $heightBTT = $trees[$j][$i];
            $visibleTreesBTT[$j][$i] = $heightBTT;
        }
    }
}

// Recursive union
for ($i = 0; $i < $treesPerRow; ++$i) {
    if (array_key_exists($i, $visibleTreesTTB)) {
        $visibleTrees[$i] += $visibleTreesTTB[$i];
    }
    if (array_key_exists($i, $visibleTreesBTT)) {
        $visibleTrees[$i] += $visibleTreesBTT[$i];
    }
}
$sum = array_reduce($visibleTrees, fn ($carry, $item) => $carry + count($item), initial: 0);
var_dump($sum);

/* Part 2 */
$bestScenicScore = 0;
for ($i = 1; $i < $treesPerRow-1; ++$i) {
    for ($j = 1; $j < $treesPerCol-1; ++$j) {
        $height = $trees[$i][$j];
        $scenicScore = 1;
        /* Check left of */
        $nbVisible = 0;
        for ($left = $j-1; $left >= 0; --$left) {
            ++$nbVisible;
            if ($trees[$i][$left] >= $height) {
                break;
            }
        }
        $scenicScore *= $nbVisible;
        /* Check right of */
        $nbVisible = 0;
        for ($right = $j+1; $right <= $colLastIndex; ++$right) {
            ++$nbVisible;
            if ($trees[$i][$right] >= $height) {
                break;
            }
        }
        $scenicScore *= $nbVisible;
        /* Check above of */
        $nbVisible = 0;
        for ($up = $i-1; $up >= 0; --$up) {
            ++$nbVisible;
            if ($trees[$up][$j] >= $height) {
                break;
            }
        }
        $scenicScore *= $nbVisible;
        /* Check below of */
        $nbVisible = 0;
        for ($down = $i+1; $down <= $rowLastIndex; ++$down) {
            ++$nbVisible;
            if ($trees[$down][$j] >= $height) {
                break;
            }
        }
        $scenicScore *= $nbVisible;
        if ($scenicScore > $bestScenicScore) {
            $bestScenicScore = $scenicScore;
        }
    }
}
var_dump($bestScenicScore);

