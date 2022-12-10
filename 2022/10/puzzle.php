<?php

$input = <<<'INPUT'
noop
addx 3
addx -5
INPUT;

$input = file_get_contents('input.txt');

$instructions = array_reverse(explode("\n", $input));
$add = 0;
$register = 1;
$signalStrengthSum = 0;

$line = -1;

for ($cycle = 1; ; $cycle++) {
    /* Part 1 */
    if (($cycle - 20) % 40 === 0) {
        $signalStrength = $cycle * $register;
        //echo "Cycle: $cycle; Register: $register; Signal Strength: $signalStrength\n";
        $signalStrengthSum += $signalStrength;
    }
    /* Part 2: CRT */
    $offset = ($cycle-1) % 40;
    if ($offset == 0) {
        ++$line;
    }
    $char = ($register === $offset || $register-1 === $offset || $register+1 === $offset) ? '#' : '.';
    $crt[$line][$offset] = $char;
    /* CPU */
    if ($add) {
        $register += $add;
        $add = null;
    } else if ($instructions) {
        $instruction = array_pop($instructions);
        //echo "Instruction: $instruction\n";
        if ($instruction !== 'noop') {
            [, $add] = explode(' ', $instruction);
        }
    } else {
        break;
    }
    //echo "Cycle End: $cycle\nRegister: $register\n";
}
echo "Finished\nSignal Strenght Sum: $signalStrengthSum\n";
$crtDisplay = array_map(fn($v) => join('', $v), $crt);
$crtDisplay = implode("\n", $crtDisplay);
echo $crtDisplay, "\n";
